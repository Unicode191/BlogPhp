<?php
namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller {

    public function loginAction() {
      debug($this->layout);
      $this->view->render('Вход');
    }

    public function addAction() {
        $this->view->render('Добавить пост');
    }

    public function editAction() {
        $this->view->render('Редактировать пост');
    }

    public function deleteAction() {
        exit('Удаление');
    }

    public function logout() {
        exit('Выход');
    }

}
