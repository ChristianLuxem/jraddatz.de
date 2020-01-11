<?php

namespace JRaddatz\Web\Http\Middleware;

use JRaddatz\Web\Security\Hash\Hash;
use JRaddatz\Web\Session\Session;
use JRaddatz\Web\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Class AuthenticateUser
 *
 * @package JRaddatz\Web\Http\Middleware
 */
class AuthenticateUser
{

    /**
     * AuthenticateUser constructor.
     *
     * @param Hash $hash
     */
    public function __construct(Hash $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        if (!Session::get('authenticated')) {
            $key = $request->getQueryParams()['key'] ?? '';
            $id = $request->getQueryParams()['id'] ?? null;

            $user = User::where('id', (int) $id)->first();

            $authenticated = $this->hash->check($key, $user->key ?? '');

            Session::put('authenticated', $authenticated);
        }

        return $handler->handle($request);
    }
}
