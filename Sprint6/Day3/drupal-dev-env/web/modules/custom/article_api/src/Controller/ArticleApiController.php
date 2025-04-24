<?php

namespace Drupal\article_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\node\Entity\Node;

/**
 * Provides article API endpoints with caching examples.
 */
class ArticleApiController extends ControllerBase
{

  /**
   * Returns JSON response of specific article nodes.
   *
   * @return \Drupal\Core\Cache\CacheableJsonResponse
   *   The JSON response with cache metadata.
   */
  public function getArticles()
  {
    // Hardcoded node IDs as specified in requirements
    $nids = [10, 52, 46];

    // Load nodes and prepare response data
    $nodes = Node::loadMultiple($nids);
    $data = array_map(function (Node $node) {
      return [
        'nid' => $node->id(),
        'title' => $node->getTitle(),
      ];
    }, $nodes);

    // Create cacheable JSON response
    $response = new CacheableJsonResponse($data);

    // Set cache metadata
    $cache_metadata = (new \Drupal\Core\Cache\CacheableMetadata())
      ->setCacheMaxAge(60) // 1 hour max-age
      ->addCacheTags(array_map(function ($nid) {
        return "node:$nid"; // Individual node cache tags
      }, $nids))
      ->addCacheTags(['node_list']); // List cache tag

    $response->addCacheableDependency($cache_metadata);

    return $response;
  }

}
