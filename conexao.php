<?php
class Conexao {
	
	protected $conexao;
	
	public function conectar()
	{
		$this->conexao = new PDO('mysql:host=localhost;dbname=98movies;charset=utf8', 'root', 'root');
	}
	
	public function desconectar()
	{
		unset($this->conexao);
	}
	public function executar($sql)
	{
		$this->conectar();
		$sth = $this->conexao->prepare($sql);
		$resultado = $sth->execute();

		$ultimoid = $this->conexao->lastInsertId();
		
		$this->desconectar();
		
		return $ultimoid ? $ultimoid : $resultado;
	}	
	
	public function recuperarTodos($sql)
	{
		$this->conectar();
		$resultado = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$this->desconectar();
		
		return $resultado;
	}	
	
}
?>