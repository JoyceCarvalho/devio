<?php
namespace App\Models;

use BF\Model\Model;
use PDO;

class Login extends Model {

    private $id;
    private $usuario;
    private $senha;
    private $nome;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function autentica_admin(){

        $campos = "admin_id as id, usuario, senha";
        $where = "usuario = :usuario and senha = :senha";
        $query = "SELECT ".$campos." FROM admin WHERE ".$where;
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

		if($usuario['id'] != '' && $usuario['usuario'] != '') {
			$this->__set('id', $usuario['id']);
			$this->__set('usuario', $usuario['usuario']);
		}

		return $this;

    }

    public function autentica_cliente(){

        $campos = "cliente_id as id, nome, usuario, senha";
        $where = "usuario = :usuario AND senha = :senha";
        $query = "SELECT ".$campos." FROM cliente WHERE ".$where;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":usuario", $this->__get('usuario'));
        $stmt->bindValue(":senha", $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != '') {
            $this->__set('id', $usuario['id']);
            $this->__set('usuario', $usuario['usuario']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;

    }

}