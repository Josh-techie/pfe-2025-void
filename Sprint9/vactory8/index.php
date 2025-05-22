<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt files in the "core" directory.
 */

if (strpos($_SERVER['REQUEST_URI'], '/admin/') === FALSE) {
  require_once 'redirections/app.php';
}

use Blackfire\ClientConfiguration;
use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;
use Blackfire\Client;

$autoloader = require_once 'autoload.php';

/**
 * Get the client's real IP address, checking for forwarded headers if behind a proxy.
 */
function getClientIp(): string {
  if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    return $_SERVER['HTTP_CLIENT_IP'];
  }
  return $_SERVER['REMOTE_ADDR'];
}

function isClientIpAllowed(array $allowed_ips): bool {
  $client_ip = getClientIp();
  return in_array($client_ip, $allowed_ips);
}

$allowed_ips = explode(',', getenv('BLACKFIRE_ALLOWED_IPS'));

if (
  (getenv('BLACKFIRE_ALLOWED') || isClientIpAllowed($allowed_ips))
  && strpos($_SERVER['REQUEST_URI'], '/api/') !== FALSE
  && extension_loaded('blackfire')
) {

  $redBold = "\033[1;31m";
  $reset = "\033[0m";
  $warningMessage = $redBold . "AVERTISSEMENT CRITIQUE: Blackfire est activé. Les réponses de /api peuvent être considérablement ralenties." . $reset;
  error_log($warningMessage);

  $config_client = new ClientConfiguration(
    getenv('BLACKFIRE_CLIENT_ID'),
    getenv('BLACKFIRE_CLIENT_TOKEN')
  );
  $client = new Client($config_client);
  $probe = $client->createProbe();

// Register shutdown function to close and send the profile
  register_shutdown_function(function() use ($client, $probe) {
    $client->endProbe($probe);
  });
}

$kernel = new DrupalKernel('prod', $autoloader);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
