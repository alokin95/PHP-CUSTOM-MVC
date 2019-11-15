<?php


namespace App\Controllers;


class PostController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware(['logged.check', 'kita']);
    }

    public function indexAction()
    {
        $posts = $this->repository->table('posts')->all();
        return $this->response->render('posts/index', compact('posts'));
    }

    public function showAction($post)
    {
        $post = $this->repository->table('posts')->findById($post);
        return $this->response->render('posts/show', compact('post'));
    }
}