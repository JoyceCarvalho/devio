<?php 
namespace App\Models;

use BF\Model\Model;
use PDO;

class Pratos extends Model {

    private $idprato;
    private $nome;
    private $descricao;
    private $preco;
    private $imagem;
    private $idcardapio;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function cardapio(){

        $campos = "p.nome as nome_prato, p.descricao as descricao_prato, p.preco as preco_prato, p.imagem as imagem_prato, c.cardapio_id as idcardapio";
        $inner = "inner join cardapio as c on c.prato_fk = p.prato_id";
        $query = "SELECT ".$campos." FROM prato as p ".$inner." WHERE c.disponivel = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $cardapio = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $cardapio;

    }

}
?>