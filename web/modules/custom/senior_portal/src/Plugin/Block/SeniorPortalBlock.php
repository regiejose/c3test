<?php

namespace Drupal\senior_portal\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\senior_portal\Service\ApiService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a Senior Portal block.
 *
 * @Block(
 *   id = "senior_portal_block",
 *   admin_label = @Translation("Senior Portal Block")
 * )
 */
class SeniorPortalBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * ApiService.
   */
  protected ApiService $apiService;

  /**
   * Constructor.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ApiService $api_service
  ) {
  
    parent::__construct(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  
    $this->apiService = $api_service;
  }

  /**
   * Create
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
  
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('senior_portal.api_service')
    );
  }

  /**
   * {@inheritdoc}
   * 
   * In this block, I use the service that I created in Part 2 and reuse the existing theme template for the display.
   */  
  public function build() {
    return [
      '#theme' => 'senior_portal_page',
      '#items' => $this->apiService->fetchData(),
      '#cache' => [
        'tags' => ['senior_portal:data'],
        'max-age' => 3600,
      ],
    ];  
  }

}