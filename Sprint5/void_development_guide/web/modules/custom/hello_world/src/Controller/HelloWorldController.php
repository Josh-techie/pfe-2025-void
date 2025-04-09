<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    // Prepare the variable to pass to the template.
    $name = 'Habib'; // Imagine Habib is our honored guest.

    // Render the template.
    return [
      '#theme' => 'hello_world', // This is the name of our theme suggestion.
    ];
  }
}

