<?php
include_once '../cabecalho.php';
include_once '../api/API.php';

$oApi = new API();
$categorias = $oApi->getCategorias();

?>


<style type="text/css">
  .cadastro
  {
      color:white!important;
      font-size: 45px;
      background-color: rgb(92,184,92)!important;
      border-color: white!important;
  }

</style>
<center style="background-image: linear-gradient(rgb(92,184,92), #fff); "><img class="logo" src="../res/imgs/98-movies-logo.png"></center>

  <div class="container" style="margin-top: 40px;">

    <div class="card" style="border-color: green;">
      <div class="card-header cadastro">Cadastro</div>
          <div class="card-body">
            
          <form action="processamento.php?acao=salvar&cadastro=true" method="post">
            <input type="hidden" type="number" name="idPerfil" id="idPerfil" value="1" />
            <input type="hidden" type="number" name="cont_adulto" id="cont_adulto" value="false" />
            <div class="form-group">

              <label style="font-size: 25px; color:green; "><span class="fas fa-user"></span> Dados Pessoais</label><br />
              
              <label>Por favor, insira seus dados abaixo para realizar seu cadastro.</label><br /><br />
              <div class="row">
                <div class="col">
                  <label for="nome">Nome: </label><input type="text" class="form-control" name="nome" id="nome" required/><br />
                </div>
                <div class="col">
                  <label for="sobrenome">Sobrenome: </label><input type="text" class="form-control" name="sobrenome" id="sobrenome" required/><br />
                </div>
              </div>

              <div class="row">
                <div class="col" id="datepicker">
                  <label for="data_nasc">Data de Nascimento: </label><input type="text" class="form-control" name="data_nasc" id="data_nasc" maxlength="10" autocomplete="off" required/><br />
                </div>
                <div class="col">
                  <label for="genero">Sexo: </label>
                  <select class="form-control selectpicker show-tick" title="Selecione" name="sexo" required>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="O">Outros</option>
                  </select>
                </div>
              </div>
              
              <div class="row">
                <div class="col">
                  <label for="celular">Celular: </label><input type="text" class="form-control" name="celular" id="celular" required/><br />
                </div>
                <div class="col">
                  <label for="telefone">Telefone: </label><input type="text" class="form-control" name="telefone" id="telefone" required/><br />
                </div>
              </div>

              <label for="email">Email: </label><input type="email" class="form-control" name="email" id="email" required/><br />

              <div class="row">
                <div class="col">
                  <label for="senha">Senha: </label><input type="password" class="form-control" name="senha" id="senha" /><br required/>
                </div>
                <div class="col">
                  <label for="csenha">Repita a senha: </label><input class="form-control" type="password" name="csenha" id="csenha" required/><br />
                </div>
              </div>

              <label for="preferencias">Gêneros Favoritos: </label>
              <select class="selectpicker form-control" id="categoria" name="categoria[]" data-live-search="true" data-header="Selecione ao menos 3 opções!" multiple title="Selecione" required>
              
              <?php foreach($categorias as $categoria){ ?>

                  <option value='<?php echo $categoria['id']; ?>'><?php echo $categoria['name']; ?></option>
    
              <?php } ?>  
              </select>
              <br />
              <br />

              <label style="font-size: 25px; color:green"><span class="fas fa-map-marker-alt"></span> Endereço</label><br />
              <label>Por favor, insira os dados do seu endereço.</label><br><br>
              <div class="row">
                <div class="col">

                  <label for="cep">CEP: </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="cep" id="cep" required/>
                      <div class="input-group-append">
                        <button class="btn btn-outline-success" type="button" id="button-cep" onclick="checkCep()"><span id="loader-cep" class="spinner-border text-success spinner-border-sm" role="status" hidden></span> Buscar</button>
                      </div>
                    </div>
                  <br>

                  <label for="localidade">Cidade: </label><input class="form-control" type="text" name="localidade" id="localidade" required/><br />
                </div>
                <div class="col">
                  <label for="uf">Estado: </label><input class="form-control" type="text" name="uf" id="uf" required/><br />

                  <label for="bairro">Bairro: </label><input class="form-control" type="text" name="bairro" id="bairro" required/><br />
                </div>
              </div>

              <label for="complemento">Complemento: </label><input class="form-control" type="text" name="complemento" id="complemento"/><br />
              
              <div style="text-align: center;"><button type="submit" class="btn btn-success btn-lg" id="continuar">Continuar</button>
              <a href="login.php" class="btn btn-success btn-lg">Voltar</a></div>
            </div>
          </form>
        </div>
    </div>
  
</div><!-- Fechando a Classe Container -->

<script>

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

document.getElementsByTagName("BODY")[0].onresize = function() {checkSelect()};


function checkSelect() {
    $('select').each(function() {
        if ($(this).attr('disabled')) 
            return true;
        else 
            $('.selectpicker').selectpicker('refresh');
    });  
}

$('#email').change(function(){
    var email = $('#email').val();
    var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

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
                    })
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

</body>
</html>