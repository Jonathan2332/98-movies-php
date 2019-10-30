<?php 

include_once '../cabecalho.php';
include_once '../api/API.php';


$oApi = new API();
$categorias = $oApi->getCategorias();

$cont_adulto = $_SESSION['usuario']['cont_adulto'];


if(empty($_SESSION['usuario']['categorias']))
	$_SESSION['usuario']['categorias'] = $categorias;
else if(count($categorias) != count($_SESSION['usuario']['categorias']))
	$_SESSION['usuario']['categorias'] = $categorias;

$type = empty($_GET['type']) ? 'populares' : $_GET['type'];

switch ($type) {
	case 'populares':
		$title = 'populares';
		break;
	case 'avaliados':
		$title = 'mais bem avaliados';
		break;
	case 'lancamentos':
		$title = 'que estreiam em breve';
		break;
	default://cartaz
		$title = 'em cartaz';
		break;
}

switch ($type) {
	case 'populares':
		$titleBased = 'populares';
		break;
	case 'avaliados':
		$titleBased = 'mais bem avaliados';
		break;
	case 'lancamentos':
		$titleBased = 'que estreiam este ano';
		break;
	default://cartaz
		$titleBased = 'em cartaz';
		break;
}

function getCategoriaName($id)
{
	foreach ($_SESSION['usuario']['categorias'] as $index => $categoria) 
	{
		if($categoria['id'] == $id)
			return $categoria['name'];
	}
}

?>
<style type="text/css">
	body
	{
		background-color: #262626;
	}
	.painel-bg
	{
		background-color: #262626;
		border: none;
	}
	.overlay .overbottom
	{ 
		position: absolute; 
		bottom: 0; 
		left: 0; 
		right: 0; 
		padding: 4px 6px;
		color: #fff; 
		background: #222; 
		background: rgba(0,0,0,.8); 
	}
	.fade-list {
		opacity: 0;
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-ms-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		transition: all 0.5s ease-in-out;
	}
</style>
	<div class="navbar-bg-custom-dark"></div>
    <!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark rounded custom-navbar">
      <img src="../res/imgs/98-movies.png" width="56" height="56">
      <button id="button-toggle" onclick="checkBackground('dark')" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                            <a class="dropdown-item" href="gerenciar.php">Gerenciar Usuários</a>
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
	<!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->
	<div class="form-group">
		<div class="card painel-bg">
			<div class="card-body">

				<div class="row">
					<div class="col-12">
						<h2 style="color:white;">Filmes <?php echo $title; ?></h2>
						<hr style="background-color: white">
				  		<div id="lista" class="fade-list overlay flex-images">
			  				
			  				
						</div>
						<br>
						<div class="d-flex justify-content-center">
							<div id="loader" class="spinner-border text-light" role="status" style="display: none!important"></div>
						</div>
						<br>
						<div class="d-flex justify-content-center">
							<div id="custom-pagination">
							
							</div>
						</div>
						<br>
						
					</div>
				</div>
				<?php if($type != 'cartaz') { ?>
					<?php foreach ($_SESSION['usuario']['preferencias'] as $index => $categoria) { ?>
						<div class="row">
							<div class="col-12">
								<h2 style="color:white;">Filmes <?= $titleBased; ?> baseado em <?= getCategoriaName($categoria['idCategoria']) ?></h2>
								<hr style="background-color: white">
						  		<div id="lista-<?= $categoria['idCategoria'] ?>" class="fade-list overlay flex-images">
					  				
					  				
								</div>
								<br>
								<div class="d-flex justify-content-center">
									<div id="loader-preferencia-<?= $categoria['idCategoria'] ?>" class="spinner-border text-light" role="status" style="display: none!important"></div>
								</div>
								<br>
								<div class="d-flex justify-content-center">
									<div id="custom-pagination-<?= $categoria['idCategoria'] ?>">
									
									</div>
								</div>
								<br>
							</div>
						</div>
					<?php } ?>
	 			<?php } ?>
			</div> <!-- FECHANDO PAINEL BODY -->
		</div><!-- FECHANDO PRIMARY PANEL -->
</div><!-- FECHANDO FORM GROUP -->
<script>

document.getElementsByTagName("BODY")[0].onresize = function() 
{
	new flexImages({selector: '.overlay', rowHeight: detectmob() ? 450 : 400, truncate: false });
};

var type = '<?= $type; ?>';

carregarFilme(type, 1, true, false, <?= $cont_adulto; ?>, null);

if(type != 'cartaz')
{
	var preferencias = <?= json_encode($_SESSION['usuario']['preferencias']); ?>;
	for(var index in preferencias) {
		carregarFilme('<?= $type; ?>', 1, true, true, <?= $cont_adulto ?>, preferencias[index]['idCategoria']);
	}
}


