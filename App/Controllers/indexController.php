<?php
namespace App\Controllers;

use BF\Controller\Action;

class indexController extends Action {

    public function index(){
        $this->render("index", "mainlayout");
    }

    public function admin(){
        $this->render("admin", "emptylayout");
    }

    public function cliente(){
        
        if(!empty($_GET)){
            
            $this->view->dados = $_GET["item"];
            
        } 

        $this->render("cliente", "emptylayout");

    }

    public function registrar(){
        
        if(!empty($_GET)){
            
            $this->view->dados = $_GET["item"];
            
        } 

        $this->render("registrar", "emptylayout");

    }

}
?>