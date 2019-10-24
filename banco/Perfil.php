<?php

include_once '../conexao.php';

class Perfil{
	
	protected $idPerfil;
	protected $nome;
	
	public function getIdPerfil(){
		return $this->idPerfil;
	}
	
	public function setIdPerfil($idPerfil){
		$this->idPerfil = $idPerfil;
	}

	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	
	public function inserir($dados){
		
		$nome = $dados['nome'];
		
		$sql = "insert into perfil (nome) 
						   values ('$nome')";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function alterar($dados){
		
		$idPerfil = $dados['idPerfil'];
		$nome     = $dados['nome'];
	
		$sql = "update perfil set
					nome = '$nome'
				where idPerfil = $idPerfil";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}

	public function excluir($idPerfil){
	
		$sql = "delete from perfil where idPerfil = $idPerfil;";
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function recuperarTodos(){
		
		$sql = "select * from perfil";
		
		$oConexao = new Conexao();
		return $oConexao->recuperarTodos($sql);
	}

	public function carregarPorId($idPerfil){
	
		$sql = "select * from perfil where idPerfil = $idPerfil";
		
		$oConexao = new Conexao();
		$perfis = $oConexao->recuperarTodos($sql);
		
		$this->idPerfil = $perfis[0]['idPerfil'];
		$this->nome = $perfis[0]['nome'];
	}
}
?>