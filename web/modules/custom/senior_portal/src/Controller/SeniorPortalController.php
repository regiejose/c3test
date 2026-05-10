<?php

namespace Drupal\senior_portal\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SeniorPortalController extends ControllerBase {
  /**
   * API Service.
   */
  protected $apiService;

  /**
   * Cache backend.
   */
  protected $cache;

  /**
   * Constructor.
   */
  public function __construct($api_service, $cache) {
    $this->apiService = $api_service;
    $this->cache = $cache;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('senior_portal.api_service'),
      $container->get('cache.default')
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

    // Cache ID.
    $cid = 'senior_portal:api';

    $cache = $this->cache->get($cid);

    if ($cache) {
      return new JsonResponse($cache->data);
    }

    $data = [
      [
        'title' => 'React',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
      ],
      [
        'title' => 'Drupal',
        'description' => 'Fusce purus est, consequat eu dignissim ac, elementum a nisl.',
      ],
      [
        'title' => 'TailwindCSS',
        'description' => 'Orci varius natoque penatibus et magnis dis parturient montes,',
      ],
    ];

    // Save to cache (1 hour TTL + cache tag)
    $this->cache->set(
      $cid,
      $data,
      time() + 3600,
      ['senior_portal:data']
    );

    return new JsonResponse(
      $data
    );
  }

  /**
   * Footer About.
   * 
   * Note: This is a sample API response only.
   */
  public function footerAbout(Request $request): JsonResponse {

    // JWT Protection.
    $protection = $this->jwtProtection($request);
    if ($protection && $protection['status'] == 'failed') {
      throw new AccessDeniedHttpException('Access denied');
    }

    // Cache ID.
    $cid = 'senior_portal:about';
    $cache = $this->cache->get($cid);

    if ($cache && isset($cache->data)) {
      return new JsonResponse($cache->data);
    }

    $data = [
      'about' => 'Aliquam erat volutpat. Donec orci sem, volutpat sollicitudin velit id, condimentum ultricies tellus. Nunc velit turpis, iaculis id mauris ut, sollicitudin posuere est.'
    ];

    // Save to cache (1 hour TTL + cache tag)
    $this->cache->set(
      $cid,
      $data,
      time() + 3600,
      ['senior_portal:data']
    );

    return new JsonResponse(
      $data
    );
  }

  /**
   * Footer Menu.
   * 
   * Note: This is a sample API response only.
   */
  public function footerMenu(Request $request): JsonResponse {

    // JWT Protection.
    $protection = $this->jwtProtection($request);
    if ($protection && $protection['status'] == 'failed') {
      throw new AccessDeniedHttpException('Access denied');
    }

    // Cache ID.
    $cid = 'senior_portal:footer_menu';
    $cache = $this->cache->get($cid);

    if ($cache) {
      return new JsonResponse($cache->data);
    }

    $data = [
      'title' => 'C3 Interactive',
      'menuItems' => [
        [
          'mid' => 1,
          'mLabel' => 'About us',
          'mLink' => '/about'
        ],
        [
          'mid' => 2,
          'mLabel' => 'Careers',
          'mLink' => '/careers'
        ],
        [
          'mid' => 3,
          'mLabel' => 'Contact us',
          'mLink' => '/contact-us'
        ],
        [
          'mid' => 4,
          'mLabel' => 'Privacy Policy',
          'mLink' => '/privacy-policy'
        ],
      ]
    ];

    // Save to cache (1 hour TTL + cache tag)
    $this->cache->set(
      $cid,
      $data,
      time() + 3600,
      ['senior_portal:data']
    );

    return new JsonResponse(
      $data
    );
  }

  /**
   * JWT Protection
   */
  public function jwtProtection (Request $request) {
    $response = [
      'status' => 'success',
      'message' => ''
    ];

    $authHeader = $request->headers->get('Authorization');
    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
      $response = [
        'status' => 'failed',
        'message' => 'Missing token'
      ];
    }

    $jwt = substr($authHeader, 7);

    try {
      $decoded = JWT::decode($jwt, new Key(getenv('JWT_SECRET'), 'HS256'));
    } catch (\Exception $e) {
      $response = [
        'status' => 'failed',
        'message' => 'Invalid or expired token'
      ];
    }

    return $response;
  }
}
