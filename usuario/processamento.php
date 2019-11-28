<?php session_start();

if(empty($_GET['acao']))
{
	if(isset($_SESSION['usuario']))
		unset($_SESSION['usuario']);

	header('location: login.php');
}
else if(!empty($_GET['acao']))
{
	if(($_GET['acao'] == 'logar' || $_GET['acao'] == 'salvar') && empty($_POST))
	{
		if(isset($_SESSION['usuario']))
			unset($_SESSION['usuario']);

		header('location: login.php');
	}
	else if(empty($_GET))
	{
		if(isset($_SESSION['usuario']))
			unset($_SESSION['usuario']);

		header('location: login.php');
	}
}

include_once '../banco/Usuario.php';
include_once '../banco/Favorito.php';
include_once '../banco/Interesse.php';

$oFavorito = new Favorito();
$oInteresse = new Interesse();
$oUsuario = new Usuario();


if($_GET['acao'] == 'verificarEmail')
{
	$resultado = $oUsuario->verificarEmail($_GET['email']);
	die;
}

if($_GET['acao'] == 'carregar-favoritos')
{
	include_once '../api/API.php';
	$oApi = new API();

    $ids = $oFavorito->carregarPorId($_GET['id']);

    $idsInteresse = $oInteresse->carregarPorId($_GET['id']);

	$resultado = $oApi->getFavoritos($ids, $idsInteresse);
	die;
}

if($_GET['acao'] == 'carregar-interesses')
{
	include_once '../api/API.php';
	$oApi = new API();

	$idsFavoritos = $oFavorito->carregarPorId($_GET['id']);

    $ids = $oInteresse->carregarPorId($_GET['id']);

	$resultado = $oApi->getInteresses($ids, $idsFavoritos);
	die;
}
if($_GET['acao'] == 'adicionar-favoritos')
{
	echo $resultado = $oFavorito->inserir($_GET);
	die;
}
if($_GET['acao'] == 'adicionar-interesses')
{
	echo $resultado = $oInteresse->inserir($_GET);
	die;
}
if($_GET['acao'] == 'excluir-favoritos')
{
	echo $resultado = $oFavorito->excluir($_GET['idFilme']);
	die;
}
if($_GET['acao'] == 'excluir-interesses')
{
	echo $resultado = $oInteresse->excluir($_GET['idFilme']);
	die;
}

switch ($_GET['acao']) 
{
	case 'salvar':
		if(empty($_POST['idUsuario']))
			$resultado = $oUsuario->inserir($_POST);
		else 
			$resultado = $oUsuario->alterar($_POST);

		if($resultado && !empty($_GET['cadastro']))
		{
			$_GET['acao'] = "logar";
		}
		break;
	case 'excluir':
	{
		$resultado = $oUsuario->excluir($_GET['idUsuario']);
	}
	break;
	case 'logar':
	{
		$resultado = $oUsuario->logar($_POST);
	}
	break;
	case 'logoff':
	{
		$resultado = $oUsuario->logoff();
	}
	break;
}

$status = $resultado ? 1 : 0;

?>
<html lang="pt">
<head>

	<title>98 Movies</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<link rel="shortcut icon" href="../res/imgs/favicon.ico" type="image/x-icon"/>
	<link type="text/css" rel="stylesheet" href="../res/js/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../res/js/animate.css"/>
  	<link rel="stylesheet" href="../res/js/sweetalert/dist/sweetalert2.css">
  	<link rel="stylesheet" href="../res/js/sweetalert-themes/dark/dark.css">

	<script type="text/javascript" src="../res/js/jquery-2.1.4.js"></script>
  	<script src="../res/js/sweetalert/dist/sweetalert2.js"></script>

</head>
<body>
<script>
//----------------------------Cadastrar e Logar Usuário---------------------------------------------
	<?php if($_GET['acao'] == 'salvar') { ?>
		var resultado = <?php echo $status; ?>;
		if(resultado == 1)
		{
			Swal.fire({
			  title: 'Operação realizada com sucesso!',
			  type: 'success',
			  showConfirmButton: true,
			  	onClose: () => {
		    		window.location.href = 'gerenciar.php';
	  			}
			});
		}
		else
		{
			Swal.fire({
			  title: 'Ocorreu um erro.',
			  type: 'error',
			  showConfirmButton: true,
			  	onClose: () => {
			  		<?php if(!empty($_GET['cadastro'])) { ?>
						window.location.href = 'cadastrar.php';
	    			<?php } else { ?>
		    			window.location.href = 'gerenciar.php';
	    			<?php } ?>
	  			}
			})
		}
	<?php } ?>
	//----------------------------Excluir Usuário---------------------------------------------
	<?php if($_GET['acao'] == "excluir") { ?> 
		
		var resultado = <?php echo $status; ?>;
		if(resultado == 1)
		{
			Swal.fire({
			  title: 'Operação realizada com sucesso!',
			  type: 'success',
			  showConfirmButton: true,
			  	onClose: () => {
			    	window.location.href = 'gerenciar.php';
		  		}
			})
		}
		else
		{
			Swal.fire({
			  title: 'Ocorreu um erro.',
			  type: 'error',
			  showConfirmButton: true,
			  	onClose: () => {
			    	window.location.href = 'gerenciar.php';
	  			}
			})
		}
	<?php } ?>
	//----------------------------Logar Usuário---------------------------------------------
	<?php if($_GET['acao'] == "logar") { ?> 

		var resultado = <?php echo $status; ?>;
		if(resultado == 1)
		{
			var sexo = '<?= !empty($_SESSION['usuario']['created']) ? $_SESSION["usuario"]["sexo"] : ''; ?>';
			var nome = '<?= !empty($_SESSION['usuario']['created']) ? addslashes($_SESSION["usuario"]["nome"]) : ''; ?>';
			var texto;
			if(sexo == 'M') texto = 'Bem Vindo ' + nome + '!';
			else if(sexo == 'F') texto = 'Bem Vinda ' + nome + '!';
			else texto = 'Olá ' + nome + '!';

			Swal.fire({
			  title: texto,
			  timer: 1500,
			  type: 'info',
			  showConfirmButton: false,
			  allowOutsideClick: false,
			  allowEscapeKey: false,
		    	html: $('<div>')
		    	.addClass('bounceInUp'),
		    	animation: false,
	  			customClass: 'animated bounceInUp',
	  			onClose: () => {
			    	window.location.href = 'inicial.php';
			  	}
			})
		}
		else
		{
			Swal.fire({
			  title: 'Usuário ou senha inválidos!',
			  timer: 1500,
			  type: 'error',
			  showConfirmButton: false,
			  allowEscapeKey: false,
			  allowOutsideClick: false,
			  onClose: () => {
			    window.history.back();
			  }
			})
		}
	<?php } ?>
	//----------------------------Logoff Usuário---------------------------------------------
	<?php if($_GET['acao'] == "logoff") { ?> 
	
		Swal.fire({
		  title: 'Até a próxima! :)',
		  timer: 1500,
		  
		  showConfirmButton: false,
		  allowOutsideClick: false,
		  allowEscapeKey: false,
		  imageUrl: '../res/imgs/logoff.png',
		  imageWidth: 100,
		  html: $('<div>')
	    	.addClass('jackInTheBox'),
	    	animation: false,
  			customClass: 'animated jackInTheBox',
			onClose: () => {
			    window.location.href = 'login.php';
		  	}
		
		})

	<?php } ?>
</script>

</body>
</html>

