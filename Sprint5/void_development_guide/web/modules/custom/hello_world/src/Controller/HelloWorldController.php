<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Psr\Log\LoggerInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse; // Import the JsonResponse class

/**
 * Provides route responses for the Hello World module.
 */
class HelloWorldController extends ControllerBase
{

  /**
   * The logger channel.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * {@inheritdoc}
   */
  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('logger.factory')->get('hello_world')
    );
  }

  /**
   * Returns a simple page for the Hello World menu item.
   *
   * @return array
   *   A simple renderable array.
   */
  public function page()
  {
    $this->logger->info('The Hello World page was accessed.');
    return [
      '#markup' => '<p>This is the main Hello World page.</p>',
    ];
  }

  /**
   * Returns a simple page for Child Menu 1.
   *
   * @return array
   *   A simple renderable array.
   */
  public function child1()
  {
    $this->logger->notice('Child Menu 1 was accessed.');
    return [
      '#markup' => '<p>This is the content for Child Menu 1.</p>',
    ];
  }

  /**
   * Returns a simple page for Child Menu 2.
   *
   * @return array
   *   A simple renderable array.
   */
  public function child2()
  {
    $this->logger->warning('Child Menu 2 was accessed.');
    return [
      '#markup' => '<p>This is the content for Child Menu 2.</p>',
    ];
  }

  /**
   * Create a new method responsible for rendering a text in twig template
   */
  public function hello()
  {
    // // Prepare the variable to pass to the template.
    // $name = 'Habib';

    // $build = [
    //   '#theme' => 'hello_world',
    //   '#name' => $name,
    //   '#attached' => [
    //     'library' => [
    //       'hello_world/tailwind', // We'll define this library in hello_world.libraries.yml
    //     ],
    //   ],
    // ];

    // return $build;
  }

  public function link()
  {
    // Generate the URL for the 'hello_world.hello_page' route
    $url = Url::fromRoute('hello_world.link_page')->setAbsolute()->toString();

    // Create a link with the URL
    $link = Link::fromTextAndUrl('Go to Link ', Url::fromRoute('hello_world.link_page'))->toString();
    dump($link);
    dump($url);
    // Pass the URL, link, and other variables to the template
    return [
      '#theme' => 'hello_world',
      '#url' => $url,
      '#link' => $link,
    ];
  }

  /**
   * Returns a JSON response.
   */
  public function json_parser()
  {
    // Data to be sent as JSON.  This could come from anywhere (database, API, etc.).
    $data = [
      'message' => 'Hello, world!',
      'status' => 'success',
      'timestamp' => time(),
    ];

    // Create a new JsonResponse object, passing the data array.
    $response = new JsonResponse($data);

    // (Optional) Setting additional headers.
    $response->headers->set('X-Custom-Header', 'My Value');
    $response->headers->set('Cache-Control', 'no-cache, must-revalidate'); // Example: prevent caching

    // Returning the response.
    return $response;
  }
}

