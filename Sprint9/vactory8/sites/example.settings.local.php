<?php

/**
 * @file
 * Local development override configuration feature.
 *
 * To activate this feature, copy and rename it such that its path plus
 * filename is 'sites/default/settings.local.php'. Then, go to the bottom of
 * 'sites/default/settings.php' and uncomment the commented lines that mention
 * 'settings.local.php'.
 *
 * If you are using a site name in the path, such as 'sites/example.com', copy
 * this file to 'sites/example.com/settings.local.php', and uncomment the lines
 * at the bottom of 'sites/example.com/settings.php'.
 */

/**
 * Assertions.
 *
 * The Drupal project primarily uses runtime assertions to enforce the
 * expectations of the API by failing when incorrect calls are made by code
 * under development.
 *
 * @see http://php.net/assert
 * @see https://www.drupal.org/node/2492225
 *
 * If you are using PHP 7.0 it is strongly recommended that you set
 * zend.assertions=1 in the PHP.ini file (It cannot be changed from .htaccess
 * or runtime) on development machines and to 0 in production.
 *
 * @see https://wiki.php.net/rfc/expectations
 */
assert_options(ASSERT_ACTIVE, TRUE);
assert_options(ASSERT_EXCEPTION, TRUE);

/**
 * Enable local development services.
 */
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

/**
 * Show all error messages, with backtrace information.
 *
 * In case the error level could not be fetched from the database, as for
 * example the database connection failed, we rely only on this value.
 */
$config['system.logging']['error_level'] = 'verbose';

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
 * Disable the render cache (this includes the page cache).
 *
 * Note: you should test with the render cache enabled, to ensure the correct
 * cacheability metadata is present. However, in the early stages of
 * development, you may want to disable it.
 *
 * This setting disables the render cache by using the Null cache back-end
 * defined by the development.services.yml file above.
 *
 * Do not use this setting until after the site is installed.
 */
$settings['cache']['bins']['render'] = 'cache.backend.null';

/**
 * Disable caching for migrations.
 *
 * Uncomment the code below to only store migrations in memory and not in the
 * database. This makes it easier to develop custom migrations.
 */
// phpcs:disable
# $settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';
// phpcs:enable

/**
 * Disable Dynamic Page Cache.
 *
 * Note: you should test with Dynamic Page Cache enabled, to ensure the correct
 * cacheability metadata is present (and hence the expected behavior). However,
 * in the early stages of development, you may want to disable it.
 */
// phpcs:disable
# $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
// phpcs:enable

/**
 * Allow test modules and themes to be installed.
 *
 * Drupal ignores test modules and themes by default for performance reasons.
 * During development it can be useful to install test extensions for debugging
 * purposes.
 */
// phpcs:disable
# $settings['extension_discovery_scan_tests'] = TRUE;
// phpcs:enable

/**
 * Enable access to rebuild.php.
 *
 * This setting can be enabled to allow Drupal's php and database cached
 * storage to be cleared via the rebuild.php page. Access to this page can also
 * be gained by generating a query string from rebuild_token_calculator.sh and
 * using these parameters in a request to rebuild.php.
 */
$settings['rebuild_access'] = FALSE;

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
 * Database.
 */
$databases['default']['default'] = [
  'driver'   => 'mysql',
  'database' => 'vactory8',
  'username' => 'drupaluser',
  'password' => '',
  'host'     => '127.0.0.1',
  'port'     => 33067,
];

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
 * Redirect all site mails to array of mail addresses in local environment.
 *
 * In your settings.local.php file override $settings['vactory_mail_redirect'].
 *
 * By specifying the address to which all site mails should be delivered.
 *
 * Example:
 * $settings['vactory_mail_redirect'] = ['s.ghannouch@void.fr', 'toto@void.fr'];
 * $settings['vactory_mail_redirect'] = [ 'toto@void.fr']; // for one address
 *
 * From now on, all site mails will be redirected to ['s.ghannouch@void.fr', 'toto@void.fr'] addresses.
 */
// $settings['vactory_mail_redirect'] = ['s.ghannouch@void.fr', 'toto@void.fr'];

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
 * Serves default drush commands uri option.
 * Should be changed in setting.local.php or settings.docker.env.php.
 */
#$settings['site_domain'] = 'www.example.com';

/**
 * Valeur	Comportement
 * Strict	Le cookie n'est jamais envoyé lors de requêtes intersites
 * Lax	Le cookie est envoyé pour les requêtes GET intersites (mais pas POST)
 * None	Le cookie est toujours envoyé — nécessite HTTPS
 */

/**
 * Forcer l'utilisation de HTTPS pour les cookies (si tu es en HTTPS).
 */
ini_set('session.cookie_secure', '1');

/**
 * Définir SameSite sur 'Lax' (le plus compatible pour la plupart des cas).
 */
ini_set('session.cookie_samesite', 'Lax');

/**
 * Activer le cache des clés de l'API State.
 *
 * Drupal utilise l’API State pour stocker des informations volatiles (comme la dernière exécution de cron, le timestamp d’un index, etc.).
 * Par défaut, cela utilise la base de données sans cache. En activant $settings['state_cache'], ces valeurs sont mises en cache (souvent dans cache_default), ce qui améliore la performance.
 */
$settings['state_cache'] = TRUE;