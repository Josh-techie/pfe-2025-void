<?php

declare(strict_types=1);

namespace Drupal\Tests\Core\DrupalKernel;

use Composer\Autoload\ClassLoader;
use Drupal\Core\DrupalKernel;
use Drupal\Tests\UnitTestCase;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @coversDefaultClass \Drupal\Core\DrupalKernel
 * @group DrupalKernel
 */
class DrupalKernelTest extends UnitTestCase {

  /**
   * Tests hostname validation with settings.
   *
   * @covers ::setupTrustedHosts
   * @dataProvider providerTestTrustedHosts
   */
  public function testTrustedHosts($host, $server_name, $message, $expected = FALSE): void {
    $request = new Request();

    $trusted_host_patterns = [
      '^example\.com$',
      '^.+\.example\.com$',
      '^example\.org',
      '^.+\.example\.org',
    ];

    if (!empty($host)) {
      $request->headers->set('HOST', $host);
    }

    $request->server->set('SERVER_NAME', $server_name);

    $method = new \ReflectionMethod('Drupal\Core\DrupalKernel', 'setupTrustedHosts');
    $valid_host = $method->invoke(NULL, $request, $trusted_host_patterns);

    $this->assertSame($expected, $valid_host, $message);

    // Reset the trusted hosts because it is statically stored on the request.
    $method->invoke(NULL, $request, []);
    // Reset the request factory because it is statically stored on the request.
    Request::setFactory(NULL);
  }

  /**
   * Provides test data for testTrustedHosts().
   */
  public static function providerTestTrustedHosts() {
    $data = [];

    // Tests canonical URL.
    $data[] = [
      'www.example.com',
      'www.example.com',
      'canonical URL is trusted',
      TRUE,
    ];

    // Tests missing hostname for HTTP/1.0 compatibility where the Host
    // header is optional.
    $data[] = [NULL, 'www.example.com', 'empty Host is valid', TRUE];

    // Tests the additional patterns from the settings.
    $data[] = [
      'example.com',
      'www.example.com',
      'host from settings is trusted',
      TRUE,
    ];
    $data[] = [
      'subdomain.example.com',
      'www.example.com',
      'host from settings is trusted',
      TRUE,
    ];
    $data[] = [
      'www.example.org',
      'www.example.com',
      'host from settings is trusted',
      TRUE,
    ];
    $data[] = [
      'example.org',
      'www.example.com',
      'host from settings is trusted',
      TRUE,
    ];

    // Tests mismatch.
    $data[] = [
      'www.black_hat.com',
      'www.example.com',
      'unspecified host is untrusted',
      FALSE,
    ];

    return $data;
  }

  /**
   * Tests site path finding.
   *
   * This test is run in a separate process since it defines DRUPAL_ROOT. This
   * stops any possible pollution of other tests.
   *
   * @covers ::findSitePath
   * @runInSeparateProcess
   */
  public function testFindSitePath(): void {
    $vfs_root = vfsStream::setup('drupal_root');
    $sites_php = <<<'EOD'
<?php
$sites['8888.www.example.org'] = 'example';
EOD;

    // Create the expected directory structure.
    vfsStream::create([
      'sites' => [
        'sites.php' => $sites_php,
        'example' => [
          'settings.php' => 'test',
        ],
      ],
    ]);

    $request = new Request();
    $request->server->set('SERVER_NAME', 'www.example.org');
    $request->server->set('SERVER_PORT', '8888');
    $request->server->set('SCRIPT_NAME', '/index.php');
    $this->assertEquals('sites/example', DrupalKernel::findSitePath($request, TRUE, $vfs_root->url()));
    $this->assertEquals('sites/example', DrupalKernel::findSitePath($request, FALSE, $vfs_root->url()));
  }

  /**
   * @covers ::terminate
   * @runInSeparateProcess
   */
  public function testUnBootedTerminate(): void {
    $kernel = new DrupalKernel('test', new ClassLoader());
    $kernel->terminate(new Request(), new Response());
    $this->assertTrue(TRUE, "\Drupal\Core\DrupalKernel::terminate() called without error on kernel which has not booted");
  }

}

/**
 * A fake autoloader for testing.
 */
class FakeAutoloader {

  /**
   * Registers this instance as an autoloader.
   *
   * @param bool $prepend
   *   Whether to prepend the autoloader or not
   */
  public function register($prepend = FALSE): void {
    spl_autoload_register([$this, 'loadClass'], TRUE, $prepend);
  }

  /**
   * Deregisters this instance as an autoloader.
   */
  public function unregister(): void {
    spl_autoload_unregister([$this, 'loadClass']);
  }

  /**
   * Loads the given class or interface.
   *
   * This class never loads.
   */
  public function loadClass() {
    return NULL;
  }

  /**
   * Finds a file by class name while caching lookups to APC.
   *
   * This class never finds.
   */
  public function findFile() {
    return NULL;
  }

}
