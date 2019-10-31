<?php
include_once '../cabecalho.php';

include_once '../api/API.php';
include_once '../banco/Favorito.php';
include_once '../banco/Interesse.php';

$id = $_GET['id'];

$oApi = new API();
$filme = $oApi->getDetailMovie($id);

$categorias = $_SESSION["usuario"]["categorias"];

$colorGreen = 'color: rgb(92,184,92);';
$colorOrange = 'color: #ffbb33;';
$unavailable = 'Não disponível';

$budget = $filme['budget'] == 0 ? $unavailable : '$' . number_format($filme['budget'], 2);
$revenue = $filme['revenue'] == 0 ? $unavailable : '$' . number_format($filme['revenue'], 2);

$oFavorito = new Favorito();
$oInteresse = new Interesse();

$valueFavorito = empty($oFavorito->verificarFilme($id, $_SESSION["usuario"]["idUsuario"])) ? '' : 'checked';
$valueInteresse = empty($oInteresse->verificarFilme($id, $_SESSION["usuario"]["idUsuario"])) ? '' : 'checked';

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
    .equipe-tecnica .over 
    { 
        position: absolute; 
        bottom: 0; 
        left: 0; 
        right: 0; 
        padding: 4px 6px; 
        font-size: 13px; 
        color: #fff; 
        background: #222; 
        background: rgba(0,0,0,.7); 
    }
    .elenco .over 
    { 
        position: absolute; 
        bottom: 0; 
        left: 0; 
        right: 0; 
        padding: 4px 6px; 
        font-size: 13px; 
        color: #fff; 
        background: #222; 
        background: rgba(0,0,0,.7); 
    }
    .fade-list {
        opacity: 0;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
    }
    .itens{
         display: none;
    }
    .fa-chevron-left:active {
       color: rgb(92,184,92)!important;
    }
    .fa-chevron-right:active {
       color: rgb(92,184,92)!important;
    }
    h2
    {
        font-size: 31px!important;
    }

</style>

