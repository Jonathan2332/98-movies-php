<?php

include_once '../cabecalho.php';

include_once '../banco/Usuario.php';
include_once '../banco/Endereco.php';

$oUsuario = new Usuario();

$oEndereco = new Endereco();

$categorias = $_SESSION["usuario"]["categorias"];


if(isset($_POST['salvar']))
{

    $resultado = $oUsuario->alterar($_POST);

    $status = $resultado ? 1 : 0;
    if($status)
    {
         echo '<script type="text/javascript">
            Swal.fire({
              position: "center",
              allowEscapeKey: false,
              allowOutsideClick: false,
              type: "success",
              title: "Alterações salvas com sucesso",
              showConfirmButton: false,
              timer: 1500
            });
            </script>';
    }
    else
    {
        echo '<script type="text/javascript">
            Swal.fire({
              position: "center",
              allowEscapeKey: false,
              allowOutsideClick: false,
              type: "error",
              title: "Ocorreu um erro",
              showConfirmButton: false,
              timer: 1500
            });
            </script>';
    }

    $oUsuario->carregarPorId($_SESSION["usuario"]["idUsuario"]);
    $oEndereco->carregarPorId($_SESSION["usuario"]["idEndereco"]);
}
else
{
    $oUsuario->carregarPorId($_SESSION["usuario"]["idUsuario"]);
    $oEndereco->carregarPorId($_SESSION["usuario"]["idEndereco"]);
}
 
?>

<div class="navbar-bg-custom-light"></div>
<!-- ////////////////////////////////////NAV BAR/////////////////////////////////////// -->
<nav id="navbar" class="navbar navbar-expand-lg navbar-light rounded custom-navbar">
  <img src="../res/imgs/98-movies.png" width="56" height="56">
  <button id="button-toggle" onclick="checkBackground('light')" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto mx-2">
        
      <li class="nav-item active">
        <a class="nav-link" href="inicial.php"><span class="fas fa-home" aria-hidden="true"></span> Início</a>
      </li>
      <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="filmesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-film" aria-hidden="true"></span> Filmes
                </a>
                <div class="dropdown-menu" aria-labelledby="filmesDropdown">
                  <a class="dropdown-item" href="../filme/explorar.php">Explorar</a>
                  <a class="dropdown-item" href="inicial.php?type=populares">Populares</a>
                  <a class="dropdown-item" href="inicial.php?type=avaliados">Mais bem avaliados</a>
                  <a class="dropdown-item" href="inicial.php?type=lancamentos">Próximos lançamentos</a>
                  <a class="dropdown-item" href="inicial.php?type=cartaz">Em cartaz</a>
                </div>
            </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="fas fa-bars" aria-hidden="true"></span> Categorias
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
          <?php foreach($categorias as $index=>$categoria){ ?>
                <form class="form-inline my-2 my-lg-0 " action="../categoria/filtrar.php" method="get">
                  <button class="dropdown-item" type="submit" name="id" value="<?php echo $categoria['id']; ?>">
                  <?php echo $categoria['name']; ?></button>
                </form>
          <?php } ?>
        </div>
      </li>
      <li class="nav-item active">
          <a class="nav-link" href="../pessoa/inicial.php"><span class="fas fa-users" aria-hidden="true"></span> Pessoas</a>
      </li>
      <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-user-circle" aria-hidden="true"></span> <?php echo $_SESSION['usuario']['nome']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="perfilDropdown">
                    <a class="dropdown-item" href="perfil.php">Meu perfil</a>
                    <a class="dropdown-item" href="lista.php?type=favoritos">Meus favoritos</a>
                    <a class="dropdown-item" href="lista.php?type=interesses">Lista de interesses</a>
                    <?php if($_SESSION['usuario']['idPerfil'] == 2) { ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../usuario/gerenciar.php">Gerenciar Usuários</a>
                        <a class="dropdown-item" href="../pagina/index.php">Gerenciar Páginas</a>
                    <?php } ?>
                </div>
            </li>
      <li class="nav-item active">
        <a class="nav-link" href="processamento.php?acao=logoff"><span class="fas fa-sign-out-alt" aria-hidden="true"></span> Sair</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0 mx-2" action="../filme/buscar.php" method="get">
      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" name="busca" id="busca" maxlength="50" required>

      <div class="dropdown">
        <button id="button-search" class="btn btn-success my-2 my-sm-0 dropdown-toggle" 
          type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="fas fa-search" aria-hidden="true" ></span> Buscar
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <button class="dropdown-item" type="submit" name="type" value="movie">Filmes</button>
          <button class="dropdown-item" type="submit" name="type" value="person">Pessoas</button>
        </div>
      </div>

    </form>
  </div>
