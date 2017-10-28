<style type="text/css">
  #container {
    width: 100%;
    height: 60px;
    position: relative;
  }
  #wrapper > #container {
    display: table;
    position: static;
  }
  #container div {
    position: absolute;
    top: 50%;
  }
  #container div div {
    position: relative;
    top: -50%;
  }
  #container > div {
    display: table-cell;
    vertical-align: top;
    position: static;
  }
  #btnSubmit {
    width: 239px;
    display: inline-block;
    text-align: center;
  }
  div.new-casas span {
    display: inline-block;
    background-color: rgba(91,155,213,100);
    width: 84px;
    margin: 10px;
    padding: 20px;
    color: white;
    font-size: 16px;
    line-height: 29px;
    text-align: center;
    height: 145px;
    border: 2px solid rgba(65,113,156,100);
    border-radius: 10px;
    cursor: pointer;
    vertical-align: top;
  }
  div.new-casas label {
    display: inline-block;
    margin-top: 12px;
    cursor: pointer;
  }
  label.ja-escolhida {
    height: 116px;
  }
</style>

<!--<div class="monografia vertical-tab">-->
<!--    <div class="sumario">-->
<!--        <span class="n1 ativo" detalhe="capa">&Iacute;nicio</span>-->
<!--        <span class="n1" detalhe="teste">Teste</span>-->
<!--    </div>-->
<!--    <div detalhe="capa" class="itens">CAPA CAPA CAPA CAPA CAPA CAPA CAPA CAPA </div>-->
<!--    <div detalhe="teste" class="itens" style="display: none;">teste teste teste teste teste teste teste teste teste teste </div>-->
<!--</div>-->

    <form action="<?=site_url("jogo/verSetor")?>">

    <p class="sub-title versalete" style="font-size: 28px;">
        Autoconsulta
    </p>

    <div>
        <? if($profissional == 1): ?>
          <p class="justify">Já possui um baralho? Precisa de significados prontos? Monte o seu jogo escolhendo um setor abaixo, selecione as cartas e em seguida veja a resposta nas páginas seguintes.</p>
          <br/><br/>
      <? else: ?>
            <p><b><?= Auth::getData("nome"); ?></b>, Seja bem vindo à consulta virtual online.</p>
            <p class="justify">Voce esta em uma área de consulta virtual à taromancia. Há dez setores da vida para fazer o mapeamento. Concentre-se sobre uma area de sua vida, escolha o setor abaixo e realize a consulta.</p>
      <? endif; ?>
    </div>

    <div class="big-widget">
        <div class="widget">
            <div class="widget-bottom">
                <div class="widget-content">
                    <div class="textwidget extrato">
                        <div id="wrapper">
                            <div id="container">
                                <div class="clearfix">
                                  <div style="float: left;">
                                    <div>
                                        <img src="<?=base_url()?>/assets/images/autoconsulta.png"/>
                                    </div>
                                   </div>
                                  <div style="float: right;">
                                      <div style="padding: 10px;">
                                        <div class='new-casas'>
                                            <span class="new-casa-1" casa="1">
                                                <label class="escolha">Clique aqui e escolha a sua carta</label>
                                                <label class="ja-escolhida" style="display: none">Carta já escolhida!</label>
                                            </span>
                                            <span class="new-casa-2" casa="2">
                                                <label class="escolha">Clique aqui e escolha a sua carta</label>
                                                <label class="ja-escolhida" style="display: none">Carta já escolhida!</label>
                                            </span>
                                            <span class="new-casa-3" casa="3">
                                                <label class="escolha">Clique aqui e escolha a sua carta</label>
                                                <label class="ja-escolhida" style="display: none">Carta já escolhida!</label>
                                            </span>
                                        </div>
                                      </div>
                                  </div>  
                                </div>
                            </div>
                          </div>
                      </div>
                </div> <!-- end .widget-content-->
            </div> <!-- end .widget-bottom-->
        </div>
    </div>

    <div>
        <h2 class="versalete" style="font-size: 18px;">Setores Da Vida</h2>
        <div style="display: inline-block; width: 50%">
            <select name="sv" style="width: 100%;">
              <option selected="selected" value="">Escolha o setor</option>
              <? foreach($setoresVida as $setorVida): ?>
                  <option value="<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></option>
              <? endforeach; ?>
            </select>
        </div>

        <div style="display: inline-block; width: 49%">
            <div id="submit" class="tMargin10" style="padding-left: 10px; text-align: center;">
                <a id="btnSubmit" class="newBlueButton"><span>Avan&ccedil;ar</span></a>
            </div>
        </div>
            

          <input type="hidden" name="p" value="<?=$profissional?>"/>
          <input type="hidden" name="cuc" value="<?=$codUsuarioCombinacao?>"/>
    </div>
