<?php

namespace App\Controller;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class BaseController
{
    private $twigLoader;
    private $twig;

    public function __construct()
    {
        $this->twigLoader = new FilesystemLoader(PATH_ROOT . '/views');
        $this->twig = new Environment($this->twigLoader);
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function print(string $templateName, array $context = [])
    {
        $template = $this->twig->load($templateName);
        echo $template->render($context);
    }
}