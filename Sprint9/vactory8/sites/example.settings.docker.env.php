<?php
/**
 * Copy this file into sites/default/settings.docker.env.php
 * Change docker env variable depending on your environment.
 */

/**
 * Docker env variables.
 */
putenv('DOCKER_DB_NAME=db');
putenv('DOCKER_DB_USER=user');
putenv('DOCKER_DB_PASSWORD=passwd');
putenv('DOCKER_DB_HOST=vactory_db');
putenv('DOCKER_DB_PORT=3306');
putenv('IS_DOCKER=true');
#putenv('MEMCACHE_SERVER_ADDR=vactory_memcache');
#putenv('MEMCACHE_SERVER_PORT=8002');

// In case of store locator default API KEYS are read from env.
//putenv('GOOGLE_PLACES_API=key');
//putenv('OPEN_CAGE_API=key');

/**
 * Serves default drush commands uri option.
 * Should be changed in setting.local.php or settings.docker.env.php.
 */
#$settings['site_domain'] = 'www.example.com';