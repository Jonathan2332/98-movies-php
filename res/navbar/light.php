<div class="navbar-bg-custom-light"></div>

<nav id="navbar" class="navbar navbar-expand-lg navbar-light rounded custom-navbar" value="light">
  <img src="../res/imgs/logo-simple.png" width="56" height="56">
  <button id="button-toggle" onclick="checkBackground()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto mx-2">
        
      <li class="nav-item active">
        <a class="nav-link" href="../usuario/inicial.php"><span class="fas fa-home" aria-hidden="true"></span> Início</a>
      </li>
      <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="filmesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="fas fa-film" aria-hidden="true"></span> Filmes
                </a>
                <div class="dropdown-menu" aria-labelledby="filmesDropdown">
                  <a class="dropdown-item" href="../filme/explorar.php">Explorar</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=populares">Populares</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=avaliados">Mais bem avaliados</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=lancamentos">Próximos lançamentos</a>
                  <a class="dropdown-item" href="../usuario/inicial.php?type=cartaz">Em cartaz</a>
                </div>
            </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="fas fa-bars" aria-hidden="true"></span> Categorias
        </a>
        <div id="nav-cat" class="dropdown-menu" aria-labelledby="navbarDropdown">
          
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
                    <a class="dropdown-item" href="../usuario/perfil.php">Meu perfil</a>
                    <a class="dropdown-item" href="../usuario/lista.php?type=favoritos">Meus favoritos</a>
                    <a class="dropdown-item" href="../usuario/lista.php?type=interesses">Lista de interesses</a>
                    <?php if($_SESSION['usuario']['idPerfil'] == 2) { ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../perfil/index.php">Gerenciar Perfis</a>
                        <a class="dropdown-item" href="../pagina/index.php">Gerenciar Páginas</a>
                        <a class="dropdown-item" href="../usuario/gerenciar.php">Gerenciar Usuários</a>
                    <?php } ?>
                </div>
            </li>
      <li class="nav-item active">
        <a class="nav-link" href="../usuario/processamento.php?acao=logoff"><span class="fas fa-sign-out-alt" aria-hidden="true"></span> Sair</a>
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