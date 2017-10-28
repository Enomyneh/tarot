<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>
<div class="container">
    <div class="mensagem"><?=$mensagem?></div>
    <div><a class="button" href="<?=site_url()?>/tarot/"><< Escolher outras cartas</a></div>
    <h1>Cartas:</h1>
    <div class="clearfix">
        <div class="left">
            <p class="box">
                <label>Arcano Maior</label>
                <span>
                    <select name="arcano-maior">
                        <? foreach($arcanosMaiores as $arcano): ?>
                            <? $selected = ($arcano->cod_carta == $arcanoMaior->cod_carta) ? "selected='selected'" : "" ?>
                            <option <?=$selected?> value="<?=$arcano->cod_carta?>"><?=$arcano->nome_carta?></option>
                        <? endforeach; ?>
                    </select>
                </span>
            </p>
        </div>
        <div class="left">
            <p class="box">
                <label>Arcano Menor 1</label>
                <span>
                    <select name="arcano-menor-1">
                        <? foreach($arcanosMenores as $arcano): ?>
                            <? $selected = ($arcano->cod_carta == $arcanoMenor1->cod_carta) ? "selected='selected'" : "" ?>
                            <option <?=$selected?> value="<?=$arcano->cod_carta?>"><?=$arcano->nome_carta?></option>
                        <? endforeach; ?>
                    </select>
                </span>
            </p>
        </div>
        <div class="left">
            <p class="box">
                <label>Arcano Menor 2</label>
                <span>
                    <select name="arcano-menor-2">
                        <? foreach($arcanosMenores as $arcano): ?>
                            <? $selected = ($arcano->cod_carta == $arcanoMenor2->cod_carta) ? "selected='selected'" : "" ?>
                            <option <?=$selected?> value="<?=$arcano->cod_carta?>"><?=$arcano->nome_carta?></option>
                        <? endforeach; ?>
                    </select>
                </span>
            </p>
        </div>
        <div class="left">
            <p class="box cor-3">
                <label>Tipo de jogo</label>
                <span>
                    <select name="grupo-casa-carta">
                        <? foreach($gruposCasaCarta as $grupoCasaCarta): ?>
                            <? $selected = ($grupoCasaCarta->cod_grupo_casa_carta == $grupoCasaCartaSelecionado) ? "selected='selected'" : "" ?>
                            <option <?=$selected?> value="<?=$grupoCasaCarta->cod_grupo_casa_carta?>"><?=$grupoCasaCarta->nome_grupo_casa_carta?></option>
                        <? endforeach; ?>
                    </select>
                </span>
            </p>
        </div>
    </div>

    <div>
        <h1>Setor da Vida:</h1>
        <p class="setores-vida">
            <? foreach($setoresVida as $setorVida): ?>
                <? if($setorVida->cod_setor_vida == $setorVidaSelecionado->cod_setor_vida): ?>
                    <span class="selected"><?=$setorVida->nome_setor_vida?></span>
                <? else: ?>
                    <span><a class="button" href="javascript:void(0);" cod_setor_vida="<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></a></span>
                <? endif; ?>
            <? endforeach; ?>
        </p>
    </div>

    <div>
        <h1>Escolha a Casa:</h1>
        <p class="casas-carta-links">
            <? foreach($casasCarta as $casaCarta): ?>
                <span><a href="javascript:void(0);" class="button" cod_casa_carta="<?=$casaCarta->cod_casa_carta?>"><?=$casaCarta->nome_casa_carta?></a></span>
            <? endforeach; ?>
        </p>
    </div>
    
    <div class="box-casas-carta">
        <? foreach($casasCarta as $casaCarta): ?>
            <?  $combinacaoTexto = "";
                foreach($combinacoes as $combinacao):
                    if($combinacao->cod_casa_carta == $casaCarta->cod_casa_carta):
                        $combinacaoTexto = $combinacao->texto_combinacao;
                    endif;
                endforeach;
            ?>
            <div id="box-casa-carta-<?=$casaCarta->cod_casa_carta?>" class="box-casa-carta hidden">
                <h1>Combinação - <?=$casaCarta->nome_casa_carta?></h1>
                <div class="box-texto"><?=$combinacaoTexto?></div>
            </div>
        <? endforeach; ?>
    </div>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>

<script>

// define o base_url
var BASE_URL       = '<?=base_url();?>';
var SITE_URL       = '<?=site_url();?>';
var ARCANO_MAIOR   = <?=$arcanoMaior->cod_carta?>;
var ARCANO_MENOR_1 = <?=$arcanoMenor1->cod_carta?>;
var ARCANO_MENOR_2 = <?=$arcanoMenor2->cod_carta?>;
var GRUPO_CASA_CARTA = <?=$grupoCasaCartaSelecionado?>;
var SETOR_VIDA     = <?=$setorVidaSelecionado->cod_setor_vida?>;

