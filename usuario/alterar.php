<?php
include_once '../cabecalho.php';
include_once '../banco/Usuario.php';
include_once '../banco/Endereco.php';
include_once '../banco/Perfil.php';

$oUsuario = new Usuario();
$usuarios = $oUsuario->recuperarTodos();

$oPerfil = new Perfil();
$perfis = $oPerfil->recuperarTodos();

$oEndereco = new Endereco();

$categorias = $_SESSION["usuario"]["categorias"];


if(!empty($_GET['idUsuario'])){
    $oUsuario->carregarPorId($_GET['idUsuario']);
    $oEndereco->carregarPorId($oUsuario->getIdEndereco());
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
      <div class="card-header painel"><span class="fas fa-user-edit" aria-hidden="true"></span> Editar Usuário</div>
          <div class="card-body">
              
            <form action="processamento.php?acao=salvar" enctype="multipart/form-data" method="post">

              <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $oUsuario->getIdUsuario(); ?>" />
              <input type="hidden" name="idEndereco" id="idEndereco" value="<?php echo $oUsuario->getIdEndereco(); ?>" />

              <div class="form-group">

                <h4 style="color:red;"><span class="fas fa-user"></span> Dados Pessoais</h4>
                <hr style="background-color: black;">

                 <div class="row">
                  <div id="colPhoto" class="col-5 col-md-4 col-lg-4 col-xl-3">
                    <div class="flex-images">
                      <div class="item rounded-circle" data-w="160" data-h="160">
                        <center>
                          <img src="<?php echo $oUsuario->getFoto(); ?>" class="d-block w-100">
                        </center>
                      </div>
                    </div>
                  </div>
                  
                  <div id="colUpload" class="col-7 col-md-8 col-lg-8 col-xl-9">
                    <div id="layoutButtonUpload" style="position: absolute; bottom: 0;">
                      <button type="button" class="btn btn-success btn-lg" id="fotoUpload" onclick="document.getElementById('foto').click();"/><i id="icon-upload" class="fas fa-camera"></i> Carregar Foto</button>
                      <input type="file" id="foto" name="foto" accept="image/png, image/jpeg" hidden>
                      <br>
                      <br>
                      <span>Tamanho 1MB, Dimensões mínimas: 270x210 e tipo .jpg, .jpeg ou .png</span>
                    </div>
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-12 col-sm-4">
                    <label for="nome"><b>Nome: </b></label><input type="text" class="form-control" name="nome" id="nome" maxlength="70" value="<?php echo $oUsuario->getNome(); ?>" required/><br />
                  </div>
                  <div class="col-12 col-sm-4">
                    <label for="sobrenome"><b>Sobrenome: </b></label><input type="text" class="form-control" name="sobrenome" id="sobrenome" maxlength="70" value="<?php echo $oUsuario->getSobrenome(); ?>" required/><br />
                  </div>
                  <div class="col-12 col-sm-4">
                    <label for="genero"><b>Sexo: </b></label>

                    <select class="form-control selectpicker show-tick" title="Selecione" name="sexo" required>
                      <option <?php echo $oUsuario->getGenero() == 'M' ? 'selected' : '' ?> value="M">Masculino</option>
                      <option <?php echo $oUsuario->getGenero() == 'F' ? 'selected' : '' ?> value="F">Feminino</option>
                      <option <?php echo $oUsuario->getGenero() == 'O' ? 'selected' : '' ?> value="O">Outros</option>
                    </select>
                    <br>
                    <br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6" id="datepicker">
                    <label for="data_nasc"><b>Data de Nascimento: </b></label><input type="text" class="form-control" name="data_nasc" id="data_nasc" maxlength="10" value="<?php echo date('d/m/Y', strtotime($oUsuario->getDataNascimento())); ?>" autocomplete="off" required/><br />
                  </div>
                  <div class="col-12 col-sm-6">
                      <label for="preferencias"><b>Perfil: </b></label>
                      <select class="form-control selectpicker show-tick" title="Selecione" id="idPerfil" name="idPerfil" required>

                      <?php foreach($perfis as $perfil){ ?>
                          <?php $selecionar = $perfil['idPerfil'] == $oUsuario->getIdPerfil() ? 'selected' : ''; ?>
                          <option value='<?php echo $perfil['idPerfil']; ?>' <?php echo $selecionar; ?> ><?php echo $perfil['nome']; ?></option>
                      <?php } ?>
                      </select>
                    <br>
                    <br>
                  </div>
                </div>
                <!-- <br> -->
                <div class="row">
                  <div class="col-12 col-sm-6">

                    <label for="celular"><b>Celular: </b></label><input type="text" class="form-control" name="celular" id="celular" value="<?php echo $oUsuario->getCelular(); ?>" required/><br />
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="telefone"><b>Telefone: </b></label><input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $oUsuario->getTelefone(); ?>" required/><br />
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6">

                    <label for="email"><b>Email: </b></label><input type="email" class="form-control" name="email" id="email" maxlength="70" value="<?php echo $oUsuario->getEmail(); ?>" required/><br />

                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="senha"><b>Senha: </b></label><input type="password" class="form-control" name="senha" maxlength="50" id="senha" value="<?php echo $oUsuario->getSenha(); ?>" required/><br />
                  </div>
                </div>

                <div class="row">
                  <div class="<?= $oUsuario->getAge() >= 18 ? 'col-12 col-sm-6' : 'col-12 col-sm-12'; ?>">

                    <label for="preferencias"><b>Gêneros Favoritos: </b></label>
                    <select class="selectpicker form-control" id="categoria" name="categoria[]" multiple title="Selecione" data-live-search="true" data-header="Selecione ao menos 3 opções!" required>
                    
                    <?php foreach($categorias as $categoria){ ?>
                        <?php $selecionar = ''; ?>
                        <?php foreach($oUsuario->getPreferencias() as $preferencia) { ?>

                            <?php 
                                if($preferencia['idCategoria'] == $categoria['id'])
                                {
                                    $selecionar = 'selected';
                                    break;
                                } 
                            ?>
                        <?php } ?>
                        <option value='<?php echo $categoria['id']; ?>' <?php echo $selecionar; ?> ><?php echo $categoria['name']; ?></option>
                    <?php } ?>
                    </select>
                    <br>
                    <br>
                  </div>
                  <div class="col-12 col-sm-6" style="<?= $oUsuario->getAge() >= 18 ? 'display: inline-block;' : 'display: none;'; ?>">
                      <label for="preferencias"><b>Conteúdo Adulto: </b></label>
                      <select class="form-control selectpicker show-tick" title="Selecione" name="cont_adulto">
                        <option <?php echo $oUsuario->getConteudoAdulto() == true ? 'selected' : '' ?> value="1">Exibir</option>
                        <option <?php echo $oUsuario->getConteudoAdulto() == false ? 'selected' : '' ?> value="0">Não exibir</option>
                      </select>
                  </div>
                </div>
                <br />

                <h4 style="color:red;"><span class="fas fa-map-marker-alt"></span> Endereço</h4>
                <hr style="background-color: black;">

                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label for="cep"><b>CEP: </b></label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $oEndereco->getCep(); ?>" required/>
                      <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" id="button-cep" onclick="checkCep()"><span id="loader-cep" class="spinner-border text-danger spinner-border-sm" role="status" hidden></span> Buscar</button>
                      </div>
                    </div>
                    <br>

                    <label for="localidade"><b>Cidade: </b></label><input type="text" class="form-control" name="localidade" id="localidade" maxlength="70" value="<?php echo $oEndereco->getLocalidade(); ?>" required/><br />
                    
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="uf"><b>Estado: </b></label><input type="text" class="form-control" name="uf" id="uf" maxlength="2" value="<?php echo $oEndereco->getUf(); ?>" required/><br />

                    <label for="bairro"><b>Bairro: </b></label><input type="text" class="form-control" name="bairro" id="bairro" maxlength="100" value="<?php echo $oEndereco->getBairro(); ?>" required/><br />
                  </div>
                </div>

                <label for="complemento"><b>Complemento: </b></label><input type="text" class="form-control" name="complemento" id="complemento" maxlength="100" value="<?php echo $oEndereco->getComplemento(); ?>"/><br />

                <div style="text-align: center;"><button type="submit" class="btn btn-success btn-lg" id="continuar"><i class="fas fa-check"></i> Continuar</button>
                <a href="gerenciar.php" class="btn btn-danger btn-lg"><i class="fas fa-times"></i> Cancelar</a></div>

              </div>
            </form>
        </div>
    </div>
</div><!-- Fechando a Classe Container -->

<?php
include_once '../rodape.php';
?> 
<script>

var uploadField = document.getElementById("foto");

uploadField.onchange = function() 
{
    var file  = this.files[0];
    var img = new Image();

    var iconUpload = $("#icon-upload");
    var buttonUpload = $('#fotoUpload');

    img.onload = function() {
        var sizes = {
            width:this.width,
            height: this.height
        };
        URL.revokeObjectURL(this.src);

        width = sizes.width;
        height = sizes.height;

        var height = this.height;
        var width = this.width;

        if (height < 270 || width < 210) {
          Swal.fire({
            title: 'A imagem deve ter dimensões de no mínimo 270x210!',
            type: 'info',
            showConfirmButton: true,
          });
          uploadField.value = '';
          buttonUpload.attr('class', 'btn btn-danger btn-lg');
          iconUpload.attr('class', 'fas fa-times');
          return false;
        }
        else if(file.size > 1000000)
        {
            Swal.fire({
              title: 'O tamanho máximo da foto é de 1MB!',
              type: 'info',
              showConfirmButton: true,
            });
            uploadField.value = '';
            buttonUpload.attr('class', 'btn btn-danger btn-lg');
            iconUpload.attr('class', 'fas fa-times');
            return false;
        }
        buttonUpload.attr('class', 'btn btn-success btn-lg');
        iconUpload.attr('class', 'fas fa-check');
        return true;
    }

    var objectURL = URL.createObjectURL(file);

    img.src = objectURL;
};

document.getElementsByTagName("BODY")[0].onresize = function() {checkSelect()};

function checkSelect() {
    $('select').each(function() {
        if ($(this).attr('disabled')) 
            return true;
        else 
            $('.selectpicker').selectpicker('refresh');
    });  
}

$('#celular').mask("(99)99999-9999");
$('#telefone').mask("(99)9999-9999");
$('#data_nasc').mask("99/99/9999");
$('#cep').mask("99999-999");


$('#categoria').change(function(event) 
{
    if ($('#categoria :selected').size() < 3)
        document.getElementById("categoria").setCustomValidity('Selecione ao menos 3 opções!');
    else 
        document.getElementById("categoria").setCustomValidity('');
});

$('#email').change(function()
{
    var email = $('#email').val();
    var emailUser = '<?php echo addslashes($oUsuario->getEmail()); ?>';
    var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

    if(email == emailUser)
    {
        document.getElementById("email").setCustomValidity('');
        return;
    }

    if(format.test(email.charAt(0)))
    {
        document.getElementById("email").setCustomValidity('O email não deve iniciar com caracteres especiais!');
        return true;
    }
    else
        document.getElementById("email").setCustomValidity('');

    $.ajax({
          url: 'processamento.php?acao=verificarEmail&email=' + email,
          success: function(retorno)
          {
              if(retorno != 'Não existe')
              {
                    Swal.fire({
                      title: retorno,
                      type: 'info',
                      showConfirmButton: false,
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                      timer: 2000,
                      html: $('<div>')
                        .addClass('bounceInDown'),
                        animation: false,
                        customClass: 'animated bounceInDown'
                    }).then((result) => {
                      if (result.dismiss === Swal.DismissReason.timer) {
                          document.getElementById("email").setCustomValidity('Este email já está em uso!');
                      }
                    });
              }
              else
              {
                  document.getElementById("email").setCustomValidity('');
              }
          }
    });

});

function checkCep()
{
    showLoader();

    block();
    clear();
    var cep = $('#cep').val();
    var size = $('#cep').val().length;
    if(size == 9)
    {
          $.ajax({
            url: 'https://viacep.com.br/ws/' + cep + '/json/',
            error: function(jqXHR, textStatus)
            {
                if(textStatus === 'timeout')
                {     
                    hideLoader();
                    unblock();
                }
            },
            timeout: 5000,
            success: function(retorno)
            {
                if(retorno.erro != true)
                {
                    unblock();

                    document.getElementById('bairro').value= retorno.bairro; 
                    document.getElementById('complemento').value= retorno.complemento;
                    document.getElementById('uf').value= retorno.uf; 
                    document.getElementById('localidade').value= retorno.localidade;

                    document.getElementById('cep').setCustomValidity('');
                }
                else
                {
                    unblock();
                    Swal.fire('CEP Inválido!');
                    document.getElementById('cep').setCustomValidity('CEP Inválido!');
                }
                hideLoader();
            }
            
      });
    }
    else
    {
        unblock();
        Swal.fire('CEP Inválido!');
        document.getElementById('cep').setCustomValidity('CEP Inválido!');
        hideLoader();
    }
}
function showLoader()
{
    document.getElementById("loader-cep").setAttribute('style', 'display:inline-block !important');
}
function hideLoader()
{
    document.getElementById("loader-cep").setAttribute('style', 'display:none !important');
}
function block()
{

    document.getElementById("continuar").disabled = true;
    document.getElementById("button-cep").disabled = true;

    document.getElementById('bairro').disabled= true; 
    document.getElementById('complemento').disabled= true;
    document.getElementById('uf').disabled= true; 
    document.getElementById('localidade').disabled= true; 
}
function unblock()
{
    document.getElementById("continuar").disabled = false;
    document.getElementById("button-cep").disabled = false;

    document.getElementById('bairro').disabled= false; 
    document.getElementById('complemento').disabled= false;
    document.getElementById('uf').disabled= false; 
    document.getElementById('localidade').disabled= false; 
}
function clear(){
    document.getElementById('bairro').value= ''; 
    document.getElementById('complemento').value= '';
    document.getElementById('uf').value= ''; 
    document.getElementById('localidade').value= ''; 
}

$('#datepicker input').datepicker({
    format: "dd/mm/yyyy",
    language: "pt-BR",
    todayHighlight: true,
    todayButton: true,
    todayBtn: "linked",
    clearBtn: true,
    autoclose: true
});

if(detectmob())
{
    $('#colPhoto').attr('class', 'col-12 col-sm-5 col-md-4 col-lg-4 col-xl-3');
    $('#colUpload').attr('class', 'col-12 col-sm-7 col-md-8 col-lg-8 col-xl-9');
    $('#layoutButtonUpload').attr('style', 'margin-top: 20px;');

}

new flexImages({selector: '.flex-images', rowHeight: 250, truncate: false });

</script>

