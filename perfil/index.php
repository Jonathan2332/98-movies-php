<?php
include_once '../cabecalho.php';
include_once '../banco/Perfil.php';

$oPerfil = new Perfil();
$perfis = $oPerfil->listFromApi();

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
      <div class="card-header titulo"><span class="far fa-id-badge"></span> Perfis</div>
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
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($perfis as $perfil) { ?>
                        <tr>
                            <td class="text-center">
                                <a href="formulario.php?idPerfil=<?=$perfil['idPerfil'] ?>">
                                    <span class="fas fa-edit text-success"></span>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="javascript:;" onclick="check(this, <?=$perfil['idPerfil'] ?>)">
                                    <span class="fas fa-trash-alt text-danger"></span>
                                </a>
                            </td>
                            <td><?= $perfil['nome'] ?></td>
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
            url: 'https://98movies.000webhostapp.com/restful/api/rest/view/perfil/delete.php?idPerfil='+id,
            success: function(retorno)
            {
                if(!retorno.erro)
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