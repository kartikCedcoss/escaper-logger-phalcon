<?php

use Phalcon\Mvc\Controller;


class SignupController extends Controller
{
    public function indexAction()
    {
    }
    public function registerAction()
    {
        $user = new Users();
        $escape = new MyEscaper();

        $data = array(
            "name" => $escape->sanitize($this->request->getPost('name')),
            "email" => $escape->sanitize($this->request->getPost('email')),
            "description" => $escape->sanitize($this->request->getPost('description')),
            "password" => $escape->sanitize($this->request->getPost('password'))
        );

        $user->assign(
            $data,
            [
                'name',
                'email',
                'description',
                'password',
            ]
        );


        $success = $user->save();

        // passing the result to the view
        
        $this->view->success = $success;

        if ($success) {
            $this->view->message = "Thanks for registering!";
        } else {
            $this->view->message = "Sorry, the following problems were generated:<br>"
                . implode('<br>', $user->getMessages());

            return $this->logger->excludeAdapters(['login'])->error(implode('<br>', $user->getMessages()));
        }
    }
}