</nav>
<div class="container">
  <div class="card bg-dark">
    <div class="card-body">
   
        <form id="form-perfil" enctype="multipart/form-data" action="perfil.php" method="post">

            <div class="form-group text-white">
  
                <input type="hidden" type="number" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION['usuario']['idUsuario']; ?>" />
                <input type="hidden" type="number" name="idPerfil" id="idPerfil" value="<?php echo $_SESSION['usuario']['idPerfil']; ?>" />
                <input type="hidden" type="number" name="idEndereco" id="idEndereco" value="<?php echo $_SESSION['usuario']['idEndereco']; ?>" />

                <h2>Detalhes da sua conta</h2>
                <h4 style="color:rgb(92,184,92);"><span class="fas fa-user"></span> Dados Pessoais</h4>
                <hr style="background-color: white;">

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
                      <button type="button" class="btn btn-success btn-lg" id="fotoUpload" onclick="document.getElementById('foto').click();" disabled/><i id="icon-upload" class="fas fa-camera"></i> Carregar Foto</button>
                      <input type="file" id="foto" name="foto" accept="image/png, image/jpeg" hidden>
                      <br>
                      <br>
                      <span>Tamanho 1MB, Dimensões mínimas: 270x210 e tipo .jpg, .jpeg ou .png</span>
                    </div>
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-12 col-sm-6">

                      <label for="nome"><b>Nome: </b></label><input type="text" class="form-control" name="nome" id="nome" value="<?php echo $oUsuario->getNome(); ?>" readonly/><br />

                  </div>
                  <div class="col-12 col-sm-6">
                      <label for="sobrenome"><b>Sobrenome: </b></label><input type="text" class="form-control" name="sobrenome" id="sobrenome" value="<?php echo $oUsuario->getSobrenome(); ?>" readonly/><br />
                  </div>
                </div>



                <div class="row">
                    <div class="col-12 col-sm-6" id="datepicker">
                      <label for="data_nasc"><b>Data de Nascimento: </b></label><input type="text" class="form-control" name="data_nasc" id="data_nasc" maxlength="10" value="<?php echo date('d/m/Y', strtotime($oUsuario->getDataNascimento())); ?>" autocomplete="off" disabled/><br />
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="genero"><b>Sexo: </b></label>

                      <select class="form-control selectpicker show-tick" title="Selecione" name="sexo" disabled>
                        <option <?php echo $oUsuario->getGenero() == 'M' ? 'selected' : '' ?> value="M">Masculino</option>
                        <option <?php echo $oUsuario->getGenero() == 'F' ? 'selected' : '' ?> value="F">Feminino</option>
                        <option <?php echo $oUsuario->getGenero() == 'O' ? 'selected' : '' ?> value="O">Outros</option>
                      </select>
                      <br>
                      <br>
                  </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                      <label for="celular"><b>Celular: </b></label><input type="text" class="form-control" name="celular" id="celular" value="<?php echo $oUsuario->getCelular(); ?>" readonly/><br />
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="telefone"><b>Telefone: </b></label><input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $oUsuario->getTelefone(); ?>" readonly/><br />
                    </div>
                </div>
                <div class="row">
                  <div id="div-email" class="col-12 col-sm-6">

                    <label for="email"><b>Email: </b></label><input type="email" class="form-control" name="email" id="email" value="<?php echo $oUsuario->getEmail(); ?>" readonly/><br />

                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="senha"><b>Senha: </b></label><input type="password" class="form-control" name="senha" id="senha" value="<?php echo $oUsuario->getSenha(); ?>" readonly><br />
                  </div>
    
                  <div id="div-csenha" class="col-12 col-sm-6" style="display: none;">
                    <label for="csenha"><b>Repita a senha: </b></label><input class="form-control" type="password" name="csenha" id="csenha" value="<?php echo $oUsuario->getSenha(); ?>" readonly/><br />
                  </div>
 
                </div>

                <div class="row">
                  <div class="<?= $oUsuario->getAge() >= 18 ? 'col-12 col-sm-6' : 'col-12 col-sm-12'; ?>">

                    <label for="preferencias"><b>Gêneros Favoritos: </b></label>
                    <select class="selectpicker form-control" id="categoria" name="categoria[]" data-live-search="true" data-header="Selecione ao menos 3 opções!" multiple title="Selecione" disabled>
                    
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
                      <select class="form-control selectpicker show-tick" title="Selecione" name="cont_adulto" id="cont_adulto" disabled>
                        <option <?php echo $oUsuario->getConteudoAdulto() == true ? 'selected' : '' ?> value="true">Exibir</option>
                        <option <?php echo $oUsuario->getConteudoAdulto() == false ? 'selected' : '' ?> value="false">Não exibir</option>
                      </select>
                  </div>
                </div>

                <br />

                <h4 style="color:rgb(92,184,92);"><span class="fas fa-map-marker-alt"></span> Endereço</h4>
                <hr style="background-color: white;">

                <div class="row">
                  <div class="col-12 col-sm-6">

                    <label for="cep"><b>CEP: </b></label>

                    <div id="div-loader" class="input-group">

                      <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $oEndereco->getCep(); ?>" readonly/>
                      <div id="div-loader-append" class="input-group-append">
                        <button class="btn btn-success" type="button" id="button-cep" onclick="checkCep()" style="display: none;"><span id="loader-cep" class="spinner-border text-light spinner-border-sm" role="status" hidden></span> Buscar</button>
                      </div>
                    </div>
                    <br>
                    <label for="localidade"><b>Cidade: </b></label><input type="text" class="form-control" name="localidade" id="localidade" value="<?php echo $oEndereco->getLocalidade(); ?>" readonly><br />
                  </div>
                  <div class="col-12 col-sm-6">
                    <label for="uf"><b>Estado: </b></label><input type="text" class="form-control" name="uf" id="uf" value="<?php echo $oEndereco->getUf(); ?>" readonly><br />

                    <label for="bairro"><b>Bairro: </b></label><input type="text" class="form-control" name="bairro" id="bairro" value="<?php echo $oEndereco->getBairro(); ?>" readonly><br />
                  </div>

                </div>
                <label for="complemento"><b>Complemento: </b></label><input type="text" class="form-control" name="complemento" id="complemento" value="<?php echo $oEndereco->getComplemento(); ?>" readonly><br /><br>

                <div id="button-edit" style="text-align: center;">
                    <button type="button" class="btn btn-success btn-lg" id="editar"><i class="fas fa-user-edit"></i> Editar</button>
                </div>



                <div id="button-states" style="text-align: center; display: none">
                    <button type="submit" class="btn btn-success btn-lg" name="salvar" id="salvar"><i class="fas fa-check"></i> Salvar</button>

                    <button onclick="toggleEdit(false)" type="button" class="btn btn-danger btn-lg" id="cancelar"><i class="fas fa-times"></i> Cancelar</button>
                </div>

            </div>
        </form>
    </div>
  </div>

