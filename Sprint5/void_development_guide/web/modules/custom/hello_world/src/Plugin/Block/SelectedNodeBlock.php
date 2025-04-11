<?php

// Declare the correct namespace for Block plugins in the hello_world module.
namespace Drupal\hello_world\Plugin\Block;

// Import all necessary classes using 'use' statements at the top.
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface; // Use the NodeInterface for type hinting

/**
 * Displays title of selected node and lists other nodes of the same type.
 *
 * This is the annotation that defines the plugin to Drupal.
 * Make sure the ID is unique and the labels/category are correct.
 *
 * @Block(
 *   id = "hello_world_selected_node_block",
 *   admin_label = @Translation("Selected Node Info Block"),
 *   category = @Translation("Hello World"),
 * )
 */
class SelectedNodeBlock extends BlockBase implements ContainerFactoryPluginInterface
{
  // The class must extend BlockBase and implement ContainerFactoryPluginInterface for DI.

  /**
   * Configuration Factory service.
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Entity Type Manager service.
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Current User service.
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs the block plugin instance.
   * This is where injected services are assigned to class properties.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user)
  {
    // Call the parent constructor is important.
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    // Assign the injected services to the class properties.
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   * Handles dependency injection. Drupal calls this static method to create the object.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    // Create a new instance of this class ('static').
    // Get the required services from the service container using $container->get().
    // Pass the services to the __construct() method.
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   * Builds the render array for the block content. This is the main logic.
   */
  public function build()
  {
    $selected_title = $this->t('No node selected.'); // Default title
    $related_titles = []; // Default empty list for related titles

    // 1. Get the saved NID from our module's configuration.
    // 'hello_world.settings' is the config object name.
    // 'selected_node_nid' is the key within that config object.
    $nid = $this->configFactory->get('hello_world.settings')->get('selected_node_nid');

    // Proceed only if we have a valid numeric NID saved.
    if ($nid && is_numeric($nid)) {
      // 2. Load the node using the Entity Type Manager service.
      // Get the storage handler specifically for 'node' entities.
      $node_storage = $this->entityTypeManager->getStorage('node');
      // Load the node object using the NID retrieved from config.
      $selected_node = $node_storage->load($nid);

      // 3. Check if the node loading was successful and it's a valid Node object.
      if ($selected_node instanceof NodeInterface) {
        // Node loaded! Get its title (label).
        $selected_title = $selected_node->label();

        // 4. Execute the entity query to get related node titles using our helper method.
        $related_titles = $this->findRelatedNodeTitles($selected_node);

      } else {
        // The saved NID didn't load a valid node (maybe it was deleted).
        $selected_title = $this->t('Selected node (ID: @nid) not found.', ['@nid' => $nid]);
      }
    }

    // 5. Prepare the final render array for Drupal.
    // This array tells Drupal how to render the block's content.
    return [
      // Specify the theme hook to use. This connects to hook_theme()
      // and the corresponding Twig file (hello-world-reference-info.html.twig).
      '#theme' => 'hello_world_reference_info', // Our NEW theme hook name.
      // Pass the variables needed by the Twig template.
      '#selected_title' => $selected_title,
      '#related_titles' => $related_titles,
      // Control caching. Disabling is easiest for testing, but use
      // cache tags/contexts in real projects for better performance.
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Helper method to find titles of related nodes using an entity query.
   *
   * @param \Drupal\node\NodeInterface $current_node
   *   The node whose relatives we want to find.
   *
   * @return array
   *   An array of node titles (strings).
   */
  protected function findRelatedNodeTitles(NodeInterface $current_node): array
  {
    $titles = []; // Initialize empty array for titles
    try {
      // Get the node storage handler again (needed for query and loadMultiple).
      $node_storage = $this->entityTypeManager->getStorage('node');
      // Start building the entity query for nodes.
      $query = $node_storage->getQuery()
        // Add conditions:
        ->condition('type', $current_node->bundle()) // Must be the same content type.
        ->condition('nid', $current_node->id(), '<>') // Must NOT be the current node.
        ->condition('status', NodeInterface::PUBLISHED) // Must be published.
        // Apply access check for the current user (important!).
        ->accessCheck(TRUE)
        // Sort the results alphabetically by title.
        ->sort('title', 'ASC')
        // Limit the number of results (optional but good practice).
        ->range(0, 10);

      // Execute the query to get the NIDs of matching nodes.
      $nids = $query->execute();

      // If the query returned any NIDs...
      if (!empty($nids)) {
        // Load the full node objects for those NIDs efficiently.
        $related_nodes = $node_storage->loadMultiple($nids);
        // Loop through the loaded nodes and extract their titles.
        foreach ($related_nodes as $node) {
          $titles[] = $node->label();
        }
      }
    } catch (\Exception $e) {
      // Log any errors encountered during the query or loading.
      \Drupal::logger('hello_world')->error('Error finding related nodes for NID @nid: @message', [
        '@nid' => $current_node->id(),
        '@message' => $e->getMessage()
      ]);
    }
    // Return the array of titles (might be empty).
    return $titles;
  }

} // End of the SelectedNodeBlock class definition.
