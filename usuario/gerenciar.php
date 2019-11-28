<?php
include_once '../cabecalho.php';
include_once '../banco/Usuario.php';

$oUsuario = new Usuario();
$usuarios = $oUsuario->recuperarTodos();

$categorias = $_SESSION["usuario"]["categorias"];
?>


<style type="text/css">
  .painel
  {
      color:white!important;
      font-size: 30px;
      background-color: red!important;
      border-color: white!important;
  }
</style>
<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
<?php include_once '../res/navbar/light.php' ?>
<!-- ////////////////////////////////////CONTAINER/////////////////////////////////////// -->

<div class="container" style="margin-top: 40px;">
  <div class="card" style="border-color: red;">
    <div class="card-header painel"><span class="fas fa-users" aria-hidden="true"></span> Gerenciar Usuários</div>
      <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Opções</th>
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($usuarios as $usuario){ ?>
                <tr>
                  <th scope="row">
                      <a href="alterar.php?idUsuario=<?php echo $usuario['idUsuario']; ?>"><span class="fas fa-user-edit text-success" aria-hidden="true"></span></a>
                      <a onclick="check(<?php echo $usuario['idUsuario']; ?>)" href="javascript:;"><span class="fas fa-user-times" aria-hidden="true" style="color:red"></span></a>
                  </th>
                  <td><?php echo $usuario['idUsuario']; ?></td>
                  <td><?php echo $usuario['nome']; ?></td>
                  <td><?php echo $usuario['email']; ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>            
          </div>
      </div>
  </div>
</div><!-- Fechando a Classe Container -->
<script>

function check(id)
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
          window.location.href="processamento.php?acao=excluir&idUsuario="+id;
      }
    });
}

</script> 
<?php
    include_once '../rodape.php';
?>