</div>

<?php
include_once '../rodape.php';
?>
<script type="text/javascript">

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

$('#editar').click(function() 
{
    toggleElements();
    toggleEdit(true);
});
function toggleElements()
{
    $('input').each(function() {
          if ($(this).attr('readonly') || $(this).attr('disabled')) 
          {
              if(this.name == 'data_nasc')
              {
                  $(this).removeAttr('disabled');
                  $(this).attr('required');
              }
              else
              {
                  if(this.name == 'complemento' || this.name == 'cont_adulto')
                    $(this).removeAttr('readonly');
                  else
                  {
                      $(this).removeAttr('readonly');
                      $(this).attr('required');
                  }
              }

          }  
          else 
          {
              if(this.name == 'data_nasc')
                  $(this).attr({'disabled': 'disabled'});
              else
                  $(this).attr({'readonly': 'readonly'});
          }
      });

      $('select').each(function() {
          if ($(this).attr('disabled')) 
          {
              $(this).removeAttr('disabled');
              $(this).attr('required');
          }  
          else 
          {
              $(this).attr({'disabled': 'disabled'});
          }
      });
      $('.selectpicker').selectpicker('refresh');

      var buttonUpload = $('#fotoUpload');
      if(buttonUpload.attr('disabled'))
          buttonUpload.removeAttr('disabled');
      else
          buttonUpload.attr({'disabled': 'disabled'});
      
}
function toggleEdit(condition)
{
    if(condition)//show
    {
        $("#button-edit").hide();
        $("#button-states").show();
        $("#button-cep").show();

        $("#div-email").attr('class', 'col-12');
        $("#div-csenha").show();
    }
    else
    {
        $("#form-perfil")[0].reset();

        var iconUpload = $("#icon-upload");
        var buttonUpload = $('#fotoUpload');
        
        buttonUpload.attr('class', 'btn btn-success btn-lg');
        iconUpload.attr('class', 'fas fa-camera');

        toggleElements();

        $("#button-edit").show();
        $("#button-states").hide();
        $("#button-cep").hide();

        $("#div-email").attr('class', 'col-12 col-sm-6');
        $("#div-csenha").hide(); 
    }
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

var senha = document.getElementById("senha") , csenha = document.getElementById("csenha");

function verificarSenha(){
  if(senha.value != csenha.value) 
    csenha.setCustomValidity("As senhas não coincidem.");
  else 
    csenha.setCustomValidity('');
}

senha.onchange = verificarSenha;
csenha.onkeyup = verificarSenha;


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

    document.getElementById("salvar").disabled = true;
    document.getElementById("button-cep").disabled = true;

    document.getElementById('bairro').disabled= true; 
    document.getElementById('complemento').disabled= true;
    document.getElementById('uf').disabled= true; 
    document.getElementById('localidade').disabled= true; 
}
function unblock()
{
    document.getElementById("salvar").disabled = false;
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