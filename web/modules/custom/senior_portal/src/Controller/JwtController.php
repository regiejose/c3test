<?php

namespace Drupal\senior_portal\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

class JwtController {

  public function generate(Request $request): JsonResponse {

    // Get url
    $url = json_decode($request->getContent(), true);

    $payload = [
      'url' => $url,
      'iat' => time(),
      'exp' => time() + 3600,
      'iss' => 'senior_portal'
    ];

    $secret = getenv('JWT_SECRET');

    if (!$secret) {
      return new JsonResponse([
        'message' => 'JWT secret not configured'
      ], 500);
    }

    // Generate JWT
    $jwt = JWT::encode($payload, $secret, 'HS256');

    return new JsonResponse([
      'token' => $jwt,
      'url' => $url
    ]);
  }
}