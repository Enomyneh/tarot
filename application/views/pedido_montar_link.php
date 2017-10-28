<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<h1>Montar link</h1>

<select id="setor-vida">
    <? foreach($setoresVida as $setor): ?>
        <? if($setor->link_label != ""): ?>
            <option value="<?= $setor->cod_setor_vida?>#<?=$setor->link_label?>"><?= $setor->nome_setor_vida?></option>
        <? endif; ?>
    <? endforeach; ?>
</select>

<? foreach($subSetoresVida as $key => $subSetor): ?>

    <select id="sub-setor-cod-<?=$key?>" style="display: none;" name="sub-setores">
    <? foreach($subSetor as $sub): ?>

        <option value="<?= $sub->link_label ?>"><?= $sub->sub_setor ?></option>

    <? endforeach; ?>
    </select>

<? endforeach; ?>

<select id="tipo-mapa">
    <? foreach($tiposMapeamento as $tipo): ?>
        <option value="<?= $tipo->link_label ?>"><?= $tipo->tipo ?></option>
    <? endforeach; ?>
</select>

<input type="button" id="montar" value="montar"/>

<div id="link-montado" style="display: none;"><?=site_url()?>/pedido/mapeamento?<span id="query-string"></span></div>


<br/>
<textarea id="mostra-link-montado" style="width: 500px; height: 70px;"></textarea>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>


<script>

$("#setor-vida").change(function(){

    // oculta todos
    $("select[name=sub-setores]").hide();

    // mostra o select
    $("#sub-setor-cod-"+$(this).val().split("#")[0]).show();

});


$("#montar").click(function(){

    var setorVida = $("#setor-vida").val();
    var codSetorVida = setorVida.split("#")[0];
    var linkLabelSV = setorVida.split("#")[1];
    var subSetor    = $("#sub-setor-cod-"+codSetorVida).val();
    var tipoMapa    = $("#tipo-mapa").val();

    $("#query-string").html("setor-vida="+linkLabelSV+"&sub-setor="+subSetor+"&tipo-mapa="+tipoMapa);

    $("#mostra-link-montado").val($("#link-montado").text());

});

$("document").ready(function(){

    $("select[name=sub-setores]:first").show();
});

</script>

</body>
</html>
