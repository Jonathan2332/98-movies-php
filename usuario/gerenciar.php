<?php
include_once '../cabecalho.php';
include_once '../banco/Usuario.php';

$oUsuario = new Usuario();
$usuarios = $oUsuario->recuperarTodos();

$categorias = $_SESSION["usuario"]["categorias"];
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
        <a class="nav-link" href="inicial.php"><span class="fas fa-home" aria-hidden="true"></span> Início</a>
      </li>
      <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="filmesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-film" aria-hidden="true"></span> Filmes
                </a>
                <div class="dropdown-menu" aria-labelledby="filmesDropdown">
                  <a class="dropdown-item" href="../filme/explorar.php">Explorar</a>
                  <a class="dropdown-item" href="inicial.php?type=populares">Populares</a>
                  <a class="dropdown-item" href="inicial.php?type=avaliados">Mais bem avaliados</a>
                  <a class="dropdown-item" href="inicial.php?type=lancamentos">Próximos lançamentos</a>
                  <a class="dropdown-item" href="inicial.php?type=cartaz">Em cartaz</a>
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
                    <a class="dropdown-item" href="perfil.php">Meu perfil</a>
                    <a class="dropdown-item" href="lista.php?type=favoritos">Meus favoritos</a>
                    <a class="dropdown-item" href="lista.php?type=interesses">Lista de interesses</a>
                    <?php if($_SESSION['usuario']['idPerfil'] == 2) { ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../usuario/gerenciar.php">Gerenciar Usuários</a>
                        <a class="dropdown-item" href="../pagina/index.php">Gerenciar Páginas</a>
                    <?php } ?>
                </div>
            </li>
      <li class="nav-item active">
        <a class="nav-link" href="processamento.php?acao=logoff"><span class="fas fa-sign-out-alt" aria-hidden="true"></span> Sair</a>
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
  <div class="card" style="border-color: red;">
    <div class="card-header painel"><span class="fas fa-users" aria-hidden="true"></span> Gerenciar Usuários</div>
      <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Opções</th>
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($usuarios as $usuario){ ?>
                <tr>
                  <th scope="row">
                      <a href="alterar.php?idUsuario=<?php echo $usuario['idUsuario']; ?>"><span class="fas fa-user-edit text-success" aria-hidden="true"></span></a>
                      <a onclick="check(<?php echo $usuario['idUsuario']; ?>)" href="javascript:;"><span class="fas fa-user-times" aria-hidden="true" style="color:red"></span></a>
                  </th>
                  <td><?php echo $usuario['idUsuario']; ?></td>
                  <td><?php echo $usuario['nome']; ?></td>
                  <td><?php echo $usuario['email']; ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>            
          </div>
      </div>
  </div>
</div><!-- Fechando a Classe Container -->
<script>

function check(id)
{
    Swal.fire({
      title: 'Você tem certeza?',
      text: "Você não pode reverter esta ação!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
          window.location.href="processamento.php?acao=excluir&idUsuario="+id;
      }
    });
}

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
    include_once '../rodape.php';
?>
