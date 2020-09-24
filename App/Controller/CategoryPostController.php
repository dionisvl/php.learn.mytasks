<?php

namespace App\Controller;


use App\Helpers\Auth;
use App\Helpers\Db;
use App\Helpers\Validator;
use App\Model\CategoryPost;
use App\Model\Post;
use App\Model\Task;

class CategoryPostController extends BaseController
{
    public function getAll()
    {
        $orderBy = 'title';
        $orderDirection = 'ASC';

        $category = new CategoryPost;

        return $category->getAll($orderBy, $orderDirection);
    }

    public function show(int $id): void
    {
        $category = CategoryPost::getById($id);
        $this->print('/post/show.html.twig', [
            'category' => $category,
            'header' => (string)$category['title'],
        ]);
    }
}