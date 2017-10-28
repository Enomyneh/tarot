<? foreach($jogoAleatorio as $jogo): ?>
<div>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMaior"]->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$jogo["arcanoMaior"]->nome_carta?></span>
    </span>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor1"]->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$jogo["arcanoMenor1"]->nome_carta?></span>
    </span>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor2"]->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$jogo["arcanoMenor2"]->nome_carta?></span>
    </span>
</div>
<? endforeach; ?>