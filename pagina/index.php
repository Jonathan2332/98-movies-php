<?php
include_once '../cabecalho.php';
include_once '../banco/Pagina.php';

$pagina = new Pagina();
$aPagina = $pagina->recuperarTodos();

$categorias = $_SESSION["usuario"]["categorias"];

?>

<style type="text/css">
  .titulo
  {
      font-size: 30px;
      background-color: red!important;
      color: white!important;
      border-color:white!important;
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
      <div class="card-header titulo"><span class="far fa-window-restore"></span> Páginas e Permissões</div>
          <div class="card-body">

                <a class="btn btn-success" href="formulario.php" style="color: white">Novo</a>
                <br>
                <br>
              
            
          <div class="table-responsive">

            <table id="itens" class="table table-bordered table-striped table-hover">
                  <thead>
                      <tr>
                          <th colspan="2" width="10%" style="text-align: center">Ações</th>
                          <th>Nome</th>
                          <th>Caminho</th>
                          <th>Pública</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($aPagina as $pagina) { ?>
                      <tr>
                          <td class="text-center">
                              <a href="formulario.php?idPagina=<?=$pagina['idPagina'] ?>">
                                  <span class="fas fa-edit text-success" style="color: green"></span>
                              </a>
                          </td>
                          <td class="text-center">
                              <a href="javascript:;" onclick="check(this, <?=$pagina['idPagina'] ?>)">
                                  <span class="fas fa-trash-alt text-danger" style="color: green"></span>
                              </a>
                          </td>
                          <td><?= $pagina['nome'] ?></td>
                          <td><?= $pagina['caminho'] ?></td>
                          <td><?= $pagina['publica'] ?></td>
                      </tr>
                  <?php } ?>
                  </tbody>
              </table>
              </div>
                
           </div>
        </div>
</div>
<script type="text/javascript">

function check(element, id)
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
          $.ajax({
            url: 'processamento.php?acao=excluir&idPagina='+id,
            success: function(retorno)
            {
                if(retorno)
                {
                      Swal.fire({
                        title: 'Operação realizada com sucesso!',
                        type: 'success',
                        showConfirmButton: true,
                          onClose: () => {
                              document.getElementById("itens").deleteRow(element.parentNode.parentNode.rowIndex);
                          }
                      })
                }
                else
                {
                    Swal.fire({
                      title: 'Ocorreu um erro.',
                      type: 'error',
                      showConfirmButton: true
                    })
                }
            }
        });
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