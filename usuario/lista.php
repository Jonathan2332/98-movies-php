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


<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
<?php include_once '../res/navbar/light.php' ?>
<!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->

<div class="container" style="margin-top: 40px;">
  <div class="card" style="border-color: <?= $type == 'favoritos' ? 'red' : '#007bff' ?>;">
    <div class="card-header" style="font-size: 30px; color:white!important; background-color: <?= $type == 'favoritos' ? 'red' : '#007bff' ?>!important; border-color: white!important;">
      <span class="fas fa-<?= $type == 'favoritos' ? 'heart' : 'bookmark' ?>" aria-hidden="true"></span> Lista de <?= $type; ?></div>
      <div class="card-body">
          <table id="itens" class="table table-hover">
            <thead class="thead-dark">
              <tr class="d-flex">
                <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">Ações</th>
                <th class="col-6 col-sm-6 col-md-6 col-lg-9">Filme</th>
                <th class="col-2 col-sm-2 col-md-2 col-lg-1 text-center">Ano</th>
                <th id="rate" class="col-2 col-sm-2 col-md-2 col-lg-1 text-center"><span class="fas fa-star"></span></th>
            </tr>
            </thead>
            <tbody id="table-<?= $type ?>">
            
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
                <div id="loader" class="spinner-border <?= $type == 'favoritos' ? 'text-danger' : 'text-primary' ?>" role="status" style="display: none!important"></div>
          </div>       
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
            if(detectmob())
            {
                $('#itens').attr('class', 'table table-sm table-hover');
                $('#itens th').each(function () 
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
                        $(this).attr('class', 'col-4');
                    }
                });

                $('#itens td').each(function () 
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
                        $(this).attr('class', 'col-4');
                    }
                });
            }
            
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
