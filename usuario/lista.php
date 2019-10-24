<?php
include_once '../cabecalho.php';

if(empty($_GET['type']))
    $type = 'favoritos';
else if($_GET['type'] == 'favoritos')
    $type = $_GET['type'];
else if($_GET['type'] == 'interesses')
    $type = $_GET['type'];
else
    $type = 'favoritos';


$categorias = $_SESSION["usuario"]["categorias"];
?>


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
  <div class="card" style="border-color: <?= $type == 'favoritos' ? 'red' : '#007bff' ?>;">
    <div class="card-header" style="font-size: 40px; color:white!important; background-color: <?= $type == 'favoritos' ? 'red' : '#007bff' ?>!important; border-color: white!important;">
      <span class="fas fa-<?= $type == 'favoritos' ? 'heart' : 'bookmark' ?>" aria-hidden="true"></span> Lista de <?= $type; ?></div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <table id="itens" class="table table-hover">
              <thead class="thead-dark">
                <tr class="d-flex">
                  <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">Ações</th>
                  <th class="col-6 col-sm-6 col-md-6 col-lg-9">Filme</th>
                  <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">Ano</th>
                  <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center"><span class="fas fa-star"></span></th>
              </tr>
              </thead>
              <tbody id="table-<?= $type ?>">
              
              </tbody>
            </table>
            <div class="d-flex justify-content-center">
                  <div id="loader" class="spinner-border <?= $type == 'favoritos' ? 'text-danger' : 'text-primary' ?>" role="status" style="display: none!important"></div>
            </div>       
          </div>
        </form>
      </div>
  </div>
</div><!-- Fechando a Classe Container -->
<script>

carregarLista();

function carregarLista()
{
    var tipo = '<?= $type?>';
    var loader = document.getElementById("loader");
    var table = $("#table-"+tipo);

    loader.setAttribute('style', 'display:inline-block !important');

    table.load('processamento.php?acao=carregar-' + tipo + '&id=' + <?= $_SESSION["usuario"]["idUsuario"] ?>,
        function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            loader.setAttribute('style', 'display:none !important');
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}


function check(element, tipo, id)
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
            url: 'processamento.php?acao=excluir-' + tipo + '&idFilme='+id,
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
var request;
function add(tipo, id, element)
{
    if($(element).attr('value') == 'checked') 
    {
        Swal.fire({
          title: 'Este item já foi adicionado!',
          type: 'info',
          showConfirmButton: true
        });
        return;
    }
    else if(request != null && request.state() == 'pending')
    {
        Swal.fire({
          title: 'Aguarde, o item está sendo adicionado!',
          type: 'info',
          showConfirmButton: true
        });
    }
    var reverse = tipo == 'favoritos' ? 'interesses' : 'favoritos';
    request = $.ajax({
            url: 'processamento.php?acao=adicionar-' + reverse + '&idFilme=' + id + '&idUsuario=' + <?= $_SESSION['usuario']['idUsuario'] ?>,
            success: function(retorno)
            {
                if(retorno)
                {
                      Swal.fire({
                        title: 'Adicionado a lista de ' + reverse + ' com sucesso!',
                        type: 'success',
                        showConfirmButton: true,
                         onClose: () => {
                              $(element.children[0]).attr('class', 'fas fa-check text-success');
                              $(element).attr('value', 'checked');
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
