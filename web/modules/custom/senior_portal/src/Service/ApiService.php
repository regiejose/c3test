<?php

namespace Drupal\senior_portal\Service;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Psr\Log\LoggerInterface;

class ApiService {

  /**
   * Client interface.
   */
  protected ClientInterface $httpClient;

  /**
   * Config Factory.
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * Cache.
   */
  protected CacheBackendInterface $cache;

  /**
   * Logger
   */
  protected LoggerInterface $logger;


  /**
   * Constructor.
   */
  public function __construct(
    ClientInterface $http_client,
    ConfigFactoryInterface $config_factory,
    CacheBackendInterface $cache,
    LoggerInterface $logger
  ) {
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
    $this->cache = $cache;
    $this->logger = $logger;
  }

  /**
   * Sample data.
   */
  public function fetchData(): array {
    $config = $this->configFactory
      ->get('senior_portal.settings');
  
    if (!$config->get('enabled')) {
      return [];
    }
  
    $cid = 'senior_portal.api_data';
  
    if ($cache = $this->cache->get($cid)) {
      return $cache->data;
    }
  
    try {
      $response = $this->httpClient->request(
        'GET',
        $config->get('api_url')
      );
  
      $data = json_decode(
        $response->getBody()->getContents(),
        TRUE
      );
  
      // $processedData = array_map(function ($item) {
      //   return [
      //     'title' => $item['title'] ?? '',
      //   ];
      // }, $data);
  
      $this->setCache($cid, $processedData);
  
      return $processedData;
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
  
      return [];
    }
  }

  /**
   * Caching
   */
  private function setCache($cid, $processedData) {
    $this->cache->set(
      $cid,
      $processedData,
      time() + 3600,
      ['senior_portal:data']
    );
  }

}