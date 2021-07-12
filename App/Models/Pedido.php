<?php
namespace App\Models;

use BF\Model\Model;
use PDO;

class Pedido extends Model{

    private $idpedido;
    private $concluido;
    private $total;
    private $idcliente;
    private $quantidade;
    private $nomePrato;
    private $precoPrato;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function cadastraPedido(){

        $query = "INSERT INTO pedido(cliente_fk) VALUES(:cliente_fk)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cliente_fk', $this->__get('idcliente'));
        $stmt->execute();

        return $this->getUltimoPedido();

    }

    public function getUltimoPedido(){

        $query = "SELECT pedido_id FROM pedido ORDER BY pedido_id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $ultimoId = $stmt->fetch(PDO::FETCH_ASSOC);

        if($ultimoId['pedido_id'] != ''){
            $this->__set('idpedido', $ultimoId['pedido_id']);
        }

        return $this;

    }

    public function cadastraComanda(){

        $query = "INSERT INTO comanda(pedido_fk, cardapio_fk, quantidade) VALUES(:pedido_fk, :cardapio_fk, :quantidade)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':pedido_fk', $this->__get('idpedido'));
        $stmt->bindValue(':cardapio_fk', $this->__get('idcardapio'));
        $stmt->bindValue(':quantidade', $this->__get('quantidade'));

        $stmt->execute();

        return $this;

    }

    public function getPedidos() {

        $campos = "p.pedido_id as pedido, p.concluido as concluido, c.quantidade as quantidade, pt.nome as nome, pt.preco as preco";
        $inner1 = "comanda as c ON c.pedido_fk = p.pedido_id";
        $inner2 = "cardapio as car ON car.cardapio_id = c.cardapio_fk";
        $inner3 = "prato as pt ON pt.prato_id = car.prato_fk";
        $query = "SELECT ".$campos." FROM pedido as p INNER JOIN ".$inner1." INNER JOIN ".$inner2." INNER JOIN ".$inner3." WHERE cliente_fk = :cliente_fk";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cliente_fk', $this->__get('idcliente'));
        $stmt->execute();

        $pedido = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $pedido;

    }

    public function getComandas() {

        $campos = "p.pedido_id as pedido, p.concluido as concluido, c.quantidade as quantidade, pt.nome as nome, pt.preco as preco, cli.nome as nome_cliente";
        $inner1 = "cliente as cli ON p.cliente_fk = cli.cliente_id";
        $inner2 = "comanda as c ON c.pedido_fk = p.pedido_id";
        $inner3 = "cardapio as car ON car.cardapio_id = c.cardapio_fk";
        $inner4 = "prato as pt ON pt.prato_id = car.prato_fk";
        $query = "SELECT ".$campos." FROM pedido as p INNER JOIN ".$inner1." INNER JOIN ".$inner2." INNER JOIN ".$inner3." INNER JOIN ".$inner4." WHERE concluido = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $pedido = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $pedido;

    }

    public function concluirPedido(){

        $query = "UPDATE pedido SET concluido = 1 WHERE pedido_id = :pedido_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':pedido_id', $this->__get('idpedido'));
        $stmt->execute();

        return $this;

    }

}
?>