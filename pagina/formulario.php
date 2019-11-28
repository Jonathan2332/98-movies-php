<?php
include_once '../cabecalho.php';

include_once '../banco/Pagina.php';
include_once '../banco/Permissao.php';
include_once '../banco/Perfil.php';

$oPerfil = new Perfil();
$perfis = $oPerfil->recuperarTodos();

$oPagina = new Pagina();

$oPermissao = new Permissao();

if (!empty($_GET['idPagina']))
{
    $oPagina->carregarPorId($_GET['idPagina']);
    $permissoes = $oPermissao->carregarPorPagina($_GET['idPagina']);
}

$categorias = $_SESSION["usuario"]["categorias"];

function checkPermissao($permissoes, $idPerfil)
{
    foreach ($permissoes as $permissao) {
        if($idPerfil == $permissao['idPerfil'])
          return true;
    }
}
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
      <div class="card-header painel"><span class="far fa-window-restore"></span> Gerenciar Páginas e Permissões</div>
          <div class="card-body">
             
            
          <form action="processamento.php?acao=salvar" method="post">
            <div class="form-group">
                
                <label style="font-size: 20px;">Por favor, preencha os dados abaixo.</label><br />

  
                    <input type="hidden" class="form-control" id="idPagina" name="idPagina" required
                           value="<?= $oPagina->getIdPagina(); ?>">

                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                           value="<?= $oPagina->getNome(); ?>">
                    
                    <label>Caminho</label>

                    <input type="text" class="form-control" id="caminho" name="caminho" required
                           value="<?= $oPagina->getCaminho(); ?>">
                    
                    <br>

                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="switchPublica" name="publica" <?= $oPagina->getPublica() ? 'checked' : ''; ?>>
                      <label class="custom-control-label" for="switchPublica">Pública</label>
                    </div>

                    <hr style="background-color: black;">

                    <fieldset>
                        <legend>Perfis com permissão a esta página</legend>

                        <?php foreach($perfis as $index=>$perfil){ ?>
                            <?php if (!empty($_GET['idPagina'])) $checked = checkPermissao($permissoes, $perfil['idPerfil']) ? 'checked' : ''; ?>
                            <div class="custom-control custom-checkbox">
                               <input type="checkbox" name="idPerfil[]" class="custom-control-input" value="<?= $perfil['idPerfil']; ?>" id="customCheck<?= $index; ?>" <?= !empty($_GET['idPagina']) ? $checked : '' ?>>
                               <label class="custom-control-label" for="customCheck<?= $index; ?>"><?= $perfil['nome']; ?></label>
                            </div>

                        <?php } ?>

                    </fieldset>
                    <br>
                    <div style="text-align: center;">
                      <button type="submit" class="btn btn-success btn-lg" id="continuar"><i class="fas fa-check"></i> Salvar</button>
                      <a href="index.php" class="btn btn-danger btn-lg"><i class="fas fa-times"></i> Cancelar</a>
                    </div>
                </div>
            </form> 
        </div>        
    </div>
</div>

<?php
include_once '../rodape.php'; ?>
