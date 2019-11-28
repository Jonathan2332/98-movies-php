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

<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
<?php include_once '../res/navbar/light.php' ?>
<!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->

  

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

</script>
<?php
include_once '../rodape.php';