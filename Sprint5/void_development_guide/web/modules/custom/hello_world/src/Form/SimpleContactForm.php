<?php

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a simple contact form.
 */
class SimpleContactForm extends FormBase
{

  /**
   * Returns a unique string identifying the form.
   *
   * The convention is 'modulename_formname'.
   * {@inheritdoc} means this method is required by the base class (FormBase).
   *
   * @return string
   *   The unique ID for this form.
   */
  public function getFormId()
  {
    // This ID should be unique across your entire Drupal site.
    return 'hello_world_simple_contact_form';
  }

  // ... (Keep getFormId() method above this) ...

  /**
   * Builds the form structure.
   *
   * This method defines the fields and actions available on the form.
   * {@inheritdoc}
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    // --- Name Field ---
    $form['name'] = [
      // '#type' defines the kind of form element (text field, checkbox, etc.).
      '#type' => 'textfield',
      // '#title' is the human-readable label shown next to the field.
      // We use $this->t() to make the label translatable.
      '#title' => $this->t('Your Name'),
      // '#required' => TRUE makes the field mandatory. HTML5 validation is added,
      // but server-side validation (in validateForm) is still crucial.
      '#required' => TRUE,
    ];

    // --- Email Field ---
    $form['email'] = [
      // Use the 'email' type for email addresses.
      '#type' => 'email',
      '#title' => $this->t('Your Email'),
      '#required' => TRUE,
    ];

    // --- Message Field ---
    $form['message'] = [
      // 'textarea' allows for multi-line text input.
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    // --- Submit Button ---
    // It's good practice to group actions (like submit buttons) together.
    $form['actions'] = [
      // '#type' => 'actions' provides a wrapper for buttons.
      '#type' => 'actions',
    ];

    // Add the submit button to the actions group.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      // '#value' is the text displayed on the button. Use t() for translation.
      '#value' => $this->t('Send Message'),
    ];

    // Finally, return the completed form array.
    return $form;
  }
  // ... (Keep getFormId() and buildForm() methods above this) ...

  /**
   * Validates the form submission.
   *
   * This method is called after buildForm() and before submitForm()
   * when the user clicks the submit button.
   * {@inheritdoc}
   *
   * @param array $form
   *   The form structure array (passed by reference).
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form (passed by reference). You use this
   *   to get submitted values and set errors.
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    // Always good practice to call the parent validation first.
    parent::validateForm($form, $form_state);

    // Get the submitted value for the 'message' field.
    $message_value = $form_state->getValue('message');

    // Check if the message length (after removing leading/trailing spaces) is less than 10.
    if (strlen(trim($message_value)) < 10) {
      // If the validation fails, set an error on the 'message' field.
      $form_state->setErrorByName(
        'message', // The machine name of the field with the error.
        $this->t('Your message is too short. Please enter at least 10 characters.') // The error message.
      );
      // Setting an error prevents submitForm() from being called.
    }

    // You could add more validation here (e.g., check email format, although #type 'email' helps).
  }
  // ... (Keep getFormId(), buildForm(), validateForm() methods above this) ...

  /**
   * Handles form submission after validation passes.
   *
   * This method is called only if validateForm() doesn't set any errors.
   * {@inheritdoc}
   *
   * @param array $form
   *   The form structure array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form. Contains submitted values.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Get the submitted values.
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $message = $form_state->getValue('message');

    // Display a success message to the user.
    // $this->messenger() gets Drupal's message service.
    // addStatus() shows a green success message.
    $this->messenger()->addStatus(
      $this->t('Thank you @name, your message has been received!', ['@name' => $name])
    );

    // In a real form, you would DO something here, like:
    // - Send an email using the mail manager service.
    // - Save the data to the database.
    // - Make an API call.

    // Optionally, redirect the user after submission (e.g., to the homepage).
    // $form_state->setRedirect('<front>');
  }
}
