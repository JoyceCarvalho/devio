<?php
namespace App;

use BF\Init\Bootstrap;

//Classe responsável pela definição das rotas do projeto
class Route extends Bootstrap {

    protected function initRoutes()
    {
        $route["home"] = array(
            "route"         => "/",
            "controller"    => "indexController",
            "action"        => "index"
        );

        $route["admin_login"] = array(
            "route"         => "/admin_login",
            "controller"    => "indexController",
            "action"        => "admin"
        );
        
        $route["cliente_login"] = array(
            "route"         => "/cliente_login",
            "controller"    => "indexController",
            "action"        => "cliente"
        );

        $route["registrarse"] = array(
            "route"         => "/registrarse",
            "controller"    => "indexController",
            "action"        => "registrar"
        );

        $route["logar_admin"] = array(
            "route"         => "/logar_admin",
            "controller"    => "authController",
            "action"        => "autenticar"
        );

        $route["logar_cliente"] = array(
            "route"         => "/logar_cliente",
            "controller"    => "authController",
            "action"        => "autenticar"
        );

        $route["logout"] = array(
            "route"         => "/logout",
            "controller"    => "authController",
            "action"        => "sair"
        );

        $route["admin_acesso"] = array(
            "route"         => "/admin_acesso",
            "controller"    => "adminController",
            "action"        => "index"
        );

        $route["add_cardapio"] = array(
            "route"         => "/add_cardapio",
            "controller"    => "adminController",
            "action"        => "adicionar_prato"
        );

        $route["concluir"] = array(
            "route"         => "/concluir",
            "controller"    => "adminController",
            "action"        => "concluir"
        );

        $route["cliente_acesso"] = array(
            "route"         => "/cliente_acesso",
            "controller"    => "clienteController",
            "action"        => "index"
        );

        $route["add_carrinho"] = array(
            "route"         => "/add_carrinho",
            "controller"    => "clienteController",
            "action"        => "carrinho"
        );

        $route["registrar"] = array(
            "route"         => "/registrar",
            "controller"    => "clienteController",
            "action"        => "registrar"
        );        

        $route["atualizar_pedido"] = array(
            "route"         => "/atualizar_pedido",
            "controller"    => "clienteController",
            "action"        => "atualizar_pedido"
        );

        $route["fazer_pedido"] = array(
            "route"         => "/fazer_pedido",
            "controller"    => "clienteController",
            "action"        => "fazer_pedido"
        );

        $this->setRoutes($route);
    }

}
?>