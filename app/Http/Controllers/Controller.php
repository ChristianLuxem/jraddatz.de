<?php

namespace JRaddatz\Web\Http\Controllers;

use JRaddatz\Web\Config\Config;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

/**
 * Class Controller
 *
 * @package JRaddatz\Web\Http\Controllers
 */
abstract class Controller
{

    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Controller constructor.
     *
     * @param Twig $view
     * @param Config $config
     */
    public function __construct(Twig $view, Config $config)
    {
        $this->view = $view;
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $view
     * @param array $data
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function view(Request $request, Response $response, string $view, array $data = []) : Response
    {
        return $this->view->render($response, $view, array_merge($data, $this->exposeToView()));
    }

    /**
     * @return array
     */
    protected function exposeToView() : array
    {
        return [
            'base_url' => $this->config->get('app.base_url'),
        ];
    }
}
