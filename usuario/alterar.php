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
      font-size: 40px;
      background-color: red!important;
      border-color: white!important;
  }
</style>
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


<div class="container" style="margin-top: 40px;">

  <div class="card" style="border-color: red">
      <div class="card-header painel"><span class="fas fa-user-edit" aria-hidden="true"></span> Editar Usuário</div>
          <div class="card-body">
              
            <form action="processamento.php?acao=salvar" enctype="multipart/form-data" method="post">

              <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $oUsuario->getIdUsuario(); ?>" />
              <input type="hidden" name="idEndereco" id="idEndereco" value="<?php echo $oUsuario->getIdEndereco(); ?>" />

              <div class="form-group">

                <h3 style="color:red;"><span class="fas fa-user"></span> Dados Pessoais</h3>
                <hr style="background-color: black;">

                 <div class="row">
                  <div class="col-5 col-md-4 col-lg-4 col-xl-3">
                    <div class="flex-images">
                      <div class="item rounded-circle" data-w="160" data-h="160">
                        <center>
                          <img src="<?php echo $oUsuario->getFoto(); ?>" class="d-block w-100">
                        </center>
                      </div>
                    </div>
                  </div>
                  <div class="col-7 col-md-8 col-lg-8 col-xl-9">
                    <div style="position: absolute; bottom: 0;">
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
                  <div class="col">
                    <label for="nome"><b>Nome: </b></label><input type="text" class="form-control" name="nome" id="nome" maxlength="70" value="<?php echo $oUsuario->getNome(); ?>" required/><br />
                  </div>
                  <div class="col">
                    <label for="sobrenome"><b>Sobrenome: </b></label><input type="text" class="form-control" name="sobrenome" id="sobrenome" maxlength="70" value="<?php echo $oUsuario->getSobrenome(); ?>" required/><br />
                  </div>
                  <div class="col">
                    <label for="genero"><b>Sexo: </b></label>

                    <select class="form-control selectpicker show-tick" title="Selecione" name="sexo" required>
                      <option <?php echo $oUsuario->getGenero() == 'M' ? 'selected' : '' ?> value="M">Masculino</option>
                      <option <?php echo $oUsuario->getGenero() == 'F' ? 'selected' : '' ?> value="F">Feminino</option>
                      <option <?php echo $oUsuario->getGenero() == 'O' ? 'selected' : '' ?> value="O">Outros</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col" id="datepicker">
                    <label for="data_nasc"><b>Data de Nascimento: </b></label><input type="text" class="form-control" name="data_nasc" id="data_nasc" maxlength="10" value="<?php echo date('d/m/Y', strtotime($oUsuario->getDataNascimento())); ?>" autocomplete="off" required/><br />
                  </div>
                  <div class="col">
                      <label for="preferencias"><b>Perfil: </b></label>
                    <select class="form-control selectpicker show-tick" title="Selecione" id="idPerfil" name="idPerfil" required>

                    <?php foreach($perfis as $perfil){ ?>
                        <?php $selecionar = $perfil['idPerfil'] == $oUsuario->getIdPerfil() ? 'selected' : ''; ?>
                        <option value='<?php echo $perfil['idPerfil']; ?>' <?php echo $selecionar; ?> ><?php echo $perfil['nome']; ?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col">

                    <label for="celular"><b>Celular: </b></label><input type="text" class="form-control" name="celular" id="celular" value="<?php echo $oUsuario->getCelular(); ?>" required/><br />
                  </div>
                  <div class="col">
                    <label for="telefone"><b>Telefone: </b></label><input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $oUsuario->getTelefone(); ?>" required/><br />
                  </div>
                </div>
                <div class="row">
                  <div class="col">

                    <label for="email"><b>Email: </b></label><input type="email" class="form-control" name="email" id="email" maxlength="70" value="<?php echo $oUsuario->getEmail(); ?>" required/><br />

                  </div>
                  <div class="col">
                    <label for="senha"><b>Senha: </b></label><input type="password" class="form-control" name="senha" maxlength="50" id="senha" value="<?php echo $oUsuario->getSenha(); ?>" required/><br />
                  </div>
                </div>

                <div class="row">
                  <div class="<?= $oUsuario->getAge() >= 18 ? 'col-6' : 'col'; ?>">

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
                  </div>
                  <div class="col-6" style="<?= $oUsuario->getAge() >= 18 ? 'display: inline-block;' : 'display: none;'; ?>">
                      <label for="preferencias"><b>Conteúdo Adulto: </b></label>
                      <select class="form-control selectpicker show-tick" title="Selecione" name="cont_adulto">
                        <option <?php echo $oUsuario->getConteudoAdulto() == true ? 'selected' : '' ?> value="true">Exibir</option>
                        <option <?php echo $oUsuario->getConteudoAdulto() == false ? 'selected' : '' ?> value="false">Não exibir</option>
                      </select>
                  </div>
                </div>
                <br />
                <br />

                <h3 style="color:red;"><span class="fas fa-map-marker-alt"></span> Endereço</h3>
                <hr style="background-color: black;">

                <div class="row">
                  <div class="col">
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
                  <div class="col">
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

new flexImages({selector: '.flex-images', rowHeight: 250, truncate: false });

document.getElementsByTagName("BODY")[0].onresize = function() {checkSelect()};

function checkSelect() {
    $('select').each(function() {
        if ($(this).attr('disabled')) 
            return true;
        else 
            $('.selectpicker').selectpicker('refresh');
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

</script>

<?php
include_once '../rodape.php';
?> 
