<?php

abstract class TwigController
{
    protected $model = null;
    protected $modelName = 'Base';
    protected $template;

    public function __construct($db)
    {
        include 'model/' . $this->modelName . '.php';
        $this->model = new $this->modelName($db);
    }

    public abstract function getAdd();

    protected function render($template, $params = [])
    {
        // шаблоны
        $loader = new Twig_Loader_Filesystem('view/');

        // временные файлы twig (.php)
        $twig = new Twig_Environment($loader, array(
            'cache' => './temp/cache',
            'auto_reload' => true,
        ));
        echo $twig->render($template, $params);
    }

    abstract protected function postAdd($params, $post);

    abstract protected function getThisModel();
}