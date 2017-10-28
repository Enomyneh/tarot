<div>
    <h2>Setor da vida: <?=$setorVida->nome_setor_vida?></h2>
    <span><?=$setorVida->descricao?></span>
</div>
<div>
    <div class="tCenter tMargin10">
        <span class="img-carta">
            <img src="<?=base_url()?>assets/images/cartas/<?=$cartas->cod_arcano_maior?>.jpg" width="150" height="262"/>
            <span><?=$cartas->nome_arcano_maior?></span>
        </span>
        <span class="img-carta">
            <img src="<?=base_url()?>assets/images/cartas/<?=$cartas->cod_arcano_menor_1?>.jpg" width="150" height="262"/>
            <span><?=$cartas->nome_arcano_menor_1?></span>
        </span>
        <span class="img-carta">
            <img src="<?=base_url()?>assets/images/cartas/<?=$cartas->cod_arcano_menor_2?>.jpg" width="150" height="262"/>
            <span><?=$cartas->nome_arcano_menor_2?></span>
        </span>
    </div>
    <div class="tMargin10"><h2><?=$casaCarta->nome_casa_carta?>: <?=$casaCarta->titulo_casa_carta?></h2></div>
    <div><p class="justify"><i><?=$casaCarta->descricao_casa_carta?></i></p></div>

    <div class="tMargin20"><h2>Resultado</h2></div>
    <div><?=@$resultado->texto_combinacao?></div>

    <div class="clearfix" style="margin-top:30px;">
        <a href="<?=site_url()?>/combinacao/resumo" class="newGreenButton"><span>Escolher outra combinação</span></a>
        <a href="<?=site_url()?>/jogo/escolherCasaCarta?cuc=<?=$codUsuarioCombinacao?>&sv=<?= $setorVida->cod_setor_vida ?>" class="newGreenButton"><span>Escolher outra Casa</span></a>
        <a href="<?=site_url()?>/jogo/escolherSetorVida?cuc=<?=$codUsuarioCombinacao?>" class="newGreenButton"><span>Escolher outro Setor da Vida</span></a>
    </div >
</div>