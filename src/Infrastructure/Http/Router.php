<?php

declare(strict_types=1);

namespace Paya\Infrastructure\Http;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

final class Router
{
    private Dispatcher $dispatcher;

    public function __construct(private readonly object $controller)
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('GET', '/api/message/list', ['controller' => 'MessengerController', 'method' => 'list']);
            $r->addRoute('POST', '/api/message/send', ['controller' => 'MessengerController', 'method' => 'sendMessage']);
            $r->addRoute('OPTIONS', '/api/message/send', ['controller' => 'MessengerController', 'method' => 'setHeaders']);
        });
    }

    public function dispatch(Request $request): void
    {
        $routeInfo = $this->dispatcher->dispatch(
            $request->getMethod(),
            $request->getUri()
        );

        if ($routeInfo[0] === Dispatcher::FOUND) {
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];
            
            $request->setPathParameters($vars);
            
            $method = $handler['method'];
            $this->controller->$method($request);
        }

    }
}

