<?php
namespace App\Controllers;

use BF\Controller\Action;
use BF\Model\Container;

class clienteController extends Action {

    public function index(){

        $cardapio = Container::getModel('Pratos');
        
        $this->view->dados = $cardapio->cardapio();

        $this->render('index', 'clientlayout');

    }

    public function carrinho(){
        
        session_start();

        if(empty($_SESSION)){
            session_destroy();
            header("Location: /cliente_login?item=".$_POST["prato"]."");
        } 

        $cardapio = Container::getModel('Cardapio');

        if(!empty($_SESSION["item"])){
            $cardapio->__set('idcardapio', $_SESSION["item"]);
            unset($_SESSION["item"]);
        } elseif(!empty($_POST["prato"])) {
            $cardapio->__set('idcardapio', $_POST["prato"]);
        }

        if(count($cardapio->verificaDisponivel()) > 0){
            $cardapio->getCardapioItem();
            
            $_SESSION['pedido'][] = array(
                'idprato' => $cardapio->__get('idprato'),
                'nome_prato' => $cardapio->__get('nomeprato'),
                'descricao_prato' => $cardapio->__get('descricaoprato'),
                'preco_prato' => $cardapio->__get('precoprato'),
                'imagem_prato' => $cardapio->__get('imagemprato'),
                'idcardapio' => $cardapio->__get('idcardapio')
            );
        }

        $prato = Container::getModel('Pratos');
        
        $this->view->dados = $prato->cardapio();

        $pedidos = Container::getModel('Pedido');
        $pedidos->__set('idcliente', $_SESSION["id_usuario"]);

        $pedido = $pedidos->getPedidos();

        if(!empty($pedido)){
            $aux = 0;
            foreach ($pedido as $ped) {

                if($aux != $ped->pedido){
                    $getPedido[$ped->pedido]["total"] = 0;
                    $getPedido[$ped->pedido]["concluido"] = $ped->concluido;
                }

                $getPedido[$ped->pedido]["pedido"][] = $ped->pedido;
                $getPedido[$ped->pedido]["nome"][] = "<td>" .$ped->nome. "</td><td>".$ped->quantidade."</td><td> R$ ".str_replace(".", ",", $ped->preco)."</td>";
                $getPedido[$ped->pedido]["total"] += $ped->quantidade*$ped->preco;

                $aux = $ped->pedido;
                
            }
            $this->view->pedidos = $getPedido;
        }
        $this->render('pedido', 'clientlayout');


    }

    
    public function registrar(){
        
        $cliente = Container::getModel('Cliente');

        if(!empty($_POST)){

            $cliente->__set('nome', $_POST["nome"]);
            $cliente->__set('usuario', $_POST["usuario"]);
            $cliente->__set('senha', md5($_POST['senha']));

            if($cliente->validarCadastro() && count($cliente->getUsuario()) == 0){

                if(!empty($cliente->cadastrar())){

                    $usuario = Container::getModel('Login');
    
                    $usuario->__set('usuario', $cliente->__get('usuario'));
                    $usuario->__set('senha', $cliente->__get('senha'));
    
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
    
                } else {
                    header("Location: /?login=erro");
                }
            } else {
                header("Location: /?login=erro");
            }

        }

    }

    public function fazer_pedido(){

        session_start();

        if(!empty($_POST)){

            $pedido = Container::getModel('Pedido');

            $pedido->__set('idcliente', $_SESSION["id_usuario"]);

            $pedido->cadastraPedido();

            if($pedido->__get('idpedido') != ''){
                
                foreach ($_SESSION["pedido"] as $ped) {

                    $pedido->__set('idcardapio', $_POST["idcardapio"][$ped["idcardapio"]]);
                    $pedido->__set('quantidade', $_POST["quantidade"][$ped["idcardapio"]]);
                    
                    $comanda = $pedido->cadastraComanda();
    
                }

            }

            if($comanda){
                unset($_SESSION["pedido"]);
                header("Location: /add_carrinho?mens=success");
            } else {
                header("Location: /add_carrinho?mens=error");
            }

        }

    }

    public function atualizar_pedido(){

        session_start();

        $nomeprato = $_POST["nomeprato"];
        $indice = array_search($nomeprato, $_SESSION['pedido']);
        unset($_SESSION['pedido'][$indice]);

        //$limpaArray = array_diff($_SESSION["pedido"], array($indice));

    }

}
?>