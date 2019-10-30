<?php
include_once '../cabecalho.php';

include_once '../api/API.php';

$id = $_GET['id'];

$oApi = new API();
$person = $oApi->getDetailPerson($id);

$categorias = $_SESSION["usuario"]["categorias"];

$colorGreen = 'color: rgb(92,184,92);';
$colorOrange = 'color: #ffbb33;';
$unavailable = 'Não disponível';

$birthday = $person['birthday'] == 0 ? $unavailable : date('d-m-Y', strtotime($person['birthday']));
$place_of_birth = empty($person['place_of_birth']) ? $unavailable : $person['place_of_birth'];
$homepage = empty($person['homepage']) ? $unavailable : $person['homepage'];
$nomes = empty($person['also_known_as']) ? $unavailable : $person['also_known_as'];

switch ($person['gender']) {
  case 1:
    $genero = 'Feminino';
    break;
  case 2:
    $genero = 'Masculino';
    break;
  default:
    $genero = 'Desconhecido';
    break;
}

?>
<style type="text/css">
    .painel
    {
        border-color:black;
    }
    .painel-bg-img
    {
        background-size:     cover;                      
        background-repeat:   no-repeat;
        background-position: center center;
        background-color: rgba(255,255,255,0.85);
        background-blend-mode: lighten;
    }
    .painel-bg-dark
    {
        background-color: #262626;
    }
    a.media:link {
      color: rgb(92,184,92);
    }
    a.media:visited {
      color: rgb(92,184,92);
    }

    a.media:hover {
      color: rgb(92,184,92);
    }

    a.media:active {
      color: rgb(92,184,92);
    }
    .fade-list {
        opacity: 0;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
    }
    h2
    {
        font-size: 31px!important;
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
            <div id="nav-cat" class="dropdown-menu" aria-labelledby="navbarDropdown">
              
                <?php foreach($categorias as $index=>$categoria){ ?>
                    <form class="form-inline my-2 my-lg-0 " action="../categoria/filtrar.php" method="get">
                      <button class="dropdown-item" type="submit" name="id" value="<?php echo $categoria['id']; ?>">
                      <?php echo $categoria['name']; ?></button>
                    </form>
                <?php } ?>
            </div>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="inicial.php"><span class="fas fa-users" aria-hidden="true"></span> Pessoas</a>
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
                            <a class="dropdown-item" href="../pagina/index.php">Gerenciar Páginas</a>
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

<!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->
<div class="container">
    <div class="card painel">
        <div class="painel-bg-img loader-img">
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <center>
                                <img src="<?php echo empty($person['profile_path']) ? $oApi->getNoPoster() : $oApi->getApiImg($person['profile_path'], 500) ?>" style="margin-top: 15px; width: 250px; height: 375px;" class="img-rounded">
                            </center>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <h1 class="py-2"><?php echo $person['name']; ?></h1>

                            <h2>Biografia</h2>
                            <?php if($person['changed'] == 1 && !empty($person['biography'])) { ?>
                                <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
                                <b style="color: #5bc0de"> Biografia não disponível em PT-BR, exibindo no idioma disponível.</b>
                            <?php } else if($person['changed'] == 1 && empty($person['biography'])) {?>
                                <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
                                <b style="color: #5bc0de"> Não há dados sobre a biografia desta pessoa.</b>
                            <?php } else if(empty($person['biography'])) { ?>
                                <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
                                <b style="color: #5bc0de"> Não há dados sobre a biografia desta pessoa.</b>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <p><?php echo $person['biography']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card painel">
        <div class="painel-bg-dark">
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4" style="color: white">
                            <h4><i class="fas fa-user-alt"></i> Informações pessoais</h4>
                            <hr style="background-color: white" />
                            
                            <h5 style="display: inline;">Conhecido(a) por</h5>
                            <h6 style="color: rgb(92,184,92);"><?= $person['known_for_department']; ?></h6>

                            <h5 style="display: inline;">Gênero</h5>
                            <h6 style="<?= $genero == 'Desconhecido' ? $colorOrange : $colorGreen; ?>"><?= $genero; ?></h6>

                            <h5 style="display: inline;">Nascimento</h5>
                            <h6 style="<?= $birthday == $unavailable ? $colorOrange : $colorGreen; ?>"><?= $birthday; ?></h6>

                            <?php if(!empty($person['deathday'])) { ?>

                            <h5 style="display: inline;">Falecimento</h5>
                            <h6 style="color: rgb(92,184,92);"><?= date('d-m-Y', strtotime($person['deathday'])); ?></h6>

                            <?php } ?>

                            <h5 style="display: inline;">Local de Nascimento</h5>
                            <h6 style="<?= $place_of_birth == $unavailable ? $colorOrange : $colorGreen; ?>"><?= $place_of_birth; ?></h6>

                            <h5 style="display: inline;">Site oficial</h5>
                            <h6>
                              <a href="<?= $homepage == $unavailable ? 'javascript:;' : $homepage; ?>" style="<?= $homepage == $unavailable ? $colorOrange . 'text-decoration: none;' : $colorGreen; ?>">
                                <?= $homepage; ?>
                                  
                                </a>
                            </h6>

                            <h5 style="display: inline;">Também conhecido(a) como</h5>
                            <?php if(is_array($nomes)) { ?>
                              <?php foreach ($nomes as $nome) { ?>
                                <h6 style="color: rgb(92,184,92);"><?= $nome; ?></h6>
                              <?php } ?>
                            <?php } else if($nomes != $unavailable) { ?>
                                <h6 style="color: rgb(92,184,92);"><?= $nomes; ?></h6>
                            <?php } else { ?>
                                <h6 style="<?= $colorOrange; ?>"><?= $nomes; ?></h6>
                            <?php } ?>
                            <br>
                            <h4><i class="fas fa-photo-video"></i> Mídia</h4>
                            <hr style="background-color: white" />

                            <h5 style="display: inline;">Fotos <span id="total-fotos" style="color: rgb(92,184,92);">-</span></h5>
                            
                            <div id="fotos" class="fade-list">

                            </div>
                            <!-- loader -->
                            <div id="loader-fotos">
                                <div class="spinner-grow text-light" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <!-- loader -->
                            <br>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                          <div id="trabalhos">

                          </div>
                          <div class="d-flex justify-content-center">
                                <div id="loader-trabalhos" class="spinner-border text-success" role="status" style="display: none!important"></div>
                          </div>
                        </div>

                        
                    </div>
                    
 
                </div>
            </div>
        </div>
    </div>
</div>
    
<script type="text/javascript">

var itemsPerPage = 6;

loadMedia(<?php echo $id; ?>, 'fotos');
loadWorks(<?php echo $id; ?>);


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

function loadMedia(id, tipo)
{
    var element = $('#'+tipo);
    var total = document.getElementById("total-"+tipo);
    var loader = document.getElementById("loader-"+tipo);

    element.css('pointer-events', 'none');
    element.css('opacity', 0);
    loader.style.display = 'block'; 

    element.load('processamento.php?acao=carregar-' + tipo + '&id=' + id,
        function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            element.css('opacity', 1);
            element.css('pointer-events', 'auto');
            loader.style.display = 'none';
            total.innerHTML = document.getElementById("count-"+tipo).value;

            $('[data-fancybox="gallery-' + tipo +'"]').fancybox({
                buttons: [
                    "slideShow",
                    "fullScreen",
                    "download",
                    "thumbs",
                    "close"
                  ],
                  thumbs: {
                    autoStart: true, // Display thumbnails on opening
                  },
            });
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}
function loadWorks(id)
{
    var element = $('#trabalhos');
    var loader = document.getElementById("loader-trabalhos");

    element.css('pointer-events', 'none');
    element.css('opacity', 0);
    loader.style.display = 'block'; 

    element.load('processamento.php?acao=carregar-trabalhos&id=' + id,
        function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            element.css('opacity', 1);
            element.css('pointer-events', 'auto');
            loader.setAttribute('style', 'display:none !important');

            if(detectmob())
            {
                if($('#itens-atuacao') != null)
                {
                    $('#itens-atuacao').attr('class', 'table table-sm table-hover table-dark');
                    $('#itens-atuacao th').each(function () 
                    {
                        if($(this).attr("id") == 'rate')
                        {
                            $(this).attr('class', 'col-2 text-center');
                        }
                        else if($(this).hasClass("text-center"))
                        {
                            $(this).attr('class', 'col-3 text-center');
                        }
                        else
                        {
                            $(this).attr('class', 'col-7');
                        }
                    });

                    $('#itens-atuacao td').each(function () 
                    {
                        if($(this).attr("id") == 'rate')
                        {
                            $(this).attr('class', 'col-2 text-center');
                        }
                        else if($(this).hasClass("text-center"))
                        {
                            $(this).attr('class', 'col-3 text-center');
                        }
                        else
                        {
                            $(this).attr('class', 'col-7');
                        }
                    });
                }
                if($('#itens-outros') != null)
                {
                    $('#itens-outros').attr('class', 'table table-sm table-hover table-dark');
                    $('#itens-outros th').each(function () 
                    {
                        if($(this).attr("id") == 'rate')
                        {
                            $(this).attr('class', 'col-2 text-center');
                        }
                        else if($(this).hasClass("text-center"))
                        {
                            $(this).attr('class', 'col-3 text-center');
                        }
                        else
                        {
                            $(this).attr('class', 'col-7');
                        }
                    });

                    $('#itens-outros td').each(function () 
                    {
                        if($(this).attr("id") == 'rate')
                        {
                            $(this).attr('class', 'col-2 text-center');
                        }
                        else if($(this).hasClass("text-center"))
                        {
                            $(this).attr('class', 'col-3 text-center');
                        }
                        else
                        {
                            $(this).attr('class', 'col-7');
                        }
                    });
                }
               
            }
            
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}

</script>
<?php
include_once '../rodape.php';
?>