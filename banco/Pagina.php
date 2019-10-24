<?php

include_once '../conexao.php';

class Pagina
{

    protected $idPagina;
    protected $nome;
    protected $caminho;
    protected $publica;

    /**
     * @return mixed
     */
    public function getIdPagina()
    {
        return $this->idPagina;
    }

    /**
     * @param mixed $idPagina
     */
    public function setIdPagina($idPagina)
    {
        $this->idPagina = $idPagina;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCaminho()
    {
        return $this->caminho;
    }

    /**
     * @param mixed $caminho
     */
    public function setCaminho($caminho)
    {
        $this->caminho = $caminho;
    }

    /**
     * @return mixed
     */
    public function getPublica()
    {
        return $this->publica;
    }

    /**
     * @param mixed $publica
     */
    public function setPublica($publica)
    {
        $this->publica = $publica;
    }


    public function recuperarTodos()
    {
        $conexao = new Conexao();

        $sql = "select * from pagina order by nome";
        return $conexao->recuperarTodos($sql);
    }

    public function carregarPorId($idPagina)
    {

        $conexao = new Conexao();


        $sql = "select * from pagina where idPagina = '$idPagina'";

        $dados = $conexao->recuperarTodos($sql);

        $this->idPagina = $dados[0]['idPagina'];
        $this->nome = $dados[0]['nome'];
        $this->caminho = $dados[0]['caminho'];
        $this->publica = $dados[0]['publica'];
    }

    public function inserir($dados)
    {
        $nome = $dados['nome'];
        $caminho = $dados['caminho'];
        $publica = !empty($dados['publica']) ? 1 : 0;

        $conexao = new Conexao();

        $sql = "insert into pagina (nome, caminho, publica) 
                            values ('$nome', '$caminho', $publica)";

        $idPagina = $conexao->executar($sql);

        $this->vincularPerfil($idPagina, $dados);

        return $idPagina;
    }

    public function vincularPerfil($idPagina, $dados)
    {
        include_once '../banco/Permissao.php';

        $permissao = new Permissao();

        if(isset($dados['idPerfil'])){

            foreach ($dados['idPerfil'] as $perfil) {

                $aDados = [
                    'idPagina' => $idPagina,
                    'idPerfil' => $perfil,
                ];
               
                $permissao->inserir($aDados);
            }
        }

    }

    public function alterar($dados)
    {
        $idPagina = $dados['idPagina'];
        $nome = $dados['nome'];
        $caminho = $dados['caminho'];
        $publica = !empty($dados['publica']) ? 1 : 0;

        $conexao = new Conexao();

        $sql = "update pagina set
                  nome = '$nome',
                  caminho = '$caminho',
                  publica = $publica
                where idPagina = '$idPagina'";

        $conexao->executar($sql);
        $this->vincularPerfil($idPagina, $dados);
        return $idPagina;
    }

    public function excluir($idPagina)
    {
        $conexao = new Conexao();

        $sql = "delete from permissao where idPagina = '$idPagina';
        delete from pagina where idPagina = '$idPagina';";
        return $conexao->executar($sql);
    }
}