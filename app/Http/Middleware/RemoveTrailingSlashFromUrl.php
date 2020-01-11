<?php

namespace JRaddatz\Web\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 * Class RemoveTrailingSlashFromUrl
 *
 * @package JRaddatz\Web\Http\Middleware
 */
class RemoveTrailingSlashFromUrl
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler) : ResponseInterface
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {
            $uri = $uri->withPath(substr($path, 0, -1));

            if ($request->getMethod() == 'GET') {
                $response = new Response();
                return $response
                    ->withHeader('Location', (string) $uri)
                    ->withStatus(301);
            } else {
                $request = $request->withUri($uri);
            }
        }

        return $handler->handle($request);
    }
}
