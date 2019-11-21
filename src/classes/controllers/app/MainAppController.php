<?php


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class MainAppController
{
    private $renderer;

    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request, Response $reponse, array $args)
    {
        return $this->renderer($reponse, 'app.phtml');
    }

}