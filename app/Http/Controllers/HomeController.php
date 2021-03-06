<?php

namespace JRaddatz\Web\Http\Controllers;

use JRaddatz\Web\Session\Session;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class HomeController
 *
 * @package JRaddatz\Web\Http\Controllers
 */
class HomeController extends Controller
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
        $authenticated = Session::get('authenticated');

        $response = $this->view($request, $response, 'home.twig', compact('authenticated'));

        return $response;
    }
}
