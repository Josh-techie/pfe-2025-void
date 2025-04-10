<?php

declare(strict_types=1);

namespace Drupal\Tests\comment\Functional;

use Drupal\comment\Plugin\Field\FieldType\CommentItemInterface;
use Drupal\comment\Tests\CommentTestTrait;
use Drupal\language\Entity\ConfigurableLanguage;
use Drupal\Tests\content_translation\Functional\ContentTranslationUITestBase;

/**
 * Tests the Comment Translation UI.
 *
 * @group comment
 */
class CommentTranslationUITest extends ContentTranslationUITestBase {

  use CommentTestTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * The subject of the test comment.
   *
   * @var string
   */
  protected $subject;

  /**
   * An administrative user with permission to administer comments.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  protected $defaultCacheContexts = [
    'languages:language_interface',
    'session',
    'theme',
    'timezone',
    'url.query_args:_wrapper_format',
    'url.query_args.pagers:0',
    'url.site',
    'user.permissions',
    'user.roles',
  ];

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'language',
    'content_translation',
    'node',
    'comment',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    $this->entityTypeId = 'comment';
    $this->bundle = 'comment_article';
    $this->testLanguageSelector = FALSE;
    $this->subject = $this->randomMachineName();
    parent::setUp();
    $this->doSetup();
  }

  /**
   * {@inheritdoc}
   */
  public function setupBundle(): void {
    parent::setupBundle();
    $this->drupalCreateContentType(['type' => 'article', 'name' => 'article']);
    // Add a comment field to the article content type.
    $this->addDefaultCommentField('node', 'article', 'comment_article', CommentItemInterface::OPEN, 'comment_article');
    // Create a page content type.
    $this->drupalCreateContentType(['type' => 'page', 'name' => 'page']);
    // Add a comment field to the page content type - this one won't be
    // translatable.
    $this->addDefaultCommentField('node', 'page', 'comment');
    // Mark this bundle as translatable.
    $this->container->get('content_translation.manager')->setEnabled('comment', 'comment_article', TRUE);
  }

  /**
   * {@inheritdoc}
   */
  protected function getTranslatorPermissions(): array {
    return array_merge(parent::getTranslatorPermissions(), ['post comments', 'administer comments', 'access comments']);
  }

  /**
   * {@inheritdoc}
   */
  protected function createEntity($values, $langcode, $comment_type = 'comment_article') {
    if ($comment_type == 'comment_article') {
      // This is the article node type, with the 'comment_article' field.
      $node_type = 'article';
      $field_name = 'comment_article';
    }
    else {
      // This is the page node type with the non-translatable 'comment' field.
      $node_type = 'page';
      $field_name = 'comment';
    }
    $node = $this->drupalCreateNode([
      'type' => $node_type,
      $field_name => [
        ['status' => CommentItemInterface::OPEN],
      ],
    ]);
    $values['entity_id'] = $node->id();
    $values['entity_type'] = 'node';
    $values['field_name'] = $field_name;
    $values['uid'] = $node->getOwnerId();
    return parent::createEntity($values, $langcode, $comment_type);
  }

  /**
   * {@inheritdoc}
   */
  protected function getNewEntityValues($langcode) {
    // Comment subject is not translatable hence we use a fixed value.
    return [
      'subject' => [['value' => $this->subject]],
      'comment_body' => [['value' => $this->randomMachineName(16)]],
    ] + parent::getNewEntityValues($langcode);
  }

  /**
   * {@inheritdoc}
   */
  protected function doTestPublishedStatus(): void {
    $entity_type_manager = \Drupal::entityTypeManager();
    $storage = $entity_type_manager->getStorage($this->entityTypeId);

    $storage->resetCache();
    $entity = $storage->load($this->entityId);

    // Unpublish translations.
    foreach ($this->langcodes as $index => $langcode) {
      if ($index > 0) {
        $edit = ['status' => 0];
        $url = $entity->toUrl('edit-form', ['language' => ConfigurableLanguage::load($langcode)]);
        $this->drupalGet($url);
        $this->submitForm($edit, $this->getFormSubmitAction($entity, $langcode));
        $storage->resetCache();
        $entity = $storage->load($this->entityId);
        $this->assertFalse($this->manager->getTranslationMetadata($entity->getTranslation($langcode))->isPublished(), 'The translation has been correctly unpublished.');
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function doTestAuthoringInfo(): void {
    $storage = $this->container->get('entity_type.manager')
      ->getStorage($this->entityTypeId);
    $storage->resetCache([$this->entityId]);
    $entity = $storage->load($this->entityId);
    $languages = $this->container->get('language_manager')->getLanguages();
    $values = [];

    // Post different authoring information for each translation.
    foreach ($this->langcodes as $langcode) {
      $url = $entity->toUrl('edit-form', ['language' => $languages[$langcode]]);
      $user = $this->drupalCreateUser();
      $values[$langcode] = [
        'uid' => $user->id(),
        'created' => \Drupal::time()->getRequestTime() - mt_rand(0, 1000),
      ];
      /** @var \Drupal\Core\Datetime\DateFormatterInterface $date_formatter */
      $date_formatter = $this->container->get('date.formatter');
      $edit = [
        'uid' => $user->getAccountName() . ' (' . $user->id() . ')',
        'date[date]' => $date_formatter->format($values[$langcode]['created'], 'custom', 'Y-m-d'),
        'date[time]' => $date_formatter->format($values[$langcode]['created'], 'custom', 'H:i:s'),
      ];
      $this->drupalGet($url);
      $this->submitForm($edit, $this->getFormSubmitAction($entity, $langcode));
    }

    $storage->resetCache([$this->entityId]);
    $entity = $storage->load($this->entityId);
    foreach ($this->langcodes as $langcode) {
      $metadata = $this->manager->getTranslationMetadata($entity->getTranslation($langcode));
      $this->assertEquals($values[$langcode]['uid'], $metadata->getAuthor()->id(), 'Translation author correctly stored.');
      $this->assertEquals($values[$langcode]['created'], $metadata->getCreatedTime(), 'Translation date correctly stored.');
    }
  }

  /**
   * Tests translate link on comment content admin page.
   */
  public function testTranslateLinkCommentAdminPage(): void {
    $this->adminUser = $this->drupalCreateUser(array_merge(parent::getTranslatorPermissions(), ['access administration pages', 'administer comments', 'skip comment approval']));
    $this->drupalLogin($this->adminUser);

    $cid_translatable = $this->createEntity([], $this->langcodes[0]);
    $cid_untranslatable = $this->createEntity([], $this->langcodes[0], 'comment');

    // Verify translation links.
    $this->drupalGet('admin/content/comment');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->linkByHrefExists('comment/' . $cid_translatable . '/translations');
    $this->assertSession()->linkByHrefNotExists('comment/' . $cid_untranslatable . '/translations');
  }

  /**
   * {@inheritdoc}
   */
  protected function doTestTranslationEdit(): void {
    $storage = $this->container->get('entity_type.manager')
      ->getStorage($this->entityTypeId);
    $storage->resetCache([$this->entityId]);
    $entity = $storage->load($this->entityId);
    $languages = $this->container->get('language_manager')->getLanguages();

    foreach ($this->langcodes as $langcode) {
      // We only want to test the title for non-english translations.
      if ($langcode != 'en') {
        $options = ['language' => $languages[$langcode]];
        $url = $entity->toUrl('edit-form', $options);
        $this->drupalGet($url);
        $this->assertSession()->pageTextContains("Edit {$this->entityTypeId} {$entity->getTranslation($langcode)->label()} [{$languages[$langcode]->getName()} translation]");
      }
    }
  }

}
