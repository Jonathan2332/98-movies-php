<?php

include_once '../conexao.php';

class Usuario{
	
	protected $idUsuario;
	protected $idEndereco;
	protected $idPerfil;
	protected $nome;
	protected $sobrenome;
	protected $email;
	protected $senha;
	protected $data_nasc;
	protected $telefone;
	protected $preferencias;
	protected $sexo;
	protected $celular;
	protected $cont_adulto;
	protected $age;
	protected $foto;
	
	public function getIdUsuario(){
		return $this->idUsuario;
	}
	
	public function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}

	public function getIdEndereco(){
		return $this->idEndereco;
	}
	
	public function setIdEndereco($idEndereco){
		$this->idEndereco = $idEndereco;
	}

	public function getPreferencias(){
		return $this->preferencias;
	}
	
	public function setPreferencias($preferencias){
		$this->preferencias = $preferencias;
	}

	public function getNome(){
		return $this->nome;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getSobrenome(){
		return $this->sobrenome;
	}
	
	public function setSobrenome($sobrenome){
		$this->sobrenome = $sobrenome;
	}

	public function getEmail(){
		return $this->email;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}

	public function getDataNascimento(){
		return $this->data_nasc;
	}
	
	public function setDataNascimento($data_nasc){
		$this->data_nasc = $data_nasc;
	}

	public function getCelular(){
		return $this->celular;
	}
	
	public function setCelular($celular){
		$this->celular = $celular;
	}

	public function getTelefone(){
		return $this->telefone;
	}
	
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}

	public function getGenero(){
		return $this->sexo;
	}
	
	public function setGenero($sexo){
		$this->sexo = $sexo;
	}

	public function getSenha(){
		return $this->senha;
	}
	
	public function setSenha($senha){
		$this->senha = $senha;
	}


	public function getIdPerfil(){
		return $this->idPerfil;
	}
	public function setIdPerfil($idPerfil){
		$this->idPerfil = $idPerfil;
	}

	public function getConteudoAdulto(){
		return $this->cont_adulto;
	}
	public function setConteudoAdulto($cont_adulto){
		$this->cont_adulto = $cont_adulto;
	}

	public function getAge(){
		return $this->age;
	}

	public function getFoto(){
		return $this->foto;
	}

	public function setFoto($foto){
		return $this->foto;
	}

	public function convertDate($originalDate)
	{
		$date = str_replace('/', '-', $originalDate);
		return date('Y-m-d', strtotime($date));
	}
	public function cleanString($string)
	{
		if(is_array($string))
			return array_map('addslashes', $string);
		else
			return addslashes($string);
	}
	
	public function inserir($dados){
		
		$idPerfil = $dados['idPerfil'];

		$nome = $this->cleanString($dados['nome']);
		$sobrenome = $this->cleanString($dados['sobrenome']);
		$email = $this->cleanString($dados['email']);
		$senha = $this->cleanString($dados['senha']);

		$data_nasc = $this->convertDate($dados['data_nasc']);
		
		$telefone = $dados['telefone'];
		$celular = $dados['celular'];
		$sexo = $dados['sexo'];
		$cont_adulto = $dados['cont_adulto'];

		$preferencias = $dados['categoria'];

		include_once 'Endereco.php';
		$endereco = new Endereco();
		$idEndereco = $endereco->inserir($dados);//retorna o ultimo id inserido

		if($idEndereco != 0)
		{
			$sql = "insert into usuario (idPerfil,nome,sobrenome,email,senha,data_nasc,telefone,sexo,celular,cont_adulto,idEndereco) values ($idPerfil,'$nome','$sobrenome','$email','$senha','$data_nasc','$telefone','$sexo','$celular', $cont_adulto, $idEndereco);";
			$oConexao = new Conexao();
			$idUsuario = $oConexao->executar($sql);

			if($idUsuario != 0)
			{
				foreach ($preferencias as $preferencia) 
				{
					$sql = "insert into usuario_categoria(idUsuario, idCategoria) values($idUsuario,$preferencia);";
					$oConexao = new Conexao();
					if($oConexao->executar($sql) == 0)
					{
						$this->excluir($idUsuario);
						return false;
					}
				}
				$sql = "select * from usuario_categoria where idUsuario = $idUsuario";

				$oConexao = new Conexao();
				$categorias = $oConexao->recuperarTodos($sql);

				$this->updateSession($idUsuario, $idPerfil, $idEndereco, $nome, $email, $sexo, $cont_adulto, $categorias);
				return true;
	        }
	        return false;
		}
		return false;
	}
	
	public function alterar($dados){

		$idUsuario = $dados['idUsuario'];
		$idPerfil = $dados['idPerfil'];
		$idEndereco = $dados['idEndereco'];

		$nome = $this->cleanString($dados['nome']);
		$sobrenome = $this->cleanString($dados['sobrenome']);
		$email = $this->cleanString($dados['email']);
		$senha = $this->cleanString($dados['senha']);

		$data_nasc = $this->convertDate($dados['data_nasc']);

		$telefone = $dados['telefone'];
		$celular = $dados['celular'];
		$sexo = $dados['sexo'];
		$cont_adulto = $dados['cont_adulto'];
		
		$preferencias = $dados['categoria'];

		include_once 'Endereco.php';
		$endereco = new Endereco();

		if($endereco->alterar($dados))
		{
			$sql = "update usuario set
						nome = '$nome', sobrenome = '$sobrenome',
						email = '$email', senha = '$senha', 
						data_nasc = '$data_nasc', telefone = '$telefone', 
						sexo = '$sexo', celular = '$celular', 
						idEndereco = $idEndereco, idPerfil = $idPerfil,
						cont_adulto = $cont_adulto
					where idUsuario = $idUsuario";
			
			$oConexao = new Conexao();
			if($oConexao->executar($sql))
			{
				$sql = "delete from usuario_categoria where idUsuario = $idUsuario;";
				$oConexao = new Conexao();
				if($oConexao->executar($sql))
				{
					foreach ($preferencias as $preferencia) 
					{
						
						$sql = "insert into usuario_categoria(idUsuario, idCategoria) values($idUsuario, $preferencia);";
						$oConexao = new Conexao();
						if(!$oConexao->executar($sql))
							return false;
					}
					if(!empty($_SESSION['usuario']['created']))
					{
						if(empty($_FILES['foto']) || $_FILES['foto']['error'] == 4)
						{
							$sql = "select * from usuario_categoria where idUsuario = $idUsuario";

							$oConexao = new Conexao();
							$categorias = $oConexao->recuperarTodos($sql);

							if($idUsuario == $_SESSION['usuario']['idUsuario'])//ADM
							{
								$this->updateSession($idUsuario, $idPerfil, $idEndereco, $nome, $email, $sexo, $cont_adulto, $categorias);
							}
	        				return true;
						}
						else
						{
							if($this->fazerUpload($idUsuario))
							{
								$sql = "select * from usuario_categoria where idUsuario = $idUsuario";

								$oConexao = new Conexao();
								$categorias = $oConexao->recuperarTodos($sql);

								if($idUsuario == $_SESSION['usuario']['idUsuario'])//ADM
								{
									$this->updateSession($idUsuario, $idPerfil, $idEndereco, $nome, $email, $sexo, $cont_adulto, $categorias);
								}
		        				return true;
							}
							else
							{
								$sql = "select * from usuario_categoria where idUsuario = $idUsuario";

								$oConexao = new Conexao();
								$categorias = $oConexao->recuperarTodos($sql);

								$this->updateSession($idUsuario, $idPerfil, $idEndereco, $nome, $email, $sexo, $cont_adulto, $categorias);
								return false;
							}
						}
						return false;
					}
				}
				return false;
			}
			return false;
		}
		return false;
	}

	public function excluir($idUsuario)
	{
		$oConexao = new Conexao();

		$sqlendereco = "select idEndereco from usuario where idUsuario = $idUsuario";
		$resultado = $oConexao->recuperarTodos($sqlendereco);
		$idEndereco = $resultado[0]['idEndereco'];

		$sqlfoto = "select * from foto where idUsuario = $idUsuario";
		$resultado = $oConexao->recuperarTodos($sqlfoto);
		$file = empty($resultado) ? '' : '../res/imgs/usuario/upload/' . $resultado[0]['caminho'];

		$sql = "delete from usuario_categoria where idUsuario = $idUsuario;";

		if($oConexao->executar($sql))
		{
			$sql = "delete from foto where idUsuario = $idUsuario;";

			if($oConexao->executar($sql))
			{

				if(!empty($file))
					if(file_exists($file))
						unlink($file);

				$sql = "delete from favorito where idUsuario = $idUsuario;";

				if($oConexao->executar($sql))
				{
					$sql = "delete from interesse where idUsuario = $idUsuario;";
					if($oConexao->executar($sql))
					{
						$sql = "delete from usuario where idUsuario = $idUsuario;";

						if($oConexao->executar($sql))
						{
							include_once 'Endereco.php';
							$oEndereco = new Endereco();
							return $oEndereco->excluir($idEndereco);
						}
						return false;
					}
					return false;
				}
				return false;
			}
			return false;
		}
		return false;
	}
	
	public function recuperarTodos(){
		
		$sql = "select * from usuario";
		
		$oConexao = new Conexao();
		return $oConexao->recuperarTodos($sql);
	}

	public function logar($dados)
	{
		$dados = $this->cleanString($dados);

		$email = $dados['email'];
		$senha = $dados['password'];
		$keepLoged = !empty($dados['keepLoged']) ? 1 : 0;

		$sql = "select idUsuario, idEndereco, sexo, nome, idPerfil, email, cont_adulto from usuario where(email like '$email' and senha like '$senha');";

		$oConexao = new Conexao();
		$dados = $oConexao->recuperarTodos($sql);
		
		if (count($dados))
		{
			$idUsuario = $dados[0]['idUsuario'];

			$sql2 = "select * from usuario_categoria where idUsuario = $idUsuario";

			$oConexao = new Conexao();
			$categorias = $oConexao->recuperarTodos($sql2);

			$this->updateSession($idUsuario, $dados[0]['idPerfil'], $dados[0]['idEndereco'], 
				$dados[0]['nome'], $dados[0]['email'], $dados[0]['sexo'], 
				$dados[0]['cont_adulto'], $categorias);

			if($keepLoged)
				setcookie('PHPSESSID', $_COOKIE['PHPSESSID'], time()+2592000);		

            return true;
        }
        return false;
	}
	public function logoff()
    {
        unset($_SESSION['usuario']);

        if (isset($_COOKIE['PHPSESSID'])) {
        	unset($_COOKIE['PHPSESSID']);
        	setcookie("PHPSESSID", "", 1);
    	}
		
        session_destroy();
        return true;
    }
	public function carregarPorId($idUsuario){
	
		$sql = "select * from usuario where idUsuario = $idUsuario";
		
		$oConexao = new Conexao();
		$usuarios = $oConexao->recuperarTodos($sql);

		$sql2 = "select * from usuario_categoria where idUsuario = $idUsuario";

		$oConexao = new Conexao();
		$categorias = $oConexao->recuperarTodos($sql2);

		$sql3 = "select * from foto where idUsuario = $idUsuario";

		$oConexao = new Conexao();
		$foto = $oConexao->recuperarTodos($sql3);

		$this->idUsuario = $usuarios[0]['idUsuario'];
		$this->idEndereco = $usuarios[0]['idEndereco'];
		$this->idPerfil = $usuarios[0]['idPerfil'];
		$this->nome = $usuarios[0]['nome'];
		$this->sobrenome = $usuarios[0]['sobrenome'];
		$this->telefone = $usuarios[0]['telefone'];
		$this->celular = $usuarios[0]['celular'];
		$this->data_nasc = $usuarios[0]['data_nasc'];
		$this->email = $usuarios[0]['email'];
		$this->sexo = $usuarios[0]['sexo'];
		$this->senha = $usuarios[0]['senha'];
		$this->cont_adulto = empty($usuarios[0]['cont_adulto']) ? 0 : $usuarios[0]['cont_adulto'];
		$this->age = date_diff(date_create($usuarios[0]['data_nasc']), date_create('now'))->y;
		$this->foto = empty($foto[0]['caminho']) ? '../res/imgs/no-perfil-photo.png' : '../res/imgs/usuario/upload/' . $foto[0]['caminho'];
		$this->preferencias = $categorias;

	}
	public function verificarEmail($email)
	{
		$email = $this->cleanString($email);

		$sql = "select * from usuario where email like '$email'";
		$oConexao = new Conexao();
		$retorno = $oConexao->recuperarTodos($sql);
		if(!empty($retorno[0]['email']))
		{
			echo 'Este email já esta sendo usado!';
		}
		else
		{
			echo 'Não existe';
		}
	}
	public function fazerUpload($idUsuario){
        if(!$_FILES['foto']['error'])
        {
            $nomeArquivo = date('YmdHis'). '_' . $idUsuario . '_' . $_FILES['foto']['name'];
            
            $origem = $_FILES['foto']['tmp_name'];
            $destino = '../res/imgs/usuario/upload/' . $nomeArquivo;
            if(move_uploaded_file($origem , $destino))
            {
            	$oldFile = $this->checkExist($idUsuario);

            	if(!empty($oldFile))
            		$sql = "update foto set caminho = '$nomeArquivo' where idUsuario = $idUsuario";
            	else
            		$sql = "insert into foto (idUsuario , caminho) values ('$idUsuario','$nomeArquivo')";
            
            	$oConexao = new Conexao();
            	if($oConexao->executar($sql))
            	{
            		if(!empty($oldFile))
            			if (file_exists($destino)) 
    						unlink('../res/imgs/usuario/upload/' . $oldFile[0]['caminho']);

            		return true;
            	}
            	else
            	{
            		if (file_exists($destino)) 
            		{
            			unlink($destino);
					    return false;
					}  
					else 
					    return false;  
            	}
            }
        }
        return false;
	}
	public function checkExist($idUsuario){
        $sql = "select * from foto where idUsuario = $idUsuario";

		$oConexao = new Conexao();
		$oldFile = $oConexao->recuperarTodos($sql);
		if(empty($oldFile))
			return '';
		else
			return $oldFile;
	}
	public function updateSession($idUsuario, $idPerfil, $idEndereco, $nome, $email, $sexo, $cont_adulto, $preferencias)
	{
		$_SESSION['usuario']['idUsuario'] = $idUsuario;
        $_SESSION['usuario']['idPerfil'] = $idPerfil;
        $_SESSION['usuario']['idEndereco'] = $idEndereco;
        $_SESSION['usuario']['nome'] = $nome;
        $_SESSION['usuario']['email'] = $email;
        $_SESSION['usuario']['sexo'] = $sexo;
        $_SESSION['usuario']['cont_adulto'] = empty($cont_adulto) ? 0 : $cont_adulto;
        $_SESSION['usuario']['preferencias'] = $preferencias;
        $_SESSION['usuario']['created'] = true;
	}
	public function possuiAcesso()
    {

        $raizUrl = '/projetos/98movies/';

        $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        $sql = "select * from pagina where publica = 1";

        $conexao = new Conexao();

        $paginas = $conexao->recuperarTodos($sql);

        foreach($paginas as $pagina){
            if ($url == $raizUrl . $pagina['caminho']){
                return true;
            }
        }


        if(!empty($_SESSION['usuario']['created'])){

            $perfil = $_SESSION['usuario']['idPerfil'];

            $sql = "select * from permissao pe 
                    inner join pagina pa on pa.idPagina = pe.idPagina
                    where idPerfil = $perfil;";
                    

            $paginas = $conexao->recuperarTodos($sql);

            foreach($paginas as $pagina){
            	
                if ($url == $raizUrl . $pagina['caminho']){
                    return true;
                }
            }
        }

        return false;
    }
}
?>