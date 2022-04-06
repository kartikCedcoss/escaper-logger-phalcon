<?php

   use Phalcon\Mvc\Controller;
   use Phalcon\Paginator\Adapter\Model as PaginatorModel;


class DashboardController extends Controller
{
    public function indexAction()
    {
        
         $config = $this->di->get("config");
         $this->view->date = $config->get("app")->get("timezone");
         $this->view->timezone = $config->get("app")->get("time");
       
         $this->view->users = Users::find(); 
         
       
    }
}