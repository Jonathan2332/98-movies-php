<?php

include_once '../cabecalho.php';

$categorias = $_SESSION['usuario']['categorias'];

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
	<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
  <?php include_once '../res/navbar/dark.php' ?>
  <!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->
	<div class="form-group">
		<div class="card painel-bg">
			<div class="card-body">

				<div class="row">
					<div class="col-12">
						<h2 style="color:white;">Pessoas populares</h2>
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
			</div> <!-- FECHANDO PAINEL BODY -->
		</div><!-- FECHANDO PRIMARY PANEL -->
</div><!-- FECHANDO FORM GROUP -->
<script>


document.getElementsByTagName("BODY")[0].onresize = function() 
{
	new flexImages({selector: '.overlay', rowHeight: detectmob() ? 450 : 400, truncate: false });
};

carregarPessoas(1, true);


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

function updateList(condition)
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
function carregarPessoas(pagina, initializing)
{
	updateList(false);

	var element = $('#lista');
	element.load('processamento.php?acao=carregar-pessoas-populares&page=' + pagina,
		function (responseText, textStatus, XMLHttpRequest) 
    {
	    if (textStatus == "success") 
	    {
         	updateList(true);

         	if(initializing)
         		initPagination();
	    }
	    if (textStatus == "error") {
	         // oh noes!
	    }
  	});
}

function initPagination()
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
        	carregarPessoas(pageNumber, false);
        }
    }); 
}

</script>

<?php
	include_once '../rodape.php';
?>