<?php
include_once '../cabecalho.php';

if(empty($_GET['busca']))
  header('location: ../usuario/inicial.php');

$busca = $_GET['busca'];

if(empty($_GET['type']))
    $type = 'movie';
else if($_GET['type'] == 'movie')
    $type = $_GET['type'];
else if($_GET['type'] == 'person')
    $type = $_GET['type'];
else
    $type = 'movie';

$categorias = $_SESSION["usuario"]["categorias"];
$cont_adulto = $_SESSION["usuario"]["cont_adulto"];

?>
<style type="text/css">    
  body
  {
      background-color: #262626;
  }
  .painel-bg
  {
      background-color: #262626;
      border-color:none;
  }
  .overlay .overbottom
  { 
      position: absolute; 
      bottom: 0; 
      left: 0; 
      right: 0; 
      padding: 4px 6px; 
      font-size: 13px; 
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
  <!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
  <?php include_once '../res/navbar/dark.php' ?>
  <!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->

  <div class="form-group">
        <div class="card painel-bg">
            <div class="card-body ">
                <h2 style="color:white;">Buscando por: <?= $busca; ?></h2>
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
            </div>
        </div>
    </div>
<script>

carregarFilme('<?= addslashes($busca); ?>', '<?= $type; ?>', 1, true, <?= $cont_adulto ?>);

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

function updateList(condition)
{
    var element = $('#lista');
    var loader = document.getElementById("loader");
    var pages = document.getElementById("custom-pagination");

    if(condition)//show
    {
        new flexImages({selector: '.overlay', rowHeight: 400, truncate: false });

        var loaderImage = $('.loader-image');
        loaderImage.each(function(i, elem){
            $('#img-'+i).load(function()
            {
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
function carregarFilme(busca, tipo, pagina, initializing, cont_adulto)
{
    updateList(false);
    var element = $('#lista');
    element.load('processamento.php?acao=carregar-busca&page=' + pagina+ '&busca=' + encodeURIComponent(busca) + '&cont_adulto=' +cont_adulto+'&type='+tipo,
    function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            updateList(true);

            if(initializing)
              initPagination(busca, tipo, cont_adulto);
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}
function initPagination(busca, tipo, cont_adulto)
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
            carregarFilme(busca, tipo, pageNumber, false, cont_adulto);
        }
    });
}



</script>

<?php
include_once '../rodape.php';
?>