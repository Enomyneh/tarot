<h2>Cartas</h2>
<div class="tCenter">
    <? if($casasPreenchidas != ""): ?>
        <h3><a href="<?=site_url()?>/tarot/montarJogo">Clique aqui </a>para continuar montando seu jogo!</h3>
    <? endif; ?>
    <? if($origem == "comb"): ?>
        <h3><a href="<?=site_url()?>/combinacao/resumo">Clique aqui </a>para ver suas combinações!</h3>
    <? endif; ?>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$arcanoMaior->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$arcanoMaior->nome_carta?></span>
    </span>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$arcanoMenor1->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$arcanoMenor1->nome_carta?></span>
    </span>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$arcanoMenor2->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$arcanoMenor2->nome_carta?></span>
    </span>
</div>