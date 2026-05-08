<?php

namespace Drupal\senior_portal\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SeniorPortalController extends ControllerBase {
  /**
   * API Service.
   */
  protected $apiService;

  /**
   * Constructor.
   */
  public function __construct($api_service) {
    $this->apiService = $api_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('senior_portal.api_service')
    );
  }

  /**
   * Page
   */
  public function page(): array {
    return [
      '#theme' => 'senior_portal_page',
      '#items' => $this->apiService->fetchData(),
      '#cache' => [
        'tags' => ['senior_portal:data'],
        'max-age' => 3600,
      ],
    ];
  }

  /**
   * API
   */
  public function api(): JsonResponse {
    return new JsonResponse(
      $this->apiService->fetchData()
    );
  }
}