<?php
namespace App\Controllers;

use BF\Controller\Action;
use BF\Model\Container;

class authController extends Action{

    public function autenticar(){

        $usuario = Container::getModel('Login');

        $usuario->__set('usuario', $_POST["usuario"]);
        $usuario->__set('senha', md5($_POST["senha"]));

        $usuario->autentica_admin();

        if($usuario->__get('id') != '' && $usuario->__get('usuario') != ''){

            session_start();

            $_SESSION["id_admin"]   = $usuario->__get('id');
            $_SESSION["usuario"]    = $usuario->__get('usuario');

            header('Location: /admin_acesso');

        } else {

            $usuario->autentica_cliente();

            if($usuario->__get('id') != '' && $usuario->__get('nome') != ''){

                session_start();

                $_SESSION['id_usuario'] = $usuario->__get('id');
                $_SESSION['nome']       = $usuario->__get('nome');
                $_SESSION['usuario']    = $usuario->__get('usuario');

                if ($_POST["item"] != '' && !empty($_POST["item"])) {
                    $_SESSION["item"] = $_POST["item"];
                    
                    header('Location: /add_carrinho');
                } else {
                    header('Location: /add_carrinho');
                }

                

            } else {

                header('Location: /?login=erro');

            }

        }

    }

    public function sair(){
        session_start();
		session_destroy();
		header('Location: /');
    }

}
?>