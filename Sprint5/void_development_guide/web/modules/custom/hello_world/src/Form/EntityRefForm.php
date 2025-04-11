<?php

// Defines the namespace for the form class. Crucial for Drupal's autoloader.
namespace Drupal\hello_world\Form;

// Import necessary classes using 'use' statements.
use Drupal\Core\Form\FormBase; // Base class for all forms.
use Drupal\Core\Form\FormStateInterface; // Object holding form state during processing.
use Drupal\Core\Config\ConfigFactoryInterface; // Service to read/write configuration.
use Symfony\Component\DependencyInjection\ContainerInterface; // Needed for Dependency Injection.
use Drupal\Core\Entity\EntityTypeManagerInterface; // Needed to load the default entity.

/**
 * Provides a form to select a node using entity_autocomplete and save its ID.
 */
class EntityRefForm extends FormBase
{

  /**
   * Drupal's configuration factory service.
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal's entity type manager service.
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs the EntityRefForm object.
   * Injects the required services (Config Factory and Entity Type Manager).
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager)
  {
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   * Creates an instance of the form using Dependency Injection.
   * Drupal calls this static method to get the form object.
   */
  public static function create(ContainerInterface $container)
  {
    // Get the required services from the service container.
    // Pass them to the constructor when creating a new instance ('new static').
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   * Returns the unique string ID for this form.
   */
  public function getFormId()
  {
    // Convention: module_name_form_name
    return 'hello_world_entity_ref_form';
  }

  /**
   * {@inheritdoc}
   * Defines the structure of the form (fields, buttons).
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    // --- Load currently saved NID to set as default ---
    // Get the config object for 'hello_world.settings'.
    $config = $this->configFactory->get('hello_world.settings');
    // Get the saved NID, or NULL if not set.
    $current_nid = $config->get('selected_node_nid');
    $default_entity = NULL; // Initialize default entity as NULL.

    // If we have a saved NID, try to load the corresponding node entity.
    if ($current_nid && is_numeric($current_nid)) {
      // Use the injected Entity Type Manager service to get the node storage handler.
      $node_storage = $this->entityTypeManager->getStorage('node');
      // Load the node object.
      $default_entity = $node_storage->load($current_nid);
      // Note: $default_entity will be NULL if the loaded node doesn't exist anymore.
      // The entity_autocomplete field handles this gracefully.
    }

    // --- Define the Entity Reference Field ---
    $form['selected_node'] = [
      // Use 'entity_autocomplete' for a text field that suggests entities as you type.
      '#type' => 'entity_autocomplete',
      // Specify the type of entity to reference ('node').
      '#target_type' => 'node',
      // Human-readable label for the field. Use t() for translation.
      '#title' => $this->t('Select Reference Node'),
      // Help text displayed below the field.
      '#description' => $this->t('Start typing the title of the node you want to reference.'),
      // Set the default value. If $default_entity is loaded, it will pre-populate.
      // If $default_entity is NULL, the field will be empty.
      '#default_value' => $default_entity,
      // Mark the field as required. Form won't submit without a valid selection.
      '#required' => TRUE,
      // Optional: Limit which content types (bundles) can be selected.
      // '#selection_settings' => [
      //   'target_bundles' => ['page', 'article'], // Only allow 'page' and 'article' nodes.
      // ],
    ];

    // --- Define Form Actions (Submit Button) ---
    // Group actions in a container for standard Drupal theming.
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      // Standard submit button.
      '#type' => 'submit',
      // Text displayed on the button. Use t() for translation.
      '#value' => $this->t('Save Reference'),
    ];

    // Return the constructed form array.
    return $form;
  }

  /**
   * {@inheritdoc}
   * Processes the form submission after validation passes.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Get the submitted value from the 'selected_node' field.
    // For entity_autocomplete, this returns the ID of the selected entity (the NID).
    $selected_nid = $form_state->getValue('selected_node');

    // Validate that we received a numeric NID.
    if (!empty($selected_nid) && is_numeric($selected_nid)) {
      // Get an *editable* version of our module's configuration object.
      $config = $this->configFactory->getEditable('hello_world.settings');
      // Set the value for the 'selected_node_nid' key.
      $config->set('selected_node_nid', $selected_nid);
      // Save the configuration changes persistently.
      $config->save();

      // Display a success message to the user.
      $this->messenger()->addStatus($this->t('Reference Node ID @nid has been saved.', ['@nid' => $selected_nid]));

      // Optionally, redirect the user after successful submission.
      // $form_state->setRedirect('<front>'); // Example: Redirect to homepage

    } else {
      // Display a warning message if the selection was invalid or empty.
      $this->messenger()->addWarning($this->t('No valid node was selected or an error occurred.'));
    }
  }

} // End of EntityRefForm class definition.
