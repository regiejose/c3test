<?php

namespace Drupal\senior_portal\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SeniorPortalSubscriber implements EventSubscriberInterface {

  /**
   * Logger
   */
  protected $logger;

  /**
   * Constructor
   */
  public function __construct(LoggerChannelFactoryInterface $logger_factory) {
    $this->logger = $logger_factory->get('senior_portal');
  }

  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('logger.factory')->get('senior_portal')
    );
  }

  /**
   * React to every request.
   * 
   * We can do more like saving details in the database, trigger external API and many more. 
   * But for thise example, it will only create a watchdog log when user visited the "/senior-portal" page.
   */
  public function onRequest(RequestEvent $event): void {
    $request = $event->getRequest();

    // Get the internal path (without domain).
    $path = $request->getPathInfo();

    // Check if user visited the senior portal page.
    if ($path === '/senior-portal') {
      $this->logger->info('Senior portal visited from IP @ip', [
        '@ip' => $request->getClientIp(),
      ]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      KernelEvents::REQUEST => ['onRequest', 0],
    ];
  }

}