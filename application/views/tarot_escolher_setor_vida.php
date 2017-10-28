<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <h1>Cartas</h1>
    <div class="clearfix">
        <div class="left">
            <p class="box">
                <label>Arcano Maior</label>
                <span><?=$arcanoMaior->nome_carta?></span>
            </p>
        </div>
        <div class="left">
            <p class="box">
                <label>Arcano Menor 1:</label>
                <span><?=$arcanoMenor1->nome_carta?></span>
            </p>
        </div>
        <div class="left">
            <p class="box">
                <label>Arcano Menor 2:</label>
                <span><?=$arcanoMenor2->nome_carta?></span>
            </p>
        </div>
        <div class="left">
            <p class="box cor-3">
                <label>Tipo de Jogo:</label>
                <span><?=$grupoCasaCarta->nome_grupo_casa_carta?></span>
            </p>
        </div>
    </div>

    <div>
        <h1>Escolha o setor</h1>
        <p class="setores-vida">
            <? foreach($setoresVida as $setorVida): ?>
                <span><a class="button" href="javascript:void(0);" cod_setor_vida="<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></a></span>
            <? endforeach; ?>
        </p>
    </div>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>

<script>

$(document).ready(function(){
   
   // adiciona os eventos
   $(".setores-vida a").click(clickSetorVida);
});

function clickSetorVida(){
    console.log("ok");
    // obtem o codigo do setor da vida clicado
    var codSetorVida = $(this).attr("cod_setor_vida");
    
    // obtem os parametros do php
    var arcanoMaior = <?=$arcanoMaior->cod_carta?>;
    var arcanoMenor1 = <?=$arcanoMenor1->cod_carta?>;
    var arcanoMenor2 = <?=$arcanoMenor2->cod_carta?>;
    var grupoCasaCarta = <?=$grupoCasaCarta->cod_grupo_casa_carta?>;
    
    // monta a url para redirecionar
    var url = '<?=site_url()?>'+'/tarot/escolherCasa?ama='+arcanoMaior
              +'&ame1='+arcanoMenor1+'&ame2='+arcanoMenor2+'&sv='+codSetorVida
              + '&gcc='+grupoCasaCarta;
    
    // redireciona para a tela de escolha das casas
    window.location.href = url;
}

</script>
    
</body>
</html>