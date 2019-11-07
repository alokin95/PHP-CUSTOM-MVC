<?php


namespace App\Controllers;


class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->response->render('layout');
    }
}