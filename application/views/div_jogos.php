<div class="mapas">
    <div class="clearfix gray-bg">
        <? if($jogo->titulo == "" || is_null($jogo->titulo)): ?>
            <span class="titulo definir-titulo">Clique aqui para definir um título</span>
        <? else: ?>
            <span class="titulo"><?=$jogo->titulo?></span>
        <? endif; ?>
        <input cod="<?=$jogo->cod_url_jogo?>" type="text" value="<?=@$jogo->titulo?>" class="hidden" />
        <span class="loading hidden">Salvando...</span>
    </div>
    <div class="clearfix">
        <span class="left">
            <b class="versalete">Setor da Vida:</b> <?= $jogo->nome_setor_vida ?>
        </span>
        <span class="right">

                <? if($jogo->jogoCompleto->liberadoParaConsulta == true): ?>
                    <a href="<?=site_url()?>/jogo/resultado/token/<?=$jogo->token?>">
                        Ver Análise Completa
                    </a>
                <? else: ?>
                    <a href="<?=site_url()?>/mapa/verJogoCompleto?token=<?=$jogo->token?>">
                        <? if($jogo->jogoCompleto->custo > 0): ?>
                            Ver Análise Completa por apenas R$ <?=moeda($jogo->jogoCompleto->custo)?>
                        <? else: ?>
                            Ver Análise Completa
                        <? endif; ?>
                    </a>
                <? endif; ?>
        </span>
    </div>
    <div class="clearfix">
        <span class="left">
            <b class="versalete">Data do Jogo:</b> <?= mysql_to_br($jogo->data_cadastro) ?>
        </span>
        <span class="right">
            <? if($jogo->jogoCompleto->jaComprado == true): ?>
                Você comprou este jogo
            <? else: ?>
                <? if($jogo->jogoCompleto->custo > 0): ?>
                    <a href="<?=site_url()?>/jogo/resultado/token/<?=$jogo->token?>">Ver a Amostra Gratuita</a>
                <? endif; ?>
            <? endif ?>
        </span>
    </div>
<div class="bottom-border"></div>
</div>