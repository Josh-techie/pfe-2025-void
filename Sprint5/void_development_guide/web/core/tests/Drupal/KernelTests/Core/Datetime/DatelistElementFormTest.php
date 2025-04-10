<?php

declare(strict_types=1);

namespace Drupal\KernelTests\Core\Datetime;

use Drupal\Component\Utility\Variable;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\Core\Security\UntrustedCallbackException;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests Datelist functionality.
 *
 * @group Form
 */
class DatelistElementFormTest extends KernelTestBase implements FormInterface, TrustedCallbackInterface {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['datetime', 'system'];

  /**
   * Sets up the test.
   */
  protected function setUp(): void {
    parent::setUp();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'test_datelist_element';
  }

  /**
   * {@inheritdoc}
   */
  public function datelistDateCallbackTrusted(array &$element, FormStateInterface $form_state, ?DrupalDateTime $date = NULL): void {
    $element['datelistDateCallbackExecuted'] = [
      '#value' => TRUE,
    ];
    $form_state->set('datelistDateCallbackExecuted', TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function datelistDateCallback(array &$element, FormStateInterface $form_state, ?DrupalDateTime $date = NULL): void {
    $element['datelistDateCallbackExecuted'] = [
      '#value' => TRUE,
    ];
    $form_state->set('datelistDateCallbackExecuted', TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $date_callback = 'datelistDateCallbackTrusted') {

    $form['datelist_element'] = [
      '#title' => 'datelist test',
      '#type' => 'datelist',
      '#default_value' => new DrupalDateTime('2000-01-01 00:00:00'),
      '#date_part_order' => [
        'month',
        'day',
        'year',
        'hour',
        'minute', 'ampm',
      ],
      '#date_text_parts' => ['year'],
      '#date_year_range' => '2010:2020',
      '#date_increment' => 15,
      '#date_date_callbacks' => [[$this, $date_callback]],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * Form validation handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * Tests that trusted callbacks are executed.
   */
  public function testDatelistElement(): void {
    $form_state = new FormState();
    $form = \Drupal::formBuilder()->buildForm($this, $form_state);
    $this->render($form);

    $this->assertTrue($form['datelist_element']['datelistDateCallbackExecuted']['#value']);
    $this->assertTrue($form_state->get('datelistDateCallbackExecuted'));
  }

  /**
   * Tests that exceptions are raised if untrusted callbacks are used.
   *
   * @group legacy
   */
  public function testDatelistElementUntrustedCallbacks() : void {
    $this->expectException(UntrustedCallbackException::class);
    $this->expectExceptionMessage(sprintf('Datelist element #date_date_callbacks callbacks must be methods of a class that implements \Drupal\Core\Security\TrustedCallbackInterface or be an anonymous function. The callback was %s. See https://www.drupal.org/node/3217966', Variable::callableToString([$this, 'datelistDateCallback'])));
    $form = \Drupal::formBuilder()->getForm($this, 'datelistDateCallback');
  }

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks() {
    return [
      'datelistDateCallbackTrusted',
    ];
  }

}
