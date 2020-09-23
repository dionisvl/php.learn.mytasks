<?php

namespace App\Controller;


use App\Helpers\Auth;
use App\Helpers\Db;
use App\Helpers\Validator;
use App\Model\Task;

class HomeController extends BaseController
{
    public function index()
    {
        $this->print('/home/index.html.twig');
    }

}