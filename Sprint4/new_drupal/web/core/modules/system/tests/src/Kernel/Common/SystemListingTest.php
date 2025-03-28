<?php

declare(strict_types=1);

namespace Drupal\Tests\system\Kernel\Common;

use Drupal\Core\Extension\ExtensionDiscovery;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests scanning system directories in drupal_system_listing().
 *
 * @group Common
 */
class SystemListingTest extends KernelTestBase {

  /**
   * Tests that files in different directories take precedence as expected.
   */
  public function testDirectoryPrecedence(): void {
    // Define the module files we will search for, and the directory precedence
    // we expect.
    $expected_directories = [
      // When both copies of the module are compatible with Drupal core, the
      // copy in the profile directory takes precedence.
      'drupal_system_listing_compatible_test' => [
        'core/profiles/tests/testing/modules',
        'core/modules/system/tests/modules',
      ],
    ];

    // This test relies on two versions of the same module existing in
    // different places in the filesystem. Without that, the test has no
    // meaning, so assert their presence first.
    foreach ($expected_directories as $module => $directories) {
      foreach ($directories as $directory) {
        $filename = "$directory/$module/$module.info.yml";
        $this->assertFileExists($this->root . '/' . $filename);
      }
    }

    // Now scan the directories and check that the files take precedence as
    // expected.
    $listing = new ExtensionDiscovery($this->root);
    $listing->setProfileDirectories(['core/profiles/tests/testing']);
    $files = $listing->scan('module');
    foreach ($expected_directories as $module => $directories) {
      $expected_directory = array_shift($directories);
      $expected_uri = "$expected_directory/$module/$module.info.yml";
      $module_path = $files[$module]->getPathname();
      $this->assertEquals($expected_uri, $module_path, "Module $module_path was found at $expected_uri.");
    }
  }

  /**
   * Tests that directories matching file_scan_ignore_directories are ignored.
   */
  public function testFileScanIgnoreDirectory(): void {
    $listing = new ExtensionDiscovery($this->root, FALSE);
    $listing->setProfileDirectories(['core/profiles/tests/testing']);
    $files = $listing->scan('module');
    $this->assertArrayHasKey('drupal_system_listing_compatible_test', $files);

    // Reset the static to force a re-scan of the directories.
    $reflected_class = new \ReflectionClass(ExtensionDiscovery::class);
    $reflected_property = $reflected_class->getProperty('files');
    $reflected_property->setValue($reflected_class, []);

    $this->setSetting('file_scan_ignore_directories', ['drupal_system_listing_compatible_test']);
    $listing = new ExtensionDiscovery($this->root, FALSE);
    $listing->setProfileDirectories(['core/profiles/tests/testing']);
    $files = $listing->scan('module');
    $this->assertArrayNotHasKey('drupal_system_listing_compatible_test', $files);
  }

}
