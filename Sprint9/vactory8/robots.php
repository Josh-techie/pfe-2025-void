<?php
/**
 * Exigence équipe sécurité
 * L’existence du fichier robots.txt qui montre la structure ainsi que quelques
 * fichiers drupal par défaut. Restriction de l’accès à robots.txt (User-agent
 * et si possible filtrage IP)
 */

use Symfony\Component\HttpFoundation\Response;

$autoloader = require_once 'autoload.php';

$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$allowed_user_agents = explode('|', "adsbot|applebot|archive|baiduspider|bingbot|bitlybot|dazoobot|deusu|exabot|gigabot|googlebot|heritrix|ichiro|mail\.ru_bot|mojeekbot|msnbot|orangebot|pinterest|psbot|qwantify|redditbot|seznambot|sogou|special_archive|trendiction|tweetmemebot|twitterbot|wada|wasalive|yahoo|slurp|yacibot|yandexbot|yandeximages|yoozbot");
$allow_access = FALSE;

foreach ($allowed_user_agents as $name) {
  if (strpos($user_agent, $name) !== FALSE) {
    $allow_access = TRUE;
    break;
  }
}
if ($allow_access) {
  $response = new Response();
  $response->setContent(file_get_contents('robots.txt'));
  $response->setStatusCode(Response::HTTP_OK);
  // sets a HTTP response header
  $response->headers->set('Content-Type', 'text/plain');
  // prints the HTTP headers followed by the content
  $response->send();
}
else {
  $response = new Response('Page Not Found', Response::HTTP_NOT_FOUND);
  $response->send();
}
