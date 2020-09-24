<?php

namespace App\Controller;


use App\Helpers\Auth;
use App\Helpers\Db;
use App\Helpers\Validator;
use App\Model\Post;
use App\Model\Task;

class PostController extends BaseController
{
    public function index(): void
    {
        $posts = $this->getAll();
        $this->print('/post/index.html.twig', [
            'posts' => $posts,
            'header' => "Список статей"
        ]);
    }

    public function getAll()
    {
        $orderBy = 'title';
        $orderDirection = 'ASC';

        $post = new Post();

        return $post->getAll($orderBy, $orderDirection);
    }

    public function show(string $slug): void
    {
        $post = Post::getBySlug($slug);
        $this->print('/post/show.html.twig', [
            'post' => $post,
            'header' => (string)$post['title'],
        ]);
    }
}