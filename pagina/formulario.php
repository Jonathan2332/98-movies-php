<?php
include_once '../cabecalho.php';

include_once '../banco/Pagina.php';
include_once '../banco/Permissao.php';
include_once '../banco/Perfil.php';

$oPerfil = new Perfil();
$perfis = $oPerfil->recuperarTodos();

$oPagina = new Pagina();

$oPermissao = new Permissao();

if (!empty($_GET['idPagina']))
{
    $oPagina->carregarPorId($_GET['idPagina']);
    $permissoes = $oPermissao->carregarPorPagina($_GET['idPagina']);
}

$categorias = $_SESSION["usuario"]["categorias"];

function checkPermissao($permissoes, $idPerfil)
{
    foreach ($permissoes as $permissao) {
        if($idPerfil == $permissao['idPerfil'])
          return true;
    }
}
?>

<style type="text/css">

  .painel
  {
      color:white!important;
      font-size: 30px;
      background-color: red!important;
      border-color: white!important;
  }

</style>

<div class="navbar-bg-custom-light"></div>
<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
<nav id="navbar" class="navbar navbar-expand-lg navbar-light rounded custom-navbar">
  <img src="../res/imgs/98-movies.png" width="56" height="56">
  <button id="button-toggle" onclick="checkBackground('light')" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto mx-2">
        
      <li class="nav-item active">
        <a class="nav-link" href="../usuario/inicial.php"><span class="fas fa-home" aria-hidden="true"></span> Início</a>
      </li>
      <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="filmesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-film" aria-hidden="true"></span> Filmes
                </a>
                <div class="dropdown-menu" aria-labelledby="filmesDropdown">
                  <a class="dropdown-item" href="../filme/explorar.php">Explorar</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=populares">Populares</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=avaliados">Mais bem avaliados</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=lancamentos">Próximos lançamentos</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=cartaz">Em cartaz</a>
                </div>
            </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="fas fa-bars" aria-hidden="true"></span> Categorias
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
            <?php foreach($categorias as $index=>$categoria){ ?>
                <form class="form-inline my-2 my-lg-0 " action="../categoria/filtrar.php" method="get">
                  <button class="dropdown-item" type="submit" name="id" value="<?php echo $categoria['id']; ?>">
                  <?php echo $categoria['name']; ?></button>
                </form>
            <?php } ?>
        </div>
      </li>
      <li class="nav-item active">
          <a class="nav-link" href="../pessoa/inicial.php"><span class="fas fa-users" aria-hidden="true"></span> Pessoas</a>
      </li>
      <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-user-circle" aria-hidden="true"></span> <?php echo $_SESSION['usuario']['nome']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="perfilDropdown">
                    <a class="dropdown-item" href="../usuario/perfil.php">Meu perfil</a>
                    <a class="dropdown-item" href="../usuario/lista.php?type=favoritos">Meus favoritos</a>
                    <a class="dropdown-item" href="../usuario/lista.php?type=interesses">Lista de interesses</a>
                    <?php if($_SESSION['usuario']['idPerfil'] == 2) { ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../usuario/gerenciar.php">Gerenciar Usuários</a>
                        <a class="dropdown-item" href="index.php">Gerenciar Páginas</a>
                    <?php } ?>
                </div>
            </li>
      <li class="nav-item active">
        <a class="nav-link" href="../usuario/processamento.php?acao=logoff"><span class="fas fa-sign-out-alt" aria-hidden="true"></span> Sair</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0 mx-2" action="../filme/buscar.php" method="get">
      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" name="busca" id="busca" maxlength="50" required>

      <div class="dropdown">
        <button id="button-search" class="btn btn-success my-2 my-sm-0 dropdown-toggle" 
          type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="fas fa-search" aria-hidden="true" ></span> Buscar
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button class="dropdown-item" type="submit" name="type" value="movie">Filmes</button>
          <button class="dropdown-item" type="submit" name="type" value="person">Pessoas</button>
        </div>
      </div>

    </form>
  </div>
</nav>
  
  <div class="container" style="margin-top: 40px;">

    <div class="card" style="border-color: red">
      <div class="card-header painel"><span class="far fa-window-restore"></span> Gerenciar Páginas e Permissões</div>
          <div class="card-body">
             
            
          <form action="processamento.php?acao=salvar" method="post">
            <div class="form-group">
                
                <label style="font-size: 20px;">Por favor, preencha os dados abaixo.</label><br />

  
                    <input type="hidden" class="form-control" id="idPagina" name="idPagina" required
                           value="<?= $oPagina->getIdPagina(); ?>">

                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                           value="<?= $oPagina->getNome(); ?>">
                    
                    <label>Caminho</label>

                    <input type="text" class="form-control" id="caminho" name="caminho" required
                           value="<?= $oPagina->getCaminho(); ?>">
                    
                    <br>

                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="switchPublica" name="publica" <?= $oPagina->getPublica() ? 'checked' : ''; ?>>
                      <label class="custom-control-label" for="switchPublica">Pública</label>
                    </div>

                    <hr style="background-color: black;">

                    <fieldset>
                        <legend>Perfis com permissão a esta página</legend>

                        <?php foreach($perfis as $index=>$perfil){ ?>
                            <?php if (!empty($_GET['idPagina'])) $checked = checkPermissao($permissoes, $perfil['idPerfil']) ? 'checked' : ''; ?>
                            <div class="custom-control custom-checkbox">
                               <input type="checkbox" name="idPerfil[]" class="custom-control-input" value="<?= $perfil['idPerfil']; ?>" id="customCheck<?= $index; ?>" <?= !empty($_GET['idPagina']) ? $checked : '' ?>>
                               <label class="custom-control-label" for="customCheck<?= $index; ?>"><?= $perfil['nome']; ?></label>
                            </div>

                        <?php } ?>

                    </fieldset>
                    <br>
                    <div style="text-align: center;">
                      <button type="submit" class="btn btn-success btn-lg" id="continuar"><i class="fas fa-check"></i> Salvar</button>
                      <a href="index.php" class="btn btn-danger btn-lg"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
                </div>
            </form> 
        </div>        
    </div>
</div>
<script type="text/javascript">

function scrollFunction() 
{
    var user = '<?php echo $_SESSION['usuario']['idPerfil']; ?>';
    var navbar = $("#navbar");
    var button = $("#button-search");
    var isExpanded = $("#button-toggle").attr("aria-expanded");

    if(isExpanded == "true")
    {
        if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) 
        {
            navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
            navbar.css("background-color", user == 2 ? "red" : "rgb(92,184,92)");
            button.attr("class", "btn btn-outline-light my-2 my-sm-0 dropdown-toggle");
        }
        else 
        {
            navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
            navbar.css("background-color", user == 2 ? "red" : "rgb(92,184,92)");
            button.attr("class", "btn btn-outline-light my-2 my-sm-0 dropdown-toggle");
        }
    }
    else
    {
        if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) 
        {
            navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
            navbar.css("background-color", user == 2 ? "red" : "rgb(92,184,92)");
            button.attr("class", "btn btn-outline-light my-2 my-sm-0 dropdown-toggle");
        }
        else 
        {
            navbar.attr("class", "navbar navbar-expand-lg navbar-light rounded custom-navbar");
            navbar.css("background-color","transparent");
            button.attr("class", "btn btn-success my-2 my-sm-0 dropdown-toggle");
        }
    }  
}
</script>
<?php
include_once '../rodape.php'; ?>
