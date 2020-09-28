<?php

namespace App\Controller;


use App\Model\CategoryPost;
use App\Model\Post;

class CategoryPostController extends BaseController
{
    public function getAll()
    {
        $orderBy = 'title';
        $orderDirection = 'ASC';

        $category = new CategoryPost();

        return $category->getAll($orderBy, $orderDirection);
    }

    public function show(string $slug): void
    {
        $category = CategoryPost::getBySlug($slug);
        $elements = Post::getByCategoryId($category['id']);

        $this->print('/category/show.html.twig', [
            'category' => $category,
            'posts' => $elements,
        ]);
    }
}