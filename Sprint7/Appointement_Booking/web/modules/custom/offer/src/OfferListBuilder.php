<?php

namespace Drupal\offer;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the Offer entity.
 */
class OfferListBuilder extends EntityListBuilder
{

  /**
   * {@inheritdoc}
   */
  public function buildHeader()
  {
    $header['id'] = $this->t('Offer ID');
    $header['title'] = $this->t('Title');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {
    /** @var \Drupal\offer\Entity\Offer $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->label() ?: $this->t('No title');
    $row['status'] = ($entity->isPublished() ?? FALSE) ? $this->t('Published') : $this->t('Unpublished');    // logging the value

    return $row + parent::buildRow($entity);
  }
}

