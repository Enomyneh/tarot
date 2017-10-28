<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<h1>Pedidos de Mapeamento</h1>

<? if(strlen($mensagem) > 1): ?>
    <div class="mensagem"><?=$mensagem?></div>
<? endif; ?>

<div class="container" style="width: 100%">
    <br/>
    <table width="99%" class="table" cellpadding="3" cellspacing="0">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Setor Vida</th>
                <th>Perguntas</th>
                <th>Enviou amostra?</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($pedidos as $key => $pedido): ?>
                <? $trClass = ($key % 2 == 0) ? "even" : "odd" ?>
                <tr class="<?= $trClass ?>">
                    <td><?=$pedido->cod_pedido?></td>
                    <td>
                        <a href="<?= site_url() ?>/conta/verUsuario?u=<?= $pedido->cod_usuario ?>">
                            <?=$pedido->nome_usuario?>
                            (<?= substr(mysql_to_br($pedido->data_nascimento_usuario), 0, 10) ?>)
                            [<?= $pedido->orientacao_sexual_usuario ?>]
                        </a>
                    </td>
                    <td><?=$pedido->email_usuario?></td>
                    <td><?=($pedido->mapeamento_tipo != "") ? $pedido->mapeamento_tipo : "Erro" ?></td>
                    <td><?=($pedido->nome_setor_vida != "") ? $pedido->nome_setor_vida : "Erro" ?> | <?=($pedido->sub_setor != "") ? $pedido->sub_setor : "Erro" ?></td>
                    <td>
                        <? foreach($pedido->perguntas as $pergunta): ?>
                            <span><?= $pergunta->pergunta ?></span><br/>
                        <? endforeach;  ?>
                    </td>
                    <td>
                        <? if($pedido->status_pedido == "AGUARDANDO_AMOSTRA"): ?>
                            <a href="<?= site_url()?>/pedido/registrarAmostra?pedido=<?= $pedido->cod_pedido?>">N&Atilde;O</a>
                        <? else: ?>
                            <b>SIM</b>
                        <? endif; ?>
                        <a class="remove" href="<?= site_url() ?>/pedido/remover?p=<?= $pedido->cod_pedido?>">(X)</a>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <br/><br/>
    <a href="<?=site_url()?>/tarot">Voltar</a>
    <br/><br/><br/><br/>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>

<script>

$("a.remove").click(function(evt){

    evt.preventDefault();

    if(confirm("Tem certeza?")){

        window.location.href = $(this).attr("href");
    }
});
</script>
    
</body>
</html>
