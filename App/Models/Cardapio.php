<?php
namespace App\Models;

use BF\Model\Model;
use PDO;

class Cardapio extends Model{

    private $idprato;
    private $nomeprato;
    private $precoprato;
    private $descricaoprato;
    private $imagemprato;
    private $disponivel;
    private $idcardapio;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function getCardapioAdmin(){

        $campos = "p.prato_id as idprato, p.nome as nome_prato, p.descricao as descricao_prato, p.preco as preco_prato, c.cardapio_id as idcardapio, c.disponivel as disponivel";
        $inner = "left join cardapio as c on c.prato_fk = p.prato_id";
        $query = "SELECT ".$campos." FROM prato as p ".$inner." order by p.prato_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $cardapio = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $cardapio;

    }

    public function addCardapio(){

        $query = "INSERT INTO cardapio(disponivel, prato_fk) VALUES(:disponivel, :prato_fk)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':disponivel', $this->__get('disponivel'));
        $stmt->bindValue(':prato_fk', $this->__get('idprato'));
        $stmt->execute();

        return $this;

    }

    public function verifica(){

        $query = "SELECT disponivel FROM cardapio WHERE cardapio_id = :cardapio_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cardapio_id', $this->__get('idcardapio'));
        $stmt->execute();

        $disponivel = $stmt->fetch(PDO::FETCH_ASSOC);

        if($disponivel['disponivel'] != ''){
            $this->__set('disponivel', $disponivel['disponivel']);
        }

        return $this;

    }

    public function atualiza(){

        $set = "disponivel = :disponivel";
        $where = "cardapio_id = :cardapio_id AND prato_fk = :prato_fk";
        $query = "UPDATE cardapio SET ".$set." WHERE ".$where;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':disponivel', $this->__get('disponivel'));
        $stmt->bindValue(':cardapio_id', $this->__get('idcardapio'));
        $stmt->bindValue(':prato_fk', $this->__get('idprato'));
        $stmt->execute();

        return $this;

    }

    public function verificaDisponivel(){

        $query = "SELECT disponivel FROM cardapio WHERE cardapio_id = :cardapio_id AND disponivel = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cardapio_id', $this->__get('idcardapio'));
        $stmt->execute();

        $disponivel = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $disponivel;

    }

    public function getCardapioItem(){

        $campos = "p.prato_id as idprato, p.nome as nome_prato, p.descricao as descricao_prato, p.preco as preco_prato, p.imagem as imagem_prato, c.cardapio_id as idcardapio";
        $inner = "inner join cardapio as c on c.prato_fk = p.prato_id";
        $where = "c.cardapio_id = :cardapio_id";
        $query = "SELECT ".$campos." FROM prato as p ".$inner." WHERE ".$where." order by p.prato_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":cardapio_id", $this->__get('idcardapio'));
        $stmt->execute();

        $cardapio = $stmt->fetch(PDO::FETCH_ASSOC);

        if($cardapio['idprato'] != '' && $cardapio["idcardapio"] != ''){
            $this->__set('idprato', $cardapio['idprato']);
            $this->__set('nomeprato', $cardapio['nome_prato']);
            $this->__set('descricaoprato', $cardapio['descricao_prato']);
            $this->__set('precoprato', $cardapio['preco_prato']);
            $this->__set('imagemprato', $cardapio['imagem_prato']);
            $this->__set('idcardapio', $cardapio["idcardapio"]);
        }

        return $cardapio;

    }


}
?>