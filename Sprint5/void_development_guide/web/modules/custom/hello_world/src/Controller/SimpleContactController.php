<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface; // Need the Form Builder
use Symfony\Component\DependencyInjection\ContainerInterface; // Needed for DI

/**
 * Controller to display the SimpleContactForm.
 */
class SimpleContactController extends ControllerBase
{

  /**
   * The Form Builder service.
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Inject the Form Builder service.
   */
  public function __construct(FormBuilderInterface $form_builder)
  {
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc} For dependency injection.
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Displays the form.
   *
   * @return array
   *   A render array containing the form.
   */
  public function displayForm()
  {
    // Ask the Form Builder to get the render array for our specific form class.
    // Use the FULL namespace path to your form class.
    $form = $this->formBuilder->getForm('\Drupal\hello_world\Form\SimpleContactForm');
    // Return the form array. Drupal will render it.
    return $form;
  }

}
