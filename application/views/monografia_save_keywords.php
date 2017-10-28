<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <form method="POST" action="<?= site_url() ?>/monografia/doSaveKeywords" style="padding: 40px;">
        <? if($monografia[0]->titulo_geral != ""): ?>
            <h1><?= $monografia[0]->titulo_geral ?></h1>
        <? else: ?>
            <h1>Carta: <?= $carta->nome_carta ?></h1>
        <? endif; ?>
        

        <h1>Keywords:</h1>

        <textarea name="keywords" style="width: 100%; height: 200px;"><?= $monografia[0]->keywords ?></textarea>

        <div style="margin-top: 40px;">
            <input type="submit" value="Salvar"/>
        </div>
        <input name="cod_monografia" type="hidden" value="<?= $monografia[0]->cod_monografia ?>" />
    </form>
    <a href="<?=site_url()?>/tarot">Voltar</a>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>
<script>

</script>
    
</body>
</html>