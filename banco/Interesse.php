<?php

include_once '../conexao.php';

class Interesse{
	
	protected $idFilme;
	protected $idUsuario;
	
	public function getIdFilme(){
		return $this->idFilme;
	}
	
	public function setIdFilme($idFilme){
		$this->idFilme = $idFilme;
	}

	public function getIdUsuario(){
		return $this->idUsuario;
	}
	
	public function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}
	
	public function inserir($dados){
		
		$idFilme = $dados['idFilme'];
		$idUsuario = $dados['idUsuario'];

		$sql = "insert into interesse (idFilme, idUsuario) values ($idFilme, $idUsuario)";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function alterar($dados){
		
		$idUsuario = $dados['idUsuario'];
		$idFilme = $dados['idFilme'];
	
		$sql = "update interesse set
					idFilme = $idFilme
				where idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}

	public function excluir($idFilme){
	
		$sql = "delete from interesse where idFilme = $idFilme;";
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function recuperarTodos(){
		
		$sql = "select * from interesse";
		
		$oConexao = new Conexao();
		return $oConexao->recuperarTodos($sql);
	}

	public function carregarPorId($idUsuario){
	
		$sql = "select * from interesse where idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		$interesses = $oConexao->recuperarTodos($sql);
		
		return $interesses;
	}

	public function verificarFilme($idFilme, $idUsuario){
	
		$sql = "select * from interesse where idFilme = $idFilme and idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		$interesses = $oConexao->recuperarTodos($sql);
		
		return $interesses;
	}
}
?>