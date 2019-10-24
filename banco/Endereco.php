<?php include_once '../conexao.php';

class Endereco
{
	protected $idEndereco;
	protected $cep;
	protected $complemento;
	protected $uf;
	protected $bairro;
	protected $localidade;

	public function getIdEndereco(){
		return $this->idEndereco;
	}
	
	public function setIdEndereco($idEndereco){
		$this->idEndereco = $idEndereco;
	}

	public function getCep(){
		return $this->cep;
	}
	
	public function setCep($cep){
		$this->cep = $cep;
	}

	public function getComplemento(){
		return $this->complemento;
	}
	
	public function setComplemento($complemento){
		$this->complemento = $complemento;
	}
	public function getUf(){
		return $this->uf;
	}
	
	public function setUf($uf){
		$this->uf = $uf;
	}
	public function getBairro(){
		return $this->bairro;
	}
	
	public function setBairro($bairro){
		$this->bairro = $bairro;
	}
	public function getLocalidade(){
		return $this->localidade;
	}
	
	public function setLocalidade($localidade){
		$this->localidade = $localidade;
	}

	public function cleanString($string)
	{
		if(is_array($string))
			return array_map('addslashes', $string);
		else
			return addslashes($string);
	}

	public function inserir($dados)
	{
		$cep = $dados['cep'];
		
		$complemento = $this->cleanString($dados['complemento']);
		$uf = $this->cleanString($dados['uf']);
		$bairro = $this->cleanString($dados['bairro']);
		$localidade = $this->cleanString($dados['localidade']);

		$sql = "insert into endereco (cep, complemento, uf, bairro, localidade) values('$cep','$complemento','$uf','$bairro', '$localidade')";

		$oConexao = new Conexao();

		return $oConexao->executar($sql);
	}
	public function alterar($dados)
	{
		$idEndereco = $dados['idEndereco'];
		$cep = $dados['cep'];

		$complemento = $this->cleanString($dados['complemento']);
		$uf = $this->cleanString($dados['uf']);
		$bairro = $this->cleanString($dados['bairro']);
		$localidade = $this->cleanString($dados['localidade']);
	
		$sql = "update endereco set
					cep = '$cep', complemento = '$complemento', uf = '$uf', bairro = '$bairro', localidade = '$localidade'
				where idEndereco = $idEndereco;";
		
		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}

	public function excluir($idEndereco){
	
		$sql = "delete from endereco where idEndereco = $idEndereco";

		$oConexao = new Conexao();
		return $oConexao->executar($sql);
	}
	
	public function recuperarTodos(){
		
		$sql = "select * from endereco";
		
		$oConexao = new Conexao();
		return $oConexao->recuperarTodos($sql);
	}

	public function carregarPorId($idEndereco){
	
		$sql = "select * from endereco where idEndereco = $idEndereco";
		
		$oConexao = new Conexao();
		$enderecos = $oConexao->recuperarTodos($sql);
		
		$this->idEndereco = $enderecos[0]['idEndereco'];
		$this->cep = $enderecos[0]['cep'];
		$this->complemento = $enderecos[0]['complemento'];
		$this->uf = $enderecos[0]['uf'];
		$this->bairro = $enderecos[0]['bairro'];
		$this->localidade = $enderecos[0]['localidade'];
	}

}

?>