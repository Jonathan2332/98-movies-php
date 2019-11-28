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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" href="../res/imgs/favicon.ico" type="image/x-icon"/>

	<link type="text/css" rel="stylesheet" href="../res/js/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../res/js/bootstrap-select/dist/css/bootstrap-select.css">
	<link rel="stylesheet" href="../res/js/fancybox/dist/jquery.fancybox.css"/>
	<link rel="stylesheet" href="../res/js/fleximages/flex-images.css" />
	<link rel="stylesheet" href="../res/js/animate.css"/>
  <link rel="stylesheet" href="../res/js/sweetalert/dist/sweetalert2.css">
  <link href="../res/js/fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
  <link rel="stylesheet" href="../res/js/sweetalert-themes/dark/dark.css">
  <link rel="stylesheet" href="../res/js/datepicker/dist/css/bootstrap-datepicker3.css">
  <link rel="stylesheet" href="../res/js/simplePagination/simplePagination.css">

	<script type="text/javascript" src="../res/js/jquery-2.1.4.js"></script>
	<script type="text/javascript" src="../res/js/jquery.maskedinput.min.js"></script>
  <script type="text/javascript" src="../res/js/jquery.maskMoney.min.js"></script>
  <script type="text/javascript" src="../res/js/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../res/js/bootstrap-select/dist/js/bootstrap-select.js"></script>
	<script src="../res/js/fleximages/flex-images.js"></script>
	<script src="../res/js/fancybox/dist/jquery.fancybox.js"></script>
  <script src="../res/js/sweetalert/dist/sweetalert2.js"></script>
  <script src="../res/js/datepicker/dist/js/bootstrap-datepicker.js"></script>
  <script src="../res/js/datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
  <script src="../res/js/simplePagination/jquery.simplePagination.js"></script>


</head>

<style type="text/css">
  .menu-mobile {         
    max-height: 200px;
    overflow-y: auto;
  }
  .logo
  {
      padding-top: 20px; 
      width: 35%;
      min-width: 500px;
  }
  .logoMobile
  {
      padding-top: 20px; 
      width: 35%;
      min-width: 320px;
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
