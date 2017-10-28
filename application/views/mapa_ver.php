<div>
    <? if(count($jogosConsultaVirtual) == 0 AND count($jogosAutoConsulta)): ?>
        <h2>No momento não há mapas.</h2>
    <? endif; ?>

    <? if(count($pedidos) > 0): ?>
        <div>
            <h2>Meus Pedidos de An&aacute;lise</h2>
        </div> 
        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget">
                            <? foreach($pedidos as $pedido): ?>
                                <div class="mapas">
                                    <div class="clearfix brown-bg">
                                        <span class="titulo">Número do pedido: <?= $pedido->cod_pedido ?></span>
                                    </div>
                                    <div class="clearfix">
                                        <span class="left">
                                            <b class="versalete">Setor da Vida:</b> <?= $pedido->nome_setor_vida ?>
                                        </span>
                                        <span class="left lMargin20">
                                            <b class="versalete">Sua situa&ccedil;&atilde;o:</b> <?= $pedido->sub_setor ?>
                                        </span>
                                        <span class="left lMargin20">
                                            <b class="versalete">Tipo:</b> <?= $pedido->mapeamento_tipo ?>
                                        </span>
                                    </div>
                                    <div class="clearfix">
                                        <span class="left">
                                            <b class="versalete">Status do pedido:</b> <?= $statusAmigavel[$pedido->status_pedido] ?>
                                        </span>
                                    </div>
                                    <div class="bottom-border"></div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
    <? endif; ?>

    <? if(count($jogosConsultaVirtual) > 0): ?>
        <div>
            <h2>Consulta Virtual</h2>
        </div> 
        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget">
                            <? foreach($jogosConsultaVirtual as $jogo): ?>
                                <div class="mapas">
                                    <div class="clearfix brown-bg">
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
                                            <a href="<?=site_url()?>/mapa/verJogoCompleto?token=<?=$jogo->token?>">Ver Análise Completa por apenas R$ <?=moeda($jogo->custoCombinacoesNaoCompradas)?></a>
                                        </span>
                                    </div>
                                    <div class="clearfix">
                                        <span class="left">
                                            <b class="versalete">Data do Jogo:</b> <?= mysql_to_br($jogo->data_cadastro) ?>
                                        </span>
                                        <span class="right">
                                            <a href="<?=site_url()?>/jogo/resultado/token/<?=$jogo->token?>">Ver a Amostra Gratuita</a>
                                        </span>
                                    </div>
                                    <div class="bottom-border"></div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
    <? endif; ?>
    <? if(count($jogosAutoConsulta) > 0): ?>
        <div>
            <h2>Auto Consulta</h2>
        </div> 
        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget">
                            <? foreach($jogosAutoConsulta as $jogo): ?>
                                <div class="mapas">
                                    <div class="clearfix brown-bg">
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
                                            <a href="<?=site_url()?>/mapa/verJogoCompleto?token=<?=$jogo->token?>">Ver Análise Completa por apenas R$ <?=moeda($jogo->custoCombinacoesNaoCompradas)?></a>
                                        </span>
                                    </div>
                                    <div class="clearfix">
                                        <span class="left">
                                            <b class="versalete">Data do Jogo:</b> <?= mysql_to_br($jogo->data_cadastro) ?>
                                        </span>
                                        <span class="right">
                                            <a href="<?=site_url()?>/jogo/resultado/token/<?=$jogo->token?>">Ver a Amostra Gratuita</a>
                                        </span>
                                    </div>
                                    <div class="bottom-border"></div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
    <? endif; ?>
</div>

<script>

$(document).ready(function(){
   // adiciona os eventos
   $("span.titulo").click(clickDefinirTitulo);
   $(document).click(clickDocument);
   $("div.mapas input").keypress(keypressInput);

});

function clickDefinirTitulo(){
    // esconde o span
    $(this).hide();

    // mostra o input
    $(this).next().show().focus();
}

function clickDocument(evt){

    if($(evt.target).is("input") == false && $(evt.target).is("span.titulo") == false){

        // obtem os inputs que estejam visiveis
        var input = $("div.mapas input:visible");

        // checa se existe algum visivel
        if(input.length > 0){

            // checa se foi digitado algum valor neste input
            if($.trim(input.val()) != ""){

                // salva o valor na span
                input.prev().html(input.val()).removeClass("definir-titulo");

                // mostra o carregando
                input.next().show();

                salvarTitulo(input.val(), input.attr("cod"));

            }else{

                $("div.mapas input").hide();
                $("span.titulo").show();
            }
        }else{

            $("div.mapas input").hide();
            $("span.titulo").show();
        }
    }
}

function keypressInput(evt){
    
    // de deu enter
    if(evt.keyCode == 13){

        // checa se possui valor
        if($.trim($(this).val()) != ""){

            // salva o valor na span
            $(this).prev().html($(this).val()).removeClass("definir-titulo");

            // mostra o carregando
            $(this).next().show();

            // salva o Titulo
            salvarTitulo($(this).val(), $(this).attr("cod"));

        }else{

            $("div.mapas input").hide();
            $("span.titulo").show();
        }
            
    }
}

function salvarTitulo(titulo, cod){

    // faz o ajax
    $.ajax({
        url     : SITE_URL + "/mapa/salvarTitulo",
        data    : { titulo : titulo, cod : cod },
        type    : 'POST'
    }).done(function(data){

        $("div.mapas input, div.mapas span.loading").hide();
        $("span.titulo").show();

    });
}
</script>