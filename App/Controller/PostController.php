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
        $posts = Post::getByCategoryId($post['category_id']);
        $this->print('/post_ghostwind/show.html.twig', [
            'post' => $post,
            'posts' => $posts,
            'header' => (string)$post['title'],
        ]);
    }

    public function create(): void
    {
        $this->print('/post_ghostwind/create.html.twig', []);
    }
}