window.onscroll = function() {scrollFunction()};

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
            navbar.attr("class", "navbar navbar-expand-lg navbar-dark rounded custom-navbar");
            navbar.css("background-color","transparent");
            button.attr("class", "btn btn-success my-2 my-sm-0 dropdown-toggle");
        }
    }  
}

function updateList(condition, based, idCat)
{
	if(based)
	{

		var element = $('#lista-'+idCat);
		var loader = document.getElementById("loader-preferencia-"+idCat);
		var pages = document.getElementById("custom-pagination-" + idCat);

		if(condition)//show
		{
			new flexImages({selector: '.overlay', rowHeight: detectmob() ? 450 : 400, truncate: false });

			var loaderImage = $('.loader-image');
	     	loaderImage.each(function(i, elem)
		    {
		    	$('#img-based-'+i+'-'+idCat).load(function(){
		    		$('#loader-based-'+i+'-'+idCat).css('background-image', 'none');
				});
		    });

			element.css('opacity', 1);
			element.css('pointer-events', 'auto');
		 	loader.setAttribute('style', 'display:none !important');

		 	pages.setAttribute('style', 'display:inline-block !important');

		}
		else//hide
		{
			element.css('pointer-events', 'none');
		    element.css('opacity', 0);

		    pages.setAttribute('style', 'display:none !important');
			loader.setAttribute('style', 'display:inline-block !important');
		}
	}
	else
	{
		var element = $('#lista');
		var loader = document.getElementById("loader");
		var pages = document.getElementById("custom-pagination");


		if(condition)//show
		{
			new flexImages({selector: '.overlay', rowHeight: detectmob() ? 450 : 400, truncate: false });

			var loaderImage = $('.loader-image');
	     	loaderImage.each(function(i, elem)
		    {
		    	$('#img-'+i).load(function(){
		    		$('#loader-'+i).css('background-image', 'none');
				});
		    });

			element.css('opacity', 1);
			element.css('pointer-events', 'auto');
		 	loader.setAttribute('style', 'display:none !important');

		 	pages.setAttribute('style', 'display:inline-block !important');

		}
		else//hide
		{
			element.css('pointer-events', 'none');
		    element.css('opacity', 0);

		    pages.setAttribute('style', 'display:none !important');
			loader.setAttribute('style', 'display:inline-block !important');
		}
	}
	
}
function carregarFilme(tipo, pagina, initializing, based, cont_adulto, idCat)
{
	updateList(false, based, idCat);
	if(based)
	{
		var element = $('#lista-'+idCat);
		element.load('../filme/processamento.php?acao=carregar-based&tipo='+tipo+'&page=' + pagina + '&idCat=' + idCat + '&cont_adulto=' +cont_adulto,
			function (responseText, textStatus, XMLHttpRequest) {
		    if (textStatus == "success") 
		    {
	         	updateList(true, based, idCat);

	         	if(initializing)
	         		initPagination(tipo, based, cont_adulto, idCat);
		    }
		    if (textStatus == "error") {
		         // oh noes!
		    }
	  	});
	}
	else
	{
		var element = $('#lista');
		element.load('../filme/processamento.php?acao=carregar-'+tipo+'&page=' + pagina,
			function (responseText, textStatus, XMLHttpRequest) {
		    if (textStatus == "success") 
		    {
	         	updateList(true, based, idCat);

	         	if(initializing)
	         		initPagination(tipo, based, cont_adulto, idCat);
		    }
		    if (textStatus == "error") {
		         // oh noes!
		    }
	  	});
	}
}

function initPagination(tipo, based, cont_adulto, idCat)
{
	if(based)
	{
		$('#custom-pagination-'+idCat).pagination({
	        items: document.getElementById("total-items-"+idCat).value,
	        itemsOnPage: document.getElementById("items-page-"+idCat).value,
	        displayedPages: detectmob() ? 4 : 5,
	        ellipsePageSet: false,
	        edges: 1,
	        prevText: '',
	        nextText: '',
	        cssStyle: 'custom-theme',
	        onPageClick(pageNumber, event)
	        {
	        	carregarFilme(tipo, pageNumber, false, based, cont_adulto, idCat);
	        }
	    });
	}
	else
	{
		$('#custom-pagination').pagination({
	        items: document.getElementById("total-items").value,
	        itemsOnPage: document.getElementById("items-page").value,
	        displayedPages: detectmob() ? 4 : 5,
	        ellipsePageSet: false,
	        edges: 1,
	        prevText: '',
	        nextText: '',
	        cssStyle: 'custom-theme',
	        onPageClick(pageNumber, event)
	        {
	        	carregarFilme(tipo, pageNumber, false, based, cont_adulto, idCat);
	        }
	    });
	}    
}

</script>

<?php
	include_once '../rodape.php';
?>