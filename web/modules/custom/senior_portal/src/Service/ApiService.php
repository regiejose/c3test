<?php

namespace Drupal\senior_portal\Service;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Psr\Log\LoggerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

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
    LoggerChannelFactoryInterface $logger
  ) {
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
    $this->cache = $cache;
    $this->logger = $logger->get('senior_portal');
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
  
    // Cached ID
    $cid = 'senior_portal.api_data';
  
    // Checked cached ID id there is as saved data.
    // If yes, return cached data.
    if ($cache = $this->cache->get($cid)) {
      return $cache->data;
    }
  
    try {
      // Fetch the data from the API.
      $response = $this->httpClient->request(
        'GET',
        $config->get('api_url')
      );
  
      $data = json_decode(
        $response->getBody()->getContents(),
        TRUE
      );
  
      // 
      $this->setCache($cid, $data);
  
      return $data;
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
  
      return [];
    }
  }

  /**
   * Save the data to cache.
   */
  private function setCache($cid, $data) {
    $this->cache->set(
      $cid,
      $data,
      time() + 3600,
      ['senior_portal:data']
    );
  }

}