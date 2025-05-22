<?php

/**
 * @file
 * Fichier settings.php do production.
 */

// phpcs:disable

/**
 * FICHIER settings.php DE PRODUCTION.
 *
 * 1 - Configure hash_salt
 * 2 - Configure $config_directories
 * 3 - Configure $databases
 * 4 - Configure trusted_host_patterns
 * 5 - Memcache ? Configure $settings['memcache']['key_prefix'] & uncomment.
 * 6 - HTTPS ? uncomment "Force HTTPS." section.
 */

/**
 * Disable PHP errors.
 */
error_reporting(0);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);

/**
 * Hide all error messages, with backtrace information.
 */
$config['system.logging']['error_level'] = 'hide';

/**
 * Skip file system permissions hardening.
 */
// $settings['skip_permissions_hardening'] = FALSE;

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 */
$settings['hash_salt'] = 's0sNENdhnVFWTfvMAiq9zjHkEUq47rtqtpCCFx-uSkUVXJUNGZo9ElL3vAz7Pg';

/**
 * Force HTTPS.
 *
 * @todo: N'oublier pas de mettre à jour le fichier .htaccess ausi
 *
 * PHP_SAPI command line (cli) check prevents drush commands from giving a
 * "Drush command terminated abnormally due to an unrecoverable error"
 */

/*
if ( (!array_key_exists('HTTPS', $_SERVER)) && (PHP_SAPI !== 'cli') ) {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: https://www.example.com/'. $_SERVER['REQUEST_URI']);
  exit();
}
*/

/**
 * Memcache
 */
/*
$settings['memcache']['servers'] = ['127.0.0.1:11211' => 'default'];
$settings['memcache']['bins'] = ['default' => 'default'];
$settings['memcache']['key_prefix'] = 'MYPROJET_KEY'; // @todo: define
$settings['cache']['default'] = 'cache.backend.memcache';
$settings['cache']['bins']['render'] = 'cache.backend.memcache';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.memcache';

// Enables to display total hits and misses
// $settings['memcache_storage']['debug'] = TRUE;
*/

/**
 * Database cache bins - Fixed size.
 * https://www.drupal.org/node/2891281
 */
$settings['database_cache_max_rows']['bins']['page'] = 500;

/**
 * Suppress ITOK.
 */
$config['image.settings']['suppress_itok_output'] = FALSE;
$config['image.settings']['allow_insecure_derivatives'] = FALSE;

/**
 * Enable CSS and JS aggregation.
 */
$config['system.performance']['css']['preprocess'] = TRUE;
$config['system.performance']['js']['preprocess'] = TRUE;

/**
 * Enable AdvAgg.
 */
$config['advagg.settings']['enabled'] = TRUE;

/**
 * Enable CSS defer - PRELOAD.
 */
$config['advagg_mod.settings']['css_defer'] = TRUE;

/**
 * Enable HTML Minify.
 */
$config['system.performance']['minifyhtml']['minify_html'] = TRUE;

/**
 * Sync Configuration.
 */
$settings['config_sync_directory'] = 'config/sync';

/**
 * Temporary files path.
 */
$settings['file_temp_path'] = '/tmp';

/**
 * Database.
 */
$databases['default']['default'] = [
  'driver'   => 'mysql',
  'database' => 'vactory8',
  'username' => 'drupaluser',
  'password' => '',
  'host'     => '127.0.0.1',
  'port'     => 3306,
];

/**
 * Trusted host configuration.
 *
 * @todo: Add your production domain (subdomains) name to trusted host list.
 */
$settings['trusted_host_patterns'] = [
  '^www\.example\.com$',
];

/**
 * Path to translation files.
 */
$config['locale.settings']['translation']['path'] = 'sites/default/files/translations';

/**
 * Override services for production environment.
 */
if (file_exists(DRUPAL_ROOT . '/sites/default/services.yml')) {
  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.yml';
}
