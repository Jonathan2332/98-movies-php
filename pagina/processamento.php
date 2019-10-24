<?php
if(empty($_GET['acao']))
    header('location: index.php');

include_once '../banco/Pagina.php';

$pagina = new Pagina();

include_once '../cabecalho.php';

switch ($_GET['acao']) {
    case 'salvar':
        if (!empty($_POST['idPagina'])) {
            $resultado = $pagina->alterar($_POST);
        } else {
            $resultado = $pagina->inserir($_POST);
        }
    break;
    case 'excluir':
        $pagina->excluir($_GET['idPagina']);
    break;

}

$status = $resultado ? 1 : 0;

?>

<script type="text/javascript">
<?php if($_GET['acao'] == 'salvar') { ?>
    var resultado = <?php echo $status; ?>;
    if(resultado == 1)
    {
        Swal.fire({
          title: 'Operação realizada com sucesso!',
          type: 'success',
          showConfirmButton: true,
            onClose: () => {
                window.location.href = 'index.php';
            }
        });
    }
    else
    {
        Swal.fire({
          title: 'Ocorreu um erro.',
          type: 'error',
          showConfirmButton: true,
            onClose: () => {
                window.location.href = 'index.php';
            }
        })
    }
<?php } ?>
</script>