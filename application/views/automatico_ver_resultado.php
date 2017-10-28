<div>
    <h2 class="versalete">Setor da vida: <?=$setorVida->nome_setor_vida?></h2>
</div>
<? foreach($casasPreenchidas as $key => $casa): ?>
    <? $class = ($key == 0) ? "" : "hidden" ?>
    <div class="<?=$class?>" id="div-casa-<?=$casa["casaCarta"]->cod_casa_carta?>">
        <div class="clearfix tMargin20">
            <a class="newBlueButton" name="casa-anterior" casa="<?=$casa["casaCarta"]->cod_casa_carta?>"><span>Casa anterior</span></a>
            <a class="newBlueButton right" name="proxima-casa" casa="<?=$casa["casaCarta"]->cod_casa_carta?>"><span>Pr&oacute;xima casa</span></a>
        </div>
        <div class="tCenter tMargin10">
            <span class="img-carta">
                <img src="<?=base_url()?>assets/images/cartas/<?=$casa["arcanoMaior"]->cod_carta?>.jpg" width="150" height="262"/>
                <span><?=$casa["arcanoMaior"]->nome_carta?></span>
            </span>
            <span class="img-carta">
                <img src="<?=base_url()?>assets/images/cartas/<?=$casa["arcanoMenor1"]->cod_carta?>.jpg" width="150" height="262"/>
                <span><?=$casa["arcanoMenor1"]->nome_carta?></span>
            </span>
            <span class="img-carta">
                <img src="<?=base_url()?>assets/images/cartas/<?=$casa["arcanoMenor2"]->cod_carta?>.jpg" width="150" height="262"/>
                <span><?=$casa["arcanoMenor2"]->nome_carta?></span>
            </span>
        </div>

        <div class="big-widget tMargin20">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget extrato">
                            <div id="wrapper">
                                <div id="container">

                                    <div class="tMargin10"><h2><?=$casa["casaCarta"]->nome_casa_carta?>: <?=$casa["casaCarta"]->titulo_casa_carta?></h2></div>
                                    <!-- <div><p class="justify"><i><?=$casa["casaCarta"]->descricao_casa_carta?></i></p></div> -->

                                    <!-- <div class="tMargin20"><h2>Resultado</h2></div> -->
                                    <div><?=@$casa["resultado"]->texto_combinacao?><?=($casa["comprado"]==false)?"":""?></div>
                                    <? if($casa["comprado"] == false): ?>
                                        <div class="tMargin10">
                                            Continue lendo a sua interpretação por apenas R$ <?= number_format($custoCombinacao, 2, ",", ".") ?> por página. Acima você tem uma noção da quantidade de conteúdo observando a área criptografada.
                                        </div>
                                        <div style="clear: both; margin-top: 20px;" class="clearfix">
                                            <? if($logado): ?>
                                                <a href="<?=site_url()?>/compra/jogo/confirm" class="newBlueButton">
                                                    <span>Obter leitura completa</span>
                                                </a>
                                            <? else: ?>
                                                <a href="<?=site_url()?>/compra/jogo/confirm_without_login" class="newBlueButton"><span>Obter leitura completa</span></a>
                                            <? endif; ?>
                                        </div>
                                    <? endif; ?>
                                    <div class="clearfix" style="margin-top: 30px;">
                                        <a class="newBlueButton" name="casa-anterior" casa="<?=$casa["casaCarta"]->cod_casa_carta?>"><span>Casa anterior</span></a>
                                        <a class="newBlueButton right" name="proxima-casa" casa="<?=$casa["casaCarta"]->cod_casa_carta?>"><span>Pr&oacute;xima casa</span></a>
                                    </div>
                                    <div class="clearfix" style="text-align: center; margin-top:30px;">
                                        <a href="<?=site_url()?>/jogo/escolherSetorVida" class="newBlueButton"><span>Come&ccedil;ar um novo jogo</span></a>
                                    </div >

                                </div>
                              </div>
                          </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
    </div>
<? endforeach; ?>
<script>
$(document).ready(function(){
    var DIV_CASA = [
        <? foreach($casasPreenchidas as $casa): ?>
            <?=$casa["casaCarta"]->cod_casa_carta?>,
        <? endforeach; ?>
    ];
    
    $("a[name=casa-anterior]").click(clickCasaAnterior);
    $("a[name=proxima-casa]").click(clickProxCasa);

    function clickCasaAnterior(){
        var cod = parseInt($(this).attr("casa"));
        
        // obtem o indice atual
        var idx = $.inArray(cod, DIV_CASA);
        
        // determina o indice anterior
        if(idx == 0){
            idx = DIV_CASA.length - 1;
        }else{
            idx -= 1;
        }
        
        // esconde a div atual e mostra a anterior
        $("#div-casa-"+cod).fadeOut(400, function(){
            $("#div-casa-"+DIV_CASA[idx]).fadeIn();
        });

        // recarrega os banners
        reloadBanners();
    }
    
    function clickProxCasa(){
        var cod = parseInt($(this).attr("casa"));
        
        // obtem o indice atual
        var idx = $.inArray(cod, DIV_CASA);
        
        // determina o proximo indice
        if(idx == DIV_CASA.length - 1){
            idx = 0;
        }else{
            idx += 1;
        }
        
        // esconde a div atual e mostra a anterior
        $("#div-casa-"+cod).fadeOut(400, function(){
            $("#div-casa-"+DIV_CASA[idx]).fadeIn();
        });

        // recarrega os banners
        reloadBanners();
    }

    function reloadBanners(){
        // recarrega o iframe com banner
        // top
        var iframe = document.getElementById('top-banner');
        iframe.src = iframe.src;

        // bottom
        var iframe = document.getElementById('bottom-banner');
        iframe.src = iframe.src;

        // medio 1
        var iframe = document.getElementById('banner-medio-1');
        iframe.src = iframe.src;

        var iframe = document.getElementById('banner-medio-2');
        iframe.src = iframe.src;
    }
});
</script>