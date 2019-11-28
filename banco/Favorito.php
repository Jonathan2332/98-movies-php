<?php

include_once '../conexao.php';

class Favorito{
	
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

		$sql = "insert into favorito (idFilme, idUsuario) 
						   values ($idFilme, $idUsuario)";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function alterar($dados){
		
		$idUsuario = $dados['idUsuario'];
		$idFilme = $dados['idFilme'];
	
		$sql = "update favorito set
					idFilme = $idFilme
				where idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}

	public function excluir($idFilme){
	
		$sql = "delete from favorito where idFilme = $idFilme;";
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function recuperarTodos(){
		
		$sql = "select * from favorito";
		
		$oConexao = new Conexao();
		return $oConexao->recuperarTodos($sql);
	}

	public function carregarPorId($idUsuario){
	
		$sql = "select * from favorito where idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		$favoritos = $oConexao->recuperarTodos($sql);

		return $favoritos;
	}

	public function verificarFilme($idFilme, $idUsuario){
	
		$sql = "select * from favorito where idFilme = $idFilme and idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		$favoritos = $oConexao->recuperarTodos($sql);
		
		return $favoritos;
	}
}
?>