<?php

namespace JRaddatz\Web\Http\Controllers\Errors;

use JRaddatz\Web\Http\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class HttpInternalServerErrorController
 *
 * @package JRaddatz\Web\Http\Controllers\Errors
 */
class HttpInternalServerErrorController extends Controller
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
        $response = $this->view($request, $response, 'errors/500.twig');

        return $response;
    }
}
