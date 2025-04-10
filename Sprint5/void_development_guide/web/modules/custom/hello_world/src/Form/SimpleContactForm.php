<?php

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Session\AccountInterface; // Needed to check user role/status
use Symfony\Component\DependencyInjection\ContainerInterface; // Needed for service injection

/**
 * Provides a simple contact form.
 */
class SimpleContactForm extends FormBase
{
  /**
   * The current user.
   * We'll store the service object here.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs a SimpleContactForm object.
   * We override the constructor to inject the current user service.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user service.
   */
  public function __construct(AccountInterface $current_user)
  {
    // Store the injected service in our property.
    $this->currentUser = $current_user;
  }

  /**
   * Creates an instance of the form.
   * This is the static factory method for dependency injection.
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    // Get the 'current_user' service from the container
    // and pass it to the constructor.
    return new static(
      $container->get('current_user')
    );
  }
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

    // --- ADD A 'details' GROUPING ELEMENT ---
    $form['contact_details'] = [
      '#type' => 'details', // Use 'details' for a collapsible group
      '#title' => $this->t('Your Contact Information'), // Title for the group
      '#open' => TRUE, // Make the group expanded by default (optional)
      '#description' => $this->t('Please provide your details and message below.'), // Optional description
    ];

    // --- Move Name Field INSIDE the group ---
    // Notice the change from $form['name'] to $form['contact_details']['name']
    $form['contact_details']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Name'),
      '#required' => TRUE,
    ];

    // --- Move Email Field INSIDE the group ---
    $form['contact_details']['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your Email'),
      '#required' => TRUE,
    ];

    // --- Move Message Field INSIDE the group ---
    $form['contact_details']['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    // --- ADD NEW FIELD: Internal Priority ---
    $form['internal_priority'] = [
      '#type' => 'select', // Let's make it a dropdown
      '#title' => $this->t('Internal Priority'),
      '#options' => [      // Define the dropdown options
        'low' => $this->t('Low'),
        'medium' => $this->t('Medium'),
        'high' => $this->t('High'),
      ],
      '#default_value' => 'medium', // Default selection
      '#description' => $this->t('Set the priority for handling this message (visible only to logged-in users).'),

      // --- THE #access LOGIC ---
      // $this->currentUser holds the user object we injected.
      // isAnonymous() returns TRUE if the user is not logged in.
      // We want #access to be TRUE only if the user is NOT anonymous (i.e., logged in).
      // So we use the NOT operator (!).
      '#access' => !$this->currentUser->isAnonymous(),
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

    // --- ADD THIS LINE FOR REDIRECT ---
    // 2. Redirect the user.
    // '<front>' is a special route name that always points to the site's front page.
    // Other options:
    // - Redirect to a specific route: $form_state->setRedirect('some_module.some_route');
    // - Redirect to a node: $form_state->setRedirect('entity.node.canonical', ['node' => 123]);
    $form_state->setRedirect('<front>');

    // In a real form, you would DO something here, like:
    // - Send an email using the mail manager service.
    // - Save the data to the database.
    // - Make an API call.

    // Optionally, redirect the user after submission (e.g., to the homepage).
    // $form_state->setRedirect('<front>');
  }
}
