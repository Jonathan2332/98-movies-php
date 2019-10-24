<?php

if(empty($_GET['acao']))
    header('location: ../usuario/inicial.php');

include_once '../api/Api.php';

$oApi = new API();

switch ($_GET['acao']) 
{
    case 'carregar-populares':
        $oApi->getPopulares($_GET['page']);
    die;
    case 'carregar-avaliados':
        $oApi->getAvaliados($_GET['page']);
    die;
    case 'carregar-lancamentos':
        $oApi->getLancamentos($_GET['page']);
    die;
    case 'carregar-cartaz':
        $oApi->getCartaz($_GET['page']);
    die;
    case 'carregar-based':
        $oApi->getBasedOnFavorites($_GET['idCat'],$_GET['page'],$_GET['cont_adulto'],$_GET['tipo']);
    die;
    case 'carregar-filtro':
        $oApi->getByGenre($_GET['idCat'],$_GET['page'],$_GET['cont_adulto']);
    die;
    case 'carregar-busca':
        $oApi->getBySearch($_GET['busca'],$_GET['page'],$_GET['cont_adulto'], $_GET['type']);
    die;
    case 'carregar-equipe-tecnica':
        $oApi->getEquipeTecnica($_GET['id']);
    die;
    case 'carregar-elenco':
        $oApi->getElenco($_GET['id']);
    die;
    case 'carregar-posters':
        $oApi->getMoviePosters($_GET['id']);
    die;
    case 'carregar-backdrops':
        $oApi->getMovieBackdrops($_GET['id']);
    die;
    case 'carregar-videos':
         $oApi->getMovieVideos($_GET['id']);
    die;
    case 'carregar-recomendacoes':
        $oApi->getRecomendations($_GET['id']);
    die;
    case 'carregar-similares':
        $oApi->getSimilars($_GET['id']);
    die;
    case 'explorar-filmes':
        $oApi->exploreMovie($_GET['page'],$_GET['cont_adulto'],$_GET['ano'],$_GET['sort_by'],$_GET['categorias']);
    die;
}