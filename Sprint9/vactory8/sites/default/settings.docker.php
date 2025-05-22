<?php

/**
 * @file
 * Docker development override configuration feature.
 *
 * To activate this feature, copy and rename it such that its path plus
 * filename is 'sites/default/settings.local.php'. Then, go to the bottom of
 * 'sites/default/settings.php' and uncomment the commented lines that mention
 * 'settings.docker.php'.
 *
 * If you are using a site name in the path, such as 'sites/example.com', copy
 * this file to 'sites/example.com/settings.docker.php', and uncomment the lines
 * at the bottom of 'sites/example.com/settings.php'.
 */

/**
 * Enable local development services.
 */
// $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

/**
 * Show all error messages, with backtrace information.
 *
 * In case the error level could not be fetched from the database, as for
 * example the database connection failed, we rely only on this value.
 */

use Symfony\Component\HttpFoundation\Request;

$config['system.logging']['error_level'] = 'verbose';


/**
 * Disable AdvAgg.
 */
$config['advagg.settings']['enabled'] = FALSE;

/**
 * Skip file system permissions hardening.
 *
 * The system module will periodically check the permissions of your site's
 * site directory to ensure that it is not writable by the website user. For
 * sites that are managed with a version control system, this can cause problems
 * when files in that directory such as settings.php are updated, because the
 * user pulling in the changes won't have permissions to modify files in the
 * directory.
 */
$settings['skip_permissions_hardening'] = TRUE;

/**
 * Configuration.
 */
$settings['config_sync_directory'] = 'config/sync';

/**
 * Temporary files path.
 */
$settings['file_temp_path'] = '/tmp';

/**
 * Disable CSS and JS aggregation.
 */
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;

/**
 * Disable AdvAgg.
 */
$config['advagg.settings']['enabled'] = FALSE;

/**
 * Disable CSS defer - PRELOAD.
 */
$config['advagg_mod.settings']['css_defer'] = FALSE;

/**
 * Disable HTML Minify.
 */
$config['system.performance']['minifyhtml']['minify_html'] = FALSE;

/**
 * Path to translation files.
 */
$config['locale.settings']['translation']['path'] = 'sites/default/files/translations';

/**
 * Serves default drush commands uri option.
 * Should be changed in setting.local.php or settings.docker.php.
 */
#$settings['site_domain'] = 'www.example.com';

/**
 * Redirect all site mails to one mail address in local environment.
 *
 * In your settings.local.php file override $settings['vactory_mail_redirect'].
 *
 * By specifying the address to which all site mails should be delivered.
 *
 * Example:
 * $settings['vactory_mail_redirect'] = 'toto@void.fr';
 *
 * From now on, all site mails will be redirected to toto@void.fr address.
 */
// $settings['vactory_mail_redirect'] = 'toto@void.fr';

/**
 * Uncomment the following line to prevent user enumeration on the reset.
 *
 * Password form.
 */
// $settings['prevent_reset_password_user_enumeration'] = TRUE;

/**
 * DF templates error messages policy.
 * Control what part of error to display on production/development env.
 * By Default, we hide all error info parts.
 *
 * You may need to enable display off errors message on development env.
 * to reach that you could set the following params to TRUE.
 *
 * /!\ For security reasons it is recommended to set those params to FALSE or
 * just keep it commented .
 */
# $settings['df_errors_policy']['show_message'] = FALSE;
# $settings['df_errors_policy']['show_trace'] = FALSE;
# $settings['df_errors_policy']['show_source_file'] = FALSE;

/**
 * Base frontend url variable.
 * To be overridden in settings.docker.env.php for decoupled projects.
 */
# $settings['BASE_FRONTEND_URL'] = 'http://localhost:3000';

/**
 * Database.
 */
if (
  getenv('DOCKER_DB_NAME') &&
  getenv('DOCKER_DB_USER') &&
  getenv('DOCKER_DB_PASSWORD') &&
  getenv('DOCKER_DB_HOST') &&
  getenv('DOCKER_DB_PORT')
) {
  $databases['default']['default'] = [
    'driver'   => 'mysql',
    'database' => getenv('DOCKER_DB_NAME'),
    'username' => getenv('DOCKER_DB_USER'),
    'password' => getenv('DOCKER_DB_PASSWORD'),
    'host'     => getenv('DOCKER_DB_HOST'),
    'port'     => getenv('DOCKER_DB_PORT'),
    // Enable it if you want to use the isolation level.(env: READ COMMITTED or REPEATABLE READ)
    // 'isolation_level' => getenv('DOCKER_DB_ISOLATION_LEVEL'),
  ];
}

