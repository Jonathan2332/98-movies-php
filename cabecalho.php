<?php
    session_start();
    include_once '../banco/Usuario.php';

    if(!(new Usuario())->possuiAcesso())
    {
        if(isset($_SESSION['usuario']))
          unset($_SESSION['usuario']);
        
        header('location: ../usuario/login.php');
    }

?>
<html lang="pt">
<head>
	<title>98 Movies</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link rel="shortcut icon" href="../res/imgs/98-movies.ico" type="image/x-icon"/>

	<link type="text/css" rel="stylesheet" href="../../js/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../js/bootstrap-select/dist/css/bootstrap-select.css">
	<link rel="stylesheet" href="../../js/fancybox/dist/jquery.fancybox.css"/>
	<link rel="stylesheet" href="../../js/fleximages/flex-images.css" />
	<link rel="stylesheet" href="../../js/animate.css"/>
  <link rel="stylesheet" href="../../js/sweetalert/dist/sweetalert2.css">
  <link href="../../js/fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
  <link rel="stylesheet" href="../../js/sweetalert-themes/dark/dark.css">
  <link rel="stylesheet" href="../../js/datepicker/dist/css/bootstrap-datepicker3.css">
  <link rel="stylesheet" href="../../js/simplePagination/simplePagination.css">

	<script type="text/javascript" src="../../js/jquery-2.1.4.js"></script>
	<script type="text/javascript" src="../../js/jquery.maskedinput.min.js"></script>
  <script type="text/javascript" src="../../js/jquery.maskMoney.min.js"></script>
	<!-- <script type="text/javascript" src="../../js/bootstrap/js/bootstrap.min.js"></script> -->
  <script type="text/javascript" src="../../js/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../js/bootstrap-select/dist/js/bootstrap-select.js"></script>
	<script src="../../js/fleximages/flex-images.js"></script>
	<script src="../../js/fancybox/dist/jquery.fancybox.js"></script>
  <script src="../../js/sweetalert/dist/sweetalert2.js"></script>
  <script src="../../js/datepicker/dist/js/bootstrap-datepicker.js"></script>
  <script src="../../js/datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
  <script src="../../js/simplePagination/jquery.simplePagination.js"></script>



</head>

<style type="text/css">
  @font-face
  {
      font-family: FilmLetters;
      src: url('../res/FilmLetters.ttf');
  }
  .logo
  {
      padding-top: 20px; 
      width: 35%;
      min-width: 500px;
  }
  .custom-navbar
  {
      background-color: transparent; 
      position: fixed; 
      top: 0; 
      z-index: 99; 
      transition: 0.4s; 
      width: 100%;
  }
  .navbar-bg-custom-dark
  {
      background-image: linear-gradient(rgb(92,184,92), #262626); 
      padding-top: 70px;
  }
  .navbar-bg-custom-light
  {
      background-image: linear-gradient(rgb(92,184,92), #fff); 
      padding-top: 70px;
  }
  .loader-image {
      background-repeat: no-repeat;
      background-size: contain;
      background-position: center center;
      background-image: url('../res/imgs/gifloader.gif');
  }
</style>
<body>
