<?php
namespace App\Controllers;

use BF\Controller\Action;
use BF\Model\Container;

class adminController extends Action {

    public function index() {

        session_start();

        if($_SESSION['id_admin'] == '' && $_SESSION['usuario'] == ''){
            session_destroy();

            header("Location: /");
        }

        $cardapio = Container::getModel('Cardapio');

        $cardap = $cardapio->getCardapioAdmin();

        if(is_array($cardap)){
            
            $this->view->dados = $cardap;

        } else {
            $this->view->dados = "Nenhum prato cadastrado";
        }

        $pedidos = Container::getModel('Pedido');

        $pedido = $pedidos->getComandas();

        if(!empty($pedido)){
            $aux = 0;
            foreach ($pedido as $ped) {

                if($aux != $ped->pedido){
                    $getPedido[$ped->pedido]["total"] = 0;
                }
                $getPedido[$ped->pedido]["nome_cliente"] = $ped->nome_cliente;
                $getPedido[$ped->pedido]["pedido"] = $ped->pedido;
                $getPedido[$ped->pedido]["nome"][] = "<td> " .$ped->nome. "</td><td>".$ped->quantidade."</td><td>R$ ".str_replace(".", ",", $ped->preco)."</td>";
                $getPedido[$ped->pedido]["total"] += $ped->quantidade*$ped->preco;

                $aux = $ped->pedido;
                
            }
            $this->view->pedidos = $getPedido;
        }

        $this->render('index', 'adminlayout');
    }

    public function adicionar_prato(){
        
        session_start();

        if($_SESSION['id_admin'] == '' && $_SESSION['usuario'] == ''){
            session_destroy();
            header("Location: /");
        }

        $cardapio = Container::getModel('Cardapio');

        if(empty($_POST["cardap"])){
            
            $cardapio->__set('idprato', $_POST['prato']);
            $cardapio->__set('disponivel', 1);

            $cardap = $cardapio->addCardapio();

            if(!empty($cardap)){
                echo "Prato adicionado ao cardápio!";
            } else {
                echo "Ocorreu um problema ao adicionar o prato ao cardápio!";
            }

        } else {

            $cardapio->__set('idcardapio', $_POST['cardap']);
            
            $cardapio->verifica();

            //echo $cardapio->__get('disponivel');exit;

            if($cardapio->__get('disponivel') != ''){
                if($cardapio->__get('disponivel') == '1'){
                    $cardapio->__set('disponivel', '0');
                } else {
                    $cardapio->__set('disponivel', '1');
                }

                $cardapio->__set('idprato', $_POST['prato']);
                $cardapio->__set('idcardapio', $_POST['cardap']);

                $cardap = $cardapio->atualiza();

                if(!empty($cardap)){
                    echo "Cardapio atualizado!";
                } else {
                    echo "Ocorreu um problema ao atualizar o cardapio";
                }
            }

        }
        
    }

    public function concluir(){

        session_start();

        if($_SESSION['id_admin'] == '' && $_SESSION['usuario'] == ''){
            session_destroy();

            header("Location: /");
        }

        $pedido = Container::getModel('Pedido');

        $pedido->__set('idpedido', $_POST['pedido']);

        $pedido->concluirPedido();

        header('Location: /admin_acesso');

    }

}
?>