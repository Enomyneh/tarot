<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <form id="frm" action="<?=site_url()?>/conta/doIncluirCredito" method="POST">
        <h1>Incluir cr&eacute;dito:</h1>
        <br/>
        <label>Usu&aacute;rio:</label>
        <span><?=$login->nome?> - <?=$login->email?></span>
        <br/><br/>
        <label>Saldo:</label>
        <span>R$ <?=moeda($saldo)?></span>
        <br/><br/>
        <label>Cr&eacute;dito:</label>
        <input name="credito" type="text"/>
        <br/><br/>
        <input type="hidden" name="cod_usuario" value="<?=$login->cod?>"/>
        <input type="submit" class="button" value="Gravar"/>
        <br/><br/><br/>
        <a href="<?=site_url()?>/conta/verUsuarios">Voltar</a>
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>
    
</body>
</html>