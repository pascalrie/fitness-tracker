<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class CorsListener implements EventSubscriberInterface
{
    private const array ALLOWED_ORIGINS = [
        "https://backend-fitness-tracker-v5",
        "http://backend-fitness-tracker-v5",
        'https://localhost',
        'http://localhost',
        'http://localhost:3000',
        'http://localhost:5173',
    ];
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9999],
            KernelEvents::RESPONSE => ['onKernelResponse', 9999],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->getMethod() !== Request::METHOD_OPTIONS) {
            return;
        }

        $response = new Response();
        $this->addCorsHeaders($request, $response);

        $response->setStatusCode(Response::HTTP_NO_CONTENT);

        $event->setResponse($response);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        $this->addCorsHeaders($request, $response);
    }

    private function addCorsHeaders(Request $request, Response $response): void
    {
        $origin = $request->headers->get('Origin');

        if ($origin && in_array($origin, self::ALLOWED_ORIGINS, true)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        $response->headers->set(
            'Access-Control-Allow-Methods',
            'GET, POST, PUT, PATCH, DELETE, OPTIONS'
        );

        $response->headers->set(
            'Access-Control-Allow-Headers',
            'Authorization, Content-Type, X-Requested-With'
        );

        $response->headers->set(
            'Access-Control-Allow-Credentials',
            'true'
        );
    }
}
