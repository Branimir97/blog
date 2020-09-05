<?php

namespace Controllers;

use Exceptions\TemplateNotFoundException;
use Models\View;
use Storage\MySqlDatabasePostStorage;

class HomeController extends View
{

    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->index();

    }

    public function index()
    {

        $posts = $this->getAllVisiblePosts();
        try
        {
            echo parent::render('HomeView', ['posts' => $posts]);

        } catch (TemplateNotFoundException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getAllVisiblePosts()
    {
        $storage = new MySqlDatabasePostStorage($this->db);

        return $storage->allVisible();
    }

    public function logoutAction()
    {
        session_unset();
        session_destroy();
        header("Location: /");
    }


}