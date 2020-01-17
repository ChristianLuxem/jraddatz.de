<?php

namespace JRaddatz\Web\Http\Controllers\Errors;

use JRaddatz\Web\Http\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class HttpNotFoundController
 *
 * @package JRaddatz\Web\Http\Controllers\Errors
 */
class HttpNotFoundController extends Controller
{

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request, Response $response) : Response
    {
        $response = $this->view($request, $response, 'errors/404.twig');

        return $response;
    }
}