<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
<?php include_once '../res/navbar/light.php' ?>
<!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->
<div class="container">
    <div class="card painel">
        <div class="painel-bg-img loader-img">
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <center>
                                <img src="<?php echo empty($filme['poster_path']) ? $oApi->getNoPoster() : $oApi->getApiImg($filme['poster_path'], 500) ?>" style="margin-top: 15px; width: 225px; height: 350px;" class="img-rounded">
                            </center>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <h1><?php echo $filme['title']; ?> (<?php echo date('Y', strtotime($filme['release_date'])); ?>)</h1>
                            <div style="font-size: 20px;" >
                                <i class="fas fa-film"></i>
                                <?php foreach($filme['genres'] as $index=>$genre) { ?>
                                    <?php if($index == 0) { ?>
                                        <a class="media" style="display: inline;" href="../categoria/filtrar.php?id=<?= $genre['id']; ?>&nome=<?= $genre['name']; ?>" >
                                            <?php echo $genre['name']; ?></a>
                                    <?php } else { ?>
                                        | <a class="media" style="display: inline;" href="../categoria/filtrar.php?id=<?= $genre['id']; ?>&nome=<?= $genre['name']; ?>" >
                                            <?= $genre['name']; ?></a>
                                    <?php } ?>
                                <?php } ?>
                                <br>
                                <i class="far fa-clock"></i> <?= is_null($filme['runtime']) || empty($filme['runtime']) ? $unavailable : $oApi->convertMins($filme['runtime'], '%02dh %02dmin'); ?>
                                <br>
                                <i class="fas fa-star"></i> <?= $filme['vote_average']; ?>
                            </div>
                            <h2>Sinopse</h2>
                            <?php if($filme['changed'] == 1 && !empty($filme['overview'])) { ?>
                                <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
                                <b style="color: #5bc0de"> Sinopse não disponível em PT-BR, exibindo no idioma disponível.</b>
                            <?php } else if($filme['changed'] == 1 && empty($filme['overview'])) {?>
                                <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
                                <b style="color: #5bc0de"> Não há dados sobre a sinopse deste filme.</b>
                            <?php } else if(empty($filme['overview'])) { ?>
                                <i class="fas fa-info-circle fa-1x" style="color: #5bc0de"></i>
                                <b style="color: #5bc0de"> Não há dados sobre a sinopse deste filme.</b>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-12" >
                                    <p><?php echo $filme['overview']; ?></p>
                                    <button onclick="add('favoritos',<?= $filme['id'] ?>, this)" 
                                        type="button" class="btn btn-outline-danger" 
                                        value="<?= $valueFavorito; ?>">
                                        <i class="<?= empty($valueFavorito) ? 'fas fa-heart' : 'fas fa-check'; ?>" role="status" aria-hidden="true"></i> Adic. aos favoritos</button>

                                    <button onclick="add('interesses',<?= $filme['id'] ?>, this)" 
                                        type="button" class="btn btn-outline-primary"
                                        value="<?= $valueInteresse; ?>">
                                        <i class="<?= empty($valueInteresse) ? 'fas fa-bookmark' : 'fas fa-check'; ?>" role="status" aria-hidden="true"></i> Adic. à lista de interesse</button>
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
                        <div class="col-sm-6" style="color: white">
                            <h2><i class="fas fa-info-circle"></i> Informações</h2>
                            <hr style="background-color: white" />
                            
                            <h5 style="display: inline;">Titulo original</h5>
                            <h6 style="color: rgb(92,184,92);"><?php echo $filme['original_title']; ?></h6>

                            <h5 style="display: inline;">Situação</h5>
                            <h6 style="color: rgb(92,184,92);"><?php echo $filme['status']; ?></h6>

                            <h5 style="display: inline;">Data de Lançamento</h5>
                            <h6 style="color: rgb(92,184,92);"><?php echo date('d-m-Y', strtotime($filme['release_date'])); ?></h6>

                            <h5 style="display: inline;">Orçamento</h5>
                            <h6 style="<?php echo $budget == $unavailable ? $colorOrange : $colorGreen; ?>"><?php echo $budget; ?></h6>

                            <h5 style="display: inline;">Receita</h5>
                            <h6 style="<?php echo $revenue == $unavailable ? $colorOrange : $colorGreen; ?>"><?php echo $revenue; ?></h6>
           
                        </div>

                        <div class="col-sm-6" style="color: white">
                            <h2><i class="fas fa-photo-video"></i> Mídia</h2>
                            <hr style="background-color: white" />

                            <h5 style="display: inline;">Posters <span id="total-posters" style="color: rgb(92,184,92);">-</span></h5>
                            
                            <div id="posters" class="fade-list">

                            </div>
                            <!-- loader -->
                            <div id="loader-posters">
                                <div class="spinner-grow text-light" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <!-- loader -->

                            <h5 style="display: inline;">Imagens de fundo <span id="total-backdrops" style="color: rgb(92,184,92);">-</span></h5>
                            
                            <div id="backdrops" class="fade-list">

                            </div>

                            <!-- loader -->
                            <div id="loader-backdrops">
                                <div class="spinner-grow text-light" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <!-- loader -->

                            <h5 style="display: inline;">Vídeos <span id="total-videos" style="color: rgb(92,184,92);">-</span></h5>

                            <div id="videos" class="fade-list">

                            </div>

                            <!-- loader -->
                            <div id="loader-videos">
                                <div class="spinner-grow text-light" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <!-- loader -->

                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-12 col-sm-12">
                            <h2 style="color: white;"><i class="fas fa-users"></i> Elenco</h2>
                            <hr style="background-color: white" />
                            <!-- previous arrow -->
                            <div id="previous-elenco" style="position: absolute; top: 50%; z-index: 10; left: 4%; display: none">
                                <a onclick="previousList('elenco')"><i class="fas fa-chevron-left fa-4x" style="color: white;"></i></a>
                            </div>
                            <!-- previous arrow -->
                            <div class="row">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-3 col-xl-1">
                                </div>

                                <div class="col-8 col-sm-8 col-md-8 col-lg-6 col-xl-10">
                                    <div id="elenco" class="fade-list elenco flex-images">

                                    </div>
                                </div>

                                <div class="col-2 col-sm-2 col-md-2 col-lg-3 col-xl-1">
                                </div>
                            </div>
                            <!-- next arrow -->
                            <div id="next-elenco" style="position: absolute; top: 50%; z-index: 10; right: 4%; display: none">
                                <a onclick="nextList('elenco')"><i class="fas fa-chevron-right fa-4x" style="color: white;"></i></a>
                            </div>
                            <!-- next arrow -->
                            <input type="hidden" id="elenco-page" value="1"/>
                        </div>
                    </div>
                    <!-- loader -->
                    <div id="loader-elenco" class="d-flex justify-content-center">
                        <div class="spinner-grow text-light" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <!-- loader -->
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <h2 style="color: white"><i class="fas fa-users"></i> Equipe técnica</h2>
                            <hr style="background-color: white" />
                            <!-- previous arrow -->
                            <div id="previous-equipe-tecnica" style="position: absolute; top: 50%; z-index: 10; left: 4%; display: none">
                                <a onclick="previousList('equipe-tecnica')"><i class="fas fa-chevron-left fa-4x" style="color: white;"></i></a>
                            </div>
                            <!-- previous arrow -->
                            <div class="row">
                                <div class="col-2 col-sm-2 col-md-2 col-lg-3 col-xl-1">
                                </div>

                                <div class="col-8 col-sm-8 col-md-8 col-lg-6 col-xl-10">
                                    <div id="equipe-tecnica" class="fade-list equipe-tecnica flex-images">

                                    </div>
                                </div>

                                <div class="col-2 col-sm-2 col-md-2 col-lg-3 col-xl-1">
                                </div>
                            </div>

                            <!-- next arrow -->
                            <div id="next-equipe-tecnica" style="position: absolute; top: 50%; z-index: 10; right: 4%; display: none">
                                <a onclick="nextList('equipe-tecnica')"><i class="fas fa-chevron-right fa-4x" style="color: white;"></i></a>
                            </div>
                            <!-- next arrow -->
                            <input type="hidden" id="equipe-tecnica-page" value="1"/>
                        </div>
                    </div>
                    <!-- loader -->
                    <div id="loader-equipe-tecnica" class="d-flex justify-content-center">
                        <div class="spinner-grow text-light" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <h2 style="color: white"><i class="fas fa-thumbs-up"></i> Similares</h2>
                            <hr style="background-color: white" />
                            
                            <div class="row">
                                <div class="col-md-1 col-lg-1">
                                </div>

                                <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                                    <div id="similares">
                                     
                                    </div>

                                </div>

                                <div class="col-md-1 col-lg-1">
                                </div>
                            </div>
                            
                            <input type="hidden" id="similares-page" value="1"/>
                        </div>
                    </div>
                    <!-- loader -->
                    <div id="loader-similares" class="d-flex justify-content-center">
                        <div class="spinner-grow text-light" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <!-- loader -->
                    <br>
                    
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <h2 style="color: white"><i class="far fa-thumbs-up"></i> Recomendações</h2>
                            <hr style="background-color: white" />
                            
                            <div class="row">
                                <div class="col-md-1 col-lg-1">
                                </div>

                                <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                                    <div id="recomendacoes">
                                     
                                    </div>

                                </div>

                                <div class="col-md-1 col-lg-1">
                                </div>
                            </div>
                            
                            <input type="hidden" id="recomendacoes-page" value="1"/>
                        </div>
                    </div>
                    <!-- loader -->
                    <div id="loader-recomendacoes" class="d-flex justify-content-center">
                        <div class="spinner-grow text-light" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <!-- loader -->
 
                </div>
            </div>
        </div>
    </div>
</div>
    
<script type="text/javascript">

var itemsPerPage = 6;
$(document).ready(function() {
    $('.painel-bg-img').css("background-image" , "url('<?php echo empty($filme['backdrop_path']) ? $oApi->getNoBackdrop() : $oApi->getApiImg($filme['backdrop_path'], 1400); ?>')");
    loadCredits(<?php echo $id; ?>, 'equipe-tecnica');
    loadCredits(<?php echo $id; ?>, 'elenco');
    loadMedia(<?php echo $id; ?>, 'posters');
    loadMedia(<?php echo $id; ?>, 'backdrops');
    loadMedia(<?php echo $id; ?>, 'videos');
    loadRecomendacoes(<?php echo $id; ?>);
    loadSimilar(<?php echo $id; ?>);
});


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
function loadRecomendacoes(id)
{
    var element = $('#recomendacoes');
    var loader = document.getElementById("loader-recomendacoes");

    element.css('pointer-events', 'none');
    element.css('opacity', 0);
    loader.style.display = 'block'; 

    element.load('processamento.php?acao=carregar-recomendacoes&id=' + id,
        function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            element.css('opacity', 1);
            element.css('pointer-events', 'auto');
            loader.setAttribute('style', 'display:none !important');
            
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}
function loadSimilar(id)
{
    var element = $('#similares');
    var loader = document.getElementById("loader-similares");

    element.css('pointer-events', 'none');
    element.css('opacity', 0);
    loader.style.display = 'block'; 

    element.load('processamento.php?acao=carregar-similares&id=' + id,
        function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            element.css('opacity', 1);
            element.css('pointer-events', 'auto');
            loader.setAttribute('style', 'display:none !important');
            
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}
function loadCredits(id, tipo)
{
    var loader = document.getElementById("loader-"+tipo);
    var element = $('#'+tipo);
    var previous = $('#previous-'+tipo);
    var next = $('#next-'+tipo);

    element.css('pointer-events', 'none');
    element.css('opacity', 0);
    loader.style.display = 'block'; 

    element.load('processamento.php?acao=carregar-' + tipo + '&id=' + id,
        function (responseText, textStatus, XMLHttpRequest) {
        if (textStatus == "success") 
        {
            new flexImages({selector: '.'+tipo, rowHeight: detectmob() ? 350 : 250, truncate: 0 });

            element.css('opacity', 1);
            element.css('pointer-events', 'auto');
            previous.show();
            next.show();
            loader.setAttribute('style', 'display:none !important');

            showPage(document.getElementById(tipo+"-page").value,tipo);

            var loaderImage = $('.loader-image');
            loaderImage.each(function(i, elem)
            {
                $('#img-'+tipo+'-'+i).load(function(){
                    $('#loader-'+tipo+'-'+i).css('background-image', 'none');
                });
            });
        }
        if (textStatus == "error") {
             // oh noes!
        }
    });
}
function previousList(tipo)
{
    if(document.getElementById(tipo+"-page").value == 1)
        return;
    else
        showPage(--document.getElementById(tipo+"-page").value, tipo);
}
function nextList(tipo)
{
    var max = Math.ceil(document.getElementById("max-"+tipo).value/itemsPerPage);
    if(document.getElementById(tipo+"-page").value == max)
        return;
    else
        showPage(++document.getElementById(tipo+"-page").value, tipo);
}
function updateArrow(tipo)
{
    var previous = $('#previous-'+tipo);
    var next = $('#next-'+tipo);
    var page = document.getElementById(tipo+"-page").value
    var max = Math.ceil(document.getElementById("max-"+tipo).value/itemsPerPage);

    if(page == 1 && !previous.is(":hidden"))
       previous.hide();
    else if(previous.is(":hidden"))
        previous.show();
 
    
    if((page == max || max == 0) && !next.is(":hidden"))
        next.hide();
    else if(next.is(":hidden"))
        next.show();
}
function showPage(page, tipo)
{
    updateArrow(tipo);
    $("#"+tipo+" .itens").each(function(i, elem)
    {
        if(i >= (page-1)*itemsPerPage && i < page*itemsPerPage)
            $(this).show();
        else
            $(this).hide();
    });
}

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
    $(element.children[0]).attr('class','spinner-border spinner-border-sm');
    $(element).attr({'disabled': 'disabled'});
    $.ajax({
            url: '../usuario/processamento.php?acao=adicionar-' + tipo + '&idFilme=' + id + '&idUsuario=' + <?= $_SESSION['usuario']['idUsuario'] ?>,
            success: function(retorno)
            {
                if(retorno)
                {
                      Swal.fire({
                        title: 'Adicionado a lista de ' + tipo + ' com sucesso!',
                        type: 'success',
                        showConfirmButton: true,
                         onClose: () => {
                              $(element.children[0]).attr('class', 'fas fa-check');
                              $(element).attr('value', 'checked');
                              $(element).removeAttr('disabled');
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
</script>
<?php
include_once '../rodape.php';
?>