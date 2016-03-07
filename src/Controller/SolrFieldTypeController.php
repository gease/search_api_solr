<?php

/**
 * @file
 * Contains Drupal\search_api_solr_multilingual\Controller\SolrFieldTypeController.
 */

namespace Drupal\search_api_solr_multilingual\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\search_api\ServerInterface;
use ZipStream\ZipStream;

/**
 * Provides different listings of SolrFieldType.
 */
class SolrFieldTypeController extends ControllerBase {

  /**
   * Provides the listing page.
   *
   * @param string $entity_type
   *   The entity type to render.
   *
   * @return array
   *   A render array as expected by drupal_render().
   */
  public function listing(ServerInterface $search_api_server) {
    return $this->getListBuilder($search_api_server)->render();
  }

  public function getSchemaExtraTypesXml(ServerInterface $search_api_server) {
    return $this->getListBuilder($search_api_server)->getSchemaExtraTypesXml();
  }

  public function getSchemaExtraFieldsXml(ServerInterface $search_api_server) {
    return $this->getListBuilder($search_api_server)->getSchemaExtraFieldsXml();
  }

  public function getConfigZip(ServerInterface $search_api_server) {
    ob_clean();

    /** @var ZipStream $zip */
    $zip = $this->getListBuilder($search_api_server)->getConfigZip();
    $zip->finish();

    ob_end_flush();
    exit();
  }

  /**
   * @param \Drupal\search_api\ServerInterface $search_api_server
   * @return \Drupal\search_api_solr_multilingual\Controller\SolrFieldTypeListBuilder
   */
  protected function getListBuilder(ServerInterface $search_api_server) {
    /** @var SolrFieldTypeListBuilder $list_builder */
    $list_builder = $this->entityManager()->getListBuilder('solr_field_type');
    $list_builder->setServer($search_api_server);
    return $list_builder;
  }
}
