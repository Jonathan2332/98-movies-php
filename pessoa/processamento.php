<?php 

if(empty($_GET['acao']))
    header('location: inicial.php');

include_once '../api/API.php';

$oApi = new API();

if($_GET['acao'] == 'carregar-fotos')
{
	$oApi->getPersonPhotos($_GET['id']);
	die;
}
else if($_GET['acao'] == 'carregar-trabalhos')
{
	$oApi->getWorksPerson($_GET['id']);
	die;
}
else if($_GET['acao'] == 'carregar-pessoas-populares')
{
	$oApi->getPopularPeople($_GET['page']);
	die;
}

?>
