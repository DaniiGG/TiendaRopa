<?php

namespace controllers;

use Lib\pages;

class errorController {
    private Pages $pages;
    public function __construct()
    {
        $this->pages = new Pages();
    }

    public function error404() {
        $this->pages->render('error/error', ['titulo' => 'Página no encontrada']);
    }

}