$(document).ready(function(){
   // adiciona os eventos
   $(".setores-vida a").click(clickSetorVida);
   $(".casas-carta-links a").click(clickCasasCarta);
   $(".box-casas-carta a").click(editarCasaCarta);
   $("select[name=grupo-casa-carta]").change(changeGrupoCasaCarta);
   $("select[name=arcano-maior]").change(changeArcanoMaior);
   $("select[name=arcano-menor-1]").change(changeArcanoMenor1);
   $("select[name=arcano-menor-2]").change(changeArcanoMenor2);
});

function clickCasasCarta(){
    // obtem o codigo da casa carta clicada
    var codCasaCarta = $(this).attr("cod_casa_carta");
    
    // oculta todas as divs que mostram as casas cartas
    $(".box-casa-carta").hide();
    
    // mostra somente o box da casa carta clicada
    $("#box-casa-carta-"+codCasaCarta).show();
    
    // normaliza todas as classes dos links <a>
    $(".casas-carta-links a").each(function(){
        $(this).removeClass("selected").addClass("button");
    });
    
    // seta a classe do link selecionado
    $(this).removeClass("button").addClass("selected");
}

function editarCasaCarta(){
    // obtem o codigo da casa carta clicada
    var codCasaCarta = $(this).attr("cod_casa_carta");
    
    // monta a url para redirecionar para preenchimento da combinacao
    var url = SITE_URL+'/tarot/preencherCombinacao?ama='+ARCANO_MAIOR
              +'&ame1='+ARCANO_MENOR_1+'&ame2='+ARCANO_MENOR_2+'&sv='+SETOR_VIDA+'&cc='+codCasaCarta;

    // recarrega a tela com o novo setor
    window.location.href = url;
}

function clickSetorVida(){
    // obtem o codigo do setor da vida clicado
    var codSetorVida = $(this).attr("cod_setor_vida");
    
    // monta a url para trocar o setor da vida
    var url = SITE_URL+'/tarot/escolherCasa?ama='+ARCANO_MAIOR
              +'&ame1='+ARCANO_MENOR_1+'&ame2='+ARCANO_MENOR_2+'&sv='+codSetorVida
              +'&gcc='+GRUPO_CASA_CARTA;
          
    // recarrega a tela com o novo setor
    window.location.href = url;
}

function changeGrupoCasaCarta(){
    // obtem o codigo do setor da vida clicado
    var codGrupoCasaCarta = $(this).val();
    
    // monta a url para trocar o setor da vida
    var url = SITE_URL+'/tarot/escolherCasa?ama='+ARCANO_MAIOR
              +'&ame1='+ARCANO_MENOR_1+'&ame2='+ARCANO_MENOR_2+'&sv='+SETOR_VIDA
              +'&gcc='+codGrupoCasaCarta;
          
    // recarrega a tela com o novo setor
    window.location.href = url;
}
function changeArcanoMaior(){
    var codArcanoMaior = $(this).val();
    
    // monta a url para trocar o setor da vida
    var url = SITE_URL+'/tarot/escolherCasa?ama='+codArcanoMaior
              +'&ame1='+ARCANO_MENOR_1+'&ame2='+ARCANO_MENOR_2+'&sv='+SETOR_VIDA
              +'&gcc='+GRUPO_CASA_CARTA;
          
    // recarrega a tela com o novo setor
    window.location.href = url;
}
function changeArcanoMenor1(){
    var codArcanoMenor1 = $(this).val();
    
    // monta a url para trocar o setor da vida
    var url = SITE_URL+'/tarot/escolherCasa?ama='+ARCANO_MAIOR
              +'&ame1='+codArcanoMenor1+'&ame2='+ARCANO_MENOR_2+'&sv='+SETOR_VIDA
              +'&gcc='+GRUPO_CASA_CARTA;
          
    // recarrega a tela com o novo setor
    window.location.href = url;
}
function changeArcanoMenor2(){
    var codArcanoMenor2 = $(this).val();
    
    // monta a url para trocar o setor da vida
    var url = SITE_URL+'/tarot/escolherCasa?ama='+ARCANO_MAIOR
              +'&ame1='+ARCANO_MENOR_1+'&ame2='+codArcanoMenor2+'&sv='+SETOR_VIDA
              +'&gcc='+GRUPO_CASA_CARTA;
          
    // recarrega a tela com o novo setor
    window.location.href = url;
}

</script>
    
</body>
</html>