<?php

include_once '../conexao.php';

class Permissao
{

    protected $idPermissao;
    protected $idPagina;
    protected $idPerfil;

    public function inserir($dados)
    {
        $idPagina = $dados['idPagina'];
        $idPerfil = $dados['idPerfil'];

        $conexao = new Conexao();

        $sql = "insert into permissao (idPagina, idPerfil) 
                               values ('$idPagina', '$idPerfil')";

        return $conexao->executar($sql);
    }

    public function excluir($idPermissao)
    {
        $conexao = new Conexao();

        $sql = "delete from permissao where idPermissao = '$idPermissao'";
        return $conexao->executar($sql);
    }

    public function carregarPorPagina($idPagina)
    {
        $conexao = new Conexao();
        $sql = "select * from permissao where idPagina = $idPagina";
        
        return $conexao->recuperarTodos($sql);
    }
}