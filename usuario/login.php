<?php
  include_once '../cabecalho.php';
?>

<style type="text/css">
  .login
  {
      color:white!important;
      font-size: 55px;
      background-color: rgb(92,184,92)!important;
      border-color:black!important;
  }
  .loginMobile
  {
      color:white!important;
      font-size: 20px;
      background-color: rgb(92,184,92)!important;
      border-color:black!important;
  }
  body
  {
      background-image: url(../res/imgs/bg-login.jpg);
  }
</style>

<center><img id="logo" class="logo" src="../res/imgs/logo-full.png"></center>

<div id="painel" class="container" style="margin-top: 70px; max-width: 600px;">

  <div class="card" style="border: none">
    <div id="header" class="card-header login">Entrar</div>
    <div class="card-body">

      <form class="form-horizontal" action="processamento.php?acao=logar" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
            </div>
            <input type="email" class="form-control" id="email" name="email" placeholder="Insira o email" required>
          </div>
          
        </div>
        <div class="form-group">
          <label for="password">Senha</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" id="password" name="password" aria-describedby="securityMsg" placeholder="Insira a senha" required>
          </div>
          <small id="securityMsg" class="form-text text-muted">Nunca compartilhe seu email e senha com ninguém.</small>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="alwaysConnected" name="keepLoged">
          <label class="form-check-label" for="alwaysConnected">Matenha-me conectado</label>
        </div>
        <button type="submit" class="btn btn-success">Entrar</button>
        <button onclick="window.location.href='cadastrar.php'" type="button" class="btn btn-success">Cadastrar-se</button>
      </form>

    </div>
  </div>
  
</div><!-- Fechando a Classe Container -->

</body>
</html>
<script type="text/javascript">
  
 function detectmob() { 
 if(navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i))
    return true;
 else
    return false;
}

if(detectmob())
{
    document.getElementById("logo").className = "logoMobile";
    document.getElementById("header").className = "card-header loginMobile";
    document.getElementById("painel").style.marginTop = "30px";
}

</script>