if (getenv('KEYCLOAK_ISSUER')) {
  $settings['KEYCLOAK_ISSUER'] = getenv('KEYCLOAK_ISSUER');
}

/**
 * Memcache.
 */
if (getenv('MEMCACHE_SERVER_ADDR') && getenv('MEMCACHE_SERVER_PORT')) {
  $settings['memcache']['servers'] = [getenv('MEMCACHE_SERVER_ADDR') . ':' . getenv('MEMCACHE_SERVER_PORT') => 'default'];
  $settings['memcache']['bins'] = ['default' => 'default'];
  $settings['memcache']['key_prefix'] = '';

  $settings['cache']['default'] = 'cache.backend.memcache';
}

/**
 * Cache Key
 *
 * This is used to invalidate Next.js cache.
 * It must match the value set by Next.js CACHE_SECRET in .env file.
 *
 */
if (getenv('FRONTEND_CACHE_KEY')) {
  $settings['FRONTEND_CACHE_KEY'] = getenv('FRONTEND_CACHE_KEY');
}

/**
 * Frontend URL.
 */
if (getenv('BASE_FRONTEND_URL')) {
  $settings['BASE_FRONTEND_URL'] = getenv('BASE_FRONTEND_URL');
}

/**
 * Enable Jsonapi generator requests logger.
 */
if (getenv('LOG_JSONAPI_GENERATOR_REQUESTS')) {
  $settings['log_jsonapi_generator_requests'] = getenv('LOG_JSONAPI_GENERATOR_REQUESTS');
}

/**
 * Base media url.
 */
if (getenv('BASE_MEDIA_URL')) {
  $settings['BASE_MEDIA_URL'] = getenv('BASE_MEDIA_URL');
}

/**
 * Proxy settings
 * Mostly used by Traefik
 */
if (getenv('REVERSE_PROXY')) {
  $settings['reverse_proxy'] = TRUE;
  $settings['reverse_proxy_addresses'] = array($_SERVER["REMOTE_ADDR"] ?? '127.0.0.1');
  // See https://symfony.com/doc/current/deployment/proxies.html.
  $settings['reverse_proxy_trusted_headers'] = Request::HEADER_X_FORWARDED_FOR
    | Request::HEADER_X_FORWARDED_HOST
    | Request::HEADER_X_FORWARDED_PROTO
    | Request::HEADER_X_FORWARDED_PORT;

  if (getenv('REVERSE_PROXY_IP')) {
     $settings['reverse_proxy_addresses'] = explode(',', getenv('REVERSE_PROXY_IP'));
  }
}

/**
 * Next.js user pages path prefix
 * /account/login
 * /account/register
 * /account-one-time-login
 */

$settings['NEXTJS_USER_PAGES_PATH_PREFIX'] = 'user'; // @todo: move to account once migration done.

/**
 * PHP SAPI.
 */
if (PHP_SAPI === 'cli') {
  ini_set('memory_limit', '2G');
}

/**
 * Trusted host configuration.
 *
 * Drupal core can use the Symfony trusted host mechanism to prevent HTTP Host
 * header spoofing.
 * This ensures that the trusted host patterns are set dynamically based on
 * the environment variables for enhanced security.
 */

if ($base_domains = getenv('TRUSTED_HOST')) {
  $domains = explode(',', $base_domains);
  $settings['trusted_host_patterns'] = [];
  foreach ($domains as $domain) {
    $settings['trusted_host_patterns'][] = '^' . preg_quote(trim($domain)) . '$';
  }
}

/**
 * A list of required env variables.
 */
$settings['required_env_vars'] = [
  'MEMCACHE_SERVER_ADDR',
  'MEMCACHE_SERVER_PORT',
  'REVERSE_PROXY',
  'BASE_FRONTEND_URL',
  'BASE_MEDIA_URL',
  'FRONTEND_CACHE_KEY',
];