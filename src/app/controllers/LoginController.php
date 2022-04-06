<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
    }
    public function authAction()
    {
        $escape = new MyEscaper();
        if ($this->request->isPost()) {
            $email = $escape->sanitize($this->request->getPost('email'));
            $pass = $escape->sanitize($this->request->getPost('password'));
            $users = Users::findFirstByemail($email);
            if ($users) {
                if ($users->password == $pass) {

                    $this->response->redirect('../dashboard');
                } else {

                    $this->view->message = "Check Your Password";
                    return $this->logger->excludeAdapters(['signup'])->error($users->name . ':-Wrong Password');
                }
            } else {

                $this->view->message = "Check Your Email";
                return $this->logger->excludeAdapters(['signup'])->error('Email ' . $email . ' Does Not Found');
            }
        }
    }
    public function logoutAction()
    {
        $this->session->destroy();
        $rememberMeCookie = $this->cookies->get('remember-me');
        $rememberMeCookie->delete();
        $this->response->redirect('../login');
    }
}