</form>

        <? if(count($jogosConsultaVirtual) > 0): ?>
        <br/>
        <br/>
        <div>
            <h2 class="versalete">Consultas Realizadas</h2>
        </div> 
        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget">
                            <? foreach($jogosConsultaVirtual as $jogo): ?>
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
<div id="dialog-cartas"></div>
<form id="frm-resultado" method="POST" action="<?=site_url("/tarot/verResultado")?>">
    <input type="hidden" name="casas-preenchidas"/>
    <input type="hidden" name="setor-vida" value="<?=$setorVida->cod_setor_vida?>"/>
</form>
<script>
// array para armazenar as casas preenchidas
var casasPreenchidas = [];

var QTDE_CASAS = 3;

$("document").ready(function(){

    // adiciona os eventos
    $("span.titulo").click(clickDefinirTitulo);
    $(document).click(clickDocument);
    $("div.mapas input").keypress(keypressInput);

    // $("#btnSubmit").click(function(){

    //     if($("select[name=sv]").val() == "" || $("select[name=sv]").val() == "Selecione"){
    //         alert("Erro: Escolha o setor da vida");

    //         return false;
    //     }

    //     $("form").submit();
    // });

    // seta o evento de click no ver resultado
    $("#btnSubmit").click(clickVerResultado);
    
    // seta o evento de click nas cartas
    $("div.new-casas span").click(function()
    {
        // obtem a casa clicada
        var casa = $(this).attr("casa");
        
        // declara as variaveis necessarias
        var combinacaoAtual = "", codCasaP = 0;
        
        // checa se ja possui combinacao preenchida
        for(var i=0; i<casasPreenchidas.length; i++){
            // slipta a string e obtem o primeiro
            codCasaP = casasPreenchidas[i].split("#")[0];
        
            // checa se eh a mesma casa
            if(codCasaP == casa){
                // salva a combinacao atual
                combinacaoAtual = casasPreenchidas[i];
            }
        }
        
        // troca # por -
        combinacaoAtual = combinacaoAtual.replace(/#/g,"-");
        
        // carrega o ajax
        $("#dialog-cartas").load("<?=site_url("carta/escolher?casa=");?>"+casa+"&cA="+combinacaoAtual)
           .dialog({
               title: "Casa "+casa,
               width: 700,
               height: 420,
               modal: true,
               dialogClass : "dialog",
               close: function(){ $("#dialog-cartas").html("").dialog("destroy") }
           });
    });

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

$("span[detalhe]").click(function(){

    var codDetalhe = $(this).attr("detalhe");

    $("div.itens:visible").fadeOut(400, function(){

        $("div[detalhe="+codDetalhe+"]").fadeIn();
    });

    $(".sumario span").removeClass("ativo");

    $(this).addClass("ativo");

});

function clickVerResultado(){

    // checa se existe pelo menos uma casa preenchida
    if(casasPreenchidas.length < QTDE_CASAS){
        alert("Preencha as "+ QTDE_CASAS +" casas para poder visualizar o resultado!");
        return false;
    }

    if($("select[name=sv]").val() == "" || $("select[name=sv]").val() == "Selecione")
    {
        alert("Erro: Escolha o setor da vida");

        return false;
    }
    
    // salva as casas preenchidas no input
    $("input[name=casas-preenchidas]").val(casasPreenchidas);
    $("input[name=setor-vida]").val($("select[name=sv]").val());
    
    // posta o form
    $("#frm-resultado").submit();
}

</script>