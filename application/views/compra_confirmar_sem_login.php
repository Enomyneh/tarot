<h2>Confirmar compra do jogo</h2>
<p>Confira as combinacoes do seu jogo abaixo</p>
<div class="lista-jogo-completo">
    <? $total = 0; ?>
    <span class="casa"></span>
    <span class="carta">Arcano Maior</span>
    <span class="carta">Arcano Menor 1</span>
    <span class="carta">Arcano Menor 2</span>
    <span style="display: inline-block; width: 100px;">Valor</span>
    <? foreach ($jogoCompleto as $key => $jogo) : ?>
        <span class="casa"><?=$jogo["casaCarta"]->nome_casa_carta?></span>
        <span class="carta">
            <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMaior"]->cod_carta?>.jpg" width="29" height="50">
            <br/><?=$jogo["arcanoMaior"]->nome_carta?>
        </span>
        <span class="carta">
            <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor1"]->cod_carta?>.jpg" width="29" height="50">
            <br/><?=$jogo["arcanoMenor2"]->nome_carta?>
        </span>
        <span class="carta">
            <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor2"]->cod_carta?>.jpg" width="29" height="50">
            <br/><?=$jogo["arcanoMenor1"]->nome_carta?>
        </span>
        <span class="valor">R$ <?=moeda($custo)?></span>
        <? $total += $custo; ?>
    <? endforeach; ?>
</div>
<div>
    <h2>Total: R$ <?=moeda($total)?></h2>
</div>
<h2>Confirmar compra</h2>
<div>
    <p>Tem certeza que deseja confirmar a compra do jogo acima?</p>
</div>
<div class="tMargin20 clearfix">
    <a href="<?=site_url()?>/compra/jogo/confirm" class="newGreenButton"><span>Confirmar</span></a>
</div>