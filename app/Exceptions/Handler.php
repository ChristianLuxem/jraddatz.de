<?php

namespace JRaddatz\Web\Exceptions;

use JRaddatz\Web\Http\Controllers\Errors\HttpNotFoundController;
use JRaddatz\Web\Http\Controllers\Errors\HttpInternalServerErrorController;
use JRaddatz\Web\Config\Config;
use \Throwable;
use \ReflectionClass;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Slim\Views\Twig;

/**
 * Class Handler
 *
 * @package JRaddatz\Web\Exceptions
 */
class Handler
{

    /**
     * @var ResponseFactory
     */
    protected $response_factory;

    /**
     * @param ResponseFactory $response_factory
     * @param Twig $view
     * @param Config $config
     */
    public function __construct(ResponseFactory $response_factory, Twig $view, Config $config)
    {
        $this->response_factory = $response_factory;
        $this->view = $view;
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     * @throws Throwable
     */
    public function __invoke(Request $request, Throwable $exception) : Response
    {
        if (method_exists($this, $handler = 'handle' . (new ReflectionClass($exception))->getShortName())) {
            return $this->{$handler}($request);
        }

        return $this->handleHttpInternalServerErrorException($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected function handleHttpNotFoundException(Request $request) : Response
    {
        return (
            new HttpNotFoundController($this->view, $this->config)
        )(
            $request,
            $this->response_factory->createResponse()->withStatus(404)
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected function handleHttpInternalServerErrorException(Request $request) : Response
    {
        return (
            new HttpInternalServerErrorController($this->view, $this->config)
        )(
            $request,
            $this->response_factory->createResponse()->withStatus(500)
        );
    }
}
