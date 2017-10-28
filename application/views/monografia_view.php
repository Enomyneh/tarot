<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <!--<div class="mensagem">Monografia salva com sucesso!</div>-->
    <h1>Monografias:</h1>
    <br/>
    <a href="<?=site_url()?>/monografia/save">Cadastrar nova</a>
    <br/><br/>
    <table width="100%" class="table">
        <thead>
            <tr>
                <th>Carta</th>
                <th>Pre&ccedil;o</th>
                <th>Tipo</th>
                <th>Keywords</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            <? $monografiaAtual = null; ?>
            <? foreach($monografias as $monografia): ?>
                <? if($monografiaAtual != $monografia->cod_monografia): ?>
                    <? $monografiaAtual = $monografia->cod_monografia ?>
                    <? if($monografiaAtual != NULL): ?>
                        </tr>
                    <? endif; ?>
                    <tr>
                        <td>
                            <? if($monografia->titulo_geral != ""): ?>
                                <?= $monografia->titulo_geral ?>
                            <? else: ?>
                                <?= $monografia->nome_carta?>
                            <? endif; ?>
                            <? if($monografia->tipo_monografia == "PAGA"): ?>
                                <a target="_blank" href="<?= site_url()?>/monografia/ver?m=<?= $monografia->cod_monografia ?>"> (ver monografia)</a>
                            <? else: ?>
                                <a target="_blank" href="<?= site_url()?>/monografia/livre?m=<?= $monografia->cod_monografia ?>"> (ver monografia)</a>
                            <? endif; ?>
                        </td>
                        <td align="center">R$ <?=number_format($monografia->preco_monografia,2,",",".");?></td>
                        <td align="center"><?= $monografia->tipo_monografia ?></td>
                        <td><a href="<?= site_url()?>/monografia/saveKeywords?m=<?=$monografia->cod_monografia?>">Ver Keywords</a></td>
                        <td>
                            <? if($monografia->capa != "" AND strlen($monografia->capa) > 1): ?>
                                <a href="<?=site_url()?>/monografia/save?m=<?=$monografia->cod_monografia?>">CAPA</a><br/>
                            <? endif; ?>
                <? endif; ?>

                <a href="<?=site_url()?>/monografia/save?m=<?=$monografia->cod_monografia?>&d=<?=$monografia->cod_detalhe?>">
                    <?= $monografia->titulo ?> | <?= $monografia->sub_titulo ?> | <?= $monografia->detalhe_sub_titulo ?>
                </a> <a class="remover" href="<?=site_url()?>/monografia/removerDetalhe/<?=$monografia->cod_detalhe?>">(remover)</a><br/>
            <? endforeach; ?>
            </td></tr>
        </tbody>
    </table>
    <br/><br/>
    <a href="<?=site_url()?>/tarot">Voltar</a>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>
<script>

$("a.remover").click(function(evt){
    evt.preventDefault();

    if(confirm("Tem certeza que quer remover?")){
        window.location.href = $(this).attr("href");
    }
});

</script>
    
</body>
</html>