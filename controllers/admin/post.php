<?php

namespace Admin\Controllers;

class Post_Controller extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct(get_class(), 'post', 'admin/post');
    }

    public function index($id)
    {
       $this->get($id);
    }

    public function add()
    {
        if (isset($_POST['content']) && isset($_POST['title'])) {
            if (!empty($_POST['title']) && !empty($_POST['content'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $post = array(
                    'title' => $title,
                    'content' => $content
                );
                $result = $this->model->add($post);

                $_POST = array();

                header("Location: " . trim($_SERVER['REQUEST_URI'], 'add'));
            }
        }

        $template_name = DX_ROOT_DIR . $this->views_dir . 'add.php';
        include_once $this->layout;
    }

    public function edit($id)
    {
        if (!empty($_POST['title']) && !empty($_POST['content'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            $post = array(
                'id' => $id,
                'title' => $title,
                'content' => $content
            );

            $this->model->update($post);

            header("Location: " . rtrim($_SERVER['REQUEST_URI'], 'post/edit/'.$id)."/post/");
            include_once $this->layout;
        }
        $post_for_edit = $this->model->get_by_id($id);

        if (empty($post_for_edit)) {
            echo("Nothing for edit.");
        }
        $post_for_edit = $post_for_edit[0];

        $template_name = DX_ROOT_DIR . $this->views_dir . 'edit.php';
        include_once $this->layout;
    }

    public function delete($id)
    {
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];

            $this->model->delete_by_id($id);

            header("Location: " . rtrim($_SERVER['REQUEST_URI'], 'post/delete/'.$id)."/post/");
            include_once $this->layout;
        }

        $post_for_delete = $this->model->get_by_id($id);
        if (empty($post_for_delete)) {
            die("Nothing for delete.");
        }
        $post_for_delete = $post_for_delete[0];

        $template_name = DX_ROOT_DIR . $this->views_dir . 'delete.php';
        include_once $this->layout;
    }

    public function get($id)
    {
        if (empty($id)) {
            $posts = $this->model->find();
        } else {
            $posts = $this->model->get_by_id($id);
        }
        $template_name = DX_ROOT_DIR . $this->views_dir . 'get.php';
        include_once $this->layout;
    }
}
