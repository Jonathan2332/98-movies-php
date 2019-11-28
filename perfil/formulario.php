<?php
include_once '../cabecalho.php';

include_once '../banco/Perfil.php';

$oPerfil = new Perfil();


if (!empty($_GET['idPerfil']))
{
    $url = 'https://98movies.000webhostapp.com/restful/api/rest/view/perfil/update.php';
    $oPerfil->carregarPorId($_GET['idPerfil']);
}
else
{
    $url = 'https://98movies.000webhostapp.com/restful/api/rest/view/perfil/insert.php';
}

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

    <div class="card" style="border-color: red">
      <div class="card-header painel"><span class="far fa-id-badge"></span> Gerenciar Perfis</div>
          <div class="card-body">
             
            
          <form id="form" action="javascript:postData()">
            <div class="form-group">
                
                <label style="font-size: 20px;">Por favor, preencha os dados abaixo.</label><br />

  
                    <input type="hidden" class="form-control" id="idPerfil" name="idPerfil" required
                           value="<?= $oPerfil->getIdPerfil(); ?>">

                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                           value="<?= $oPerfil->getNome(); ?>">              
                    
                    <br>
                    
                    <div style="text-align: center;">
                      <button type="submit" class="btn btn-success btn-lg" id="continuar"><i class="fas fa-check"></i> Salvar</button>
                      <a id="cancel" href="index.php" onclick="abortFetching();" class="btn btn-danger btn-lg"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                      <span id="loader" class="spinner-border text-success spinner-border" role="status" hidden></span>
                    </div>
                </div>
            </form> 
        </div>        
    </div>
</div>
<script type="text/javascript">

const controller = new AbortController();
const signal = controller.signal;

function postData() 
{
    $('#continuar').attr('disabled', 'disabled');
    document.getElementById("loader").setAttribute('style', 'display:inline-block !important');

    const form = document.getElementById('form');
    const data = new FormData();
    data.append('nome', form.nome.value);
    data.append('idPerfil', form.idPerfil.value);

    fetch('<?= $url ?>', {method: 'POST', body: data, signal: signal}).then(response => {
        if (!response.ok){
            document.getElementById("loader-cep").setAttribute('style', 'display:none !important');
            Swal.fire({
              title: 'Ocorreu um erro.',
              type: 'error',
              showConfirmButton: true,
                onClose: () => {
                  window.location.href="index.php";
                }
            });
        }
        else if(response.ok)
        {
            document.getElementById("loader").setAttribute('style', 'display:none !important');
            Swal.fire({
              title: 'Operação realizada com sucesso!',
              type: 'success',
              showConfirmButton: true,
                onClose: () => {
                  window.location.href="index.php";
                }
            });
        }
    }).catch(err => console.log(err));
}
function abortFetching() {
    controller.abort();
}
</script>
<?php
include_once '../rodape.php'; ?>
