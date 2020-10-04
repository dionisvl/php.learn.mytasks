<?php

namespace App\Controller;


use App\Helpers\Auth;
use App\Helpers\Db;
use App\Helpers\Validator;
use App\Model\CategoryPost;
use App\Model\Task;

class HomeController extends BaseController
{
    public function index(): void
    {
        $categories = (new CategoryPostController())->getAll();
        $posts = (new PostController())->getAll();
        $this->print('/post_ghostwind/index.html.twig', [
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

}