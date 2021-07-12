<?php
namespace App\Models;

use BF\Model\Model;
use PDO;

class Cliente extends Model {

    private $idcliente;
    private $nome;
    private $usuario;
    private $senha;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function cadastrar(){

        $campos = "(nome, usuario, senha)";
        $valores = "(:nome, :usuario, :senha)";
        $query = "INSERT INTO cliente".$campos." VALUES".$valores;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->__get('nome'));
        $stmt->bindValue(":usuario", $this->__get('usuario'));
        $stmt->bindValue(":senha", $this->__get('senha'));

        $stmt->execute();

        return $this;

    }

    public function validarCadastro() {
		$valido = true;

		if(strlen($this->__get('nome')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('usuario')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('senha')) < 3) {
			$valido = false;
		}

		return $valido;
	}

    public function getUsuario(){

        $query = "SELECT usuario FROM cliente WHERE usuario = :usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":usuario", $this->__get('usuario'));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);       
    }

}
?>