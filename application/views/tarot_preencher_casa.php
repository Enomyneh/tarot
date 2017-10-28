<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/js/jquery-ui-1.9.1.custom/css/smoothness/jquery-ui-1.9.1.custom.min.css" />
</head>
<body>
<div id="container">
    <div id="mensagem"><?=$mensagem?></div>
    <div><a href="<?=site_url()?>/tarot/">Escolher outras cartas</a></div>
    <form action="<?=site_url()?>/tarot/doPreencherCombinacao" method="POST">
        <h1>Cartas:</h1>
        <div class="clearfix">
            <div class="left">
                <p>
                    <label class="subtitle">Arcano Maior:</label>
                    <span><?=$arcanoMaior->nome_carta?></span>
                    <input type="hidden" name="arcano-maior" value="<?=$arcanoMaior->cod_carta?>"/>
                </p>
            </div>
            <div class="left">
                <p>
                    <label class="subtitle">Arcano Menor 1:</label>
                    <span><?=$arcanoMenor1->nome_carta?></span>
                    <input type="hidden" name="arcano-menor-1" value="<?=$arcanoMenor1->cod_carta?>"/>
                </p>
            </div>
            <div class="left">
                <p>
                    <label class="subtitle">Arcano Menor 2:</label>
                    <span><?=$arcanoMenor2->nome_carta?></span>
                    <input type="hidden" name="arcano-menor-2" value="<?=$arcanoMenor2->cod_carta?>"/>
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
                        <span><a href="javascript:void(0);" cod_setor_vida="<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></a></span>
                    <? endif; ?>
                <? endforeach; ?>
            </p>
            <input type="hidden" name="setor-vida" value="<?=$setorVidaSelecionado->cod_setor_vida?>"/>
        </div>
        
        <div>
            <h1>Escolha a Casa:</h1>
            <p class="casas-carta">
                <? foreach($casasCarta as $casaCarta): ?>
                    <?  $combinacaoTexto = ""; $combinacaoCod = "";
                        foreach($combinacoes as $combinacao):
                            if($combinacao->cod_casa_carta == $casaCarta->cod_casa_carta):
                                $combinacaoTexto = $combinacao->texto_combinacao;
                                $combinacaoCod = $combinacao->cod_combinacao;
                            endif;
                        endforeach;
                    ?>
                    <span>
                        <span><a href="javascript:void(0);" cod_casa_carta="<?=$casaCarta->cod_casa_carta?>"><?=$casaCarta->nome_casa_carta?></a></span>
                        <input type="hidden" name="nome-casa-carta-<?=$casaCarta->cod_casa_carta?>" value="<?=$casaCarta->nome_casa_carta?>"/>
                        <input type="hidden" name="combinacao-casa-carta-<?=$casaCarta->cod_casa_carta?>" value="<?=$combinacaoTexto?>"/>
                        <input type="hidden" name="combinacao-cod-casa-carta-<?=$casaCarta->cod_casa_carta?>" value="<?=$combinacaoCod?>"/>
                    </span>
                <? endforeach; ?>
            </p>
        </div>
        
        <div>
            <input type="hidden" name="setor-vida-redirecionar"/>
            <input type="submit" value="Salvar combinações"/>
        </div>
        
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-ui-1.9.1.custom/jquery-ui-1.9.1.custom.min.js"></script>

<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.colors.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.styles.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.syntax.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/xhtml.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.min.js" type="text/javascript"></script>


<script>

// define o base_url
var BASE_URL = '<?=base_url();?>';
var SITE_URL = '<?=site_url();?>';

$(document).ready(function(){
   
   // adiciona os eventos
   $(".setores-vida a").click(clickSetorVida);
   $(".casas-carta a").click(clickCasasCarta);
   
});

function clickCasasCarta(){
    // obtem o codigo da casa carta clicada
    var codCasaCarta = $(this).attr("cod_casa_carta");
    
    // monta o objeto com os dados
    var data = {
        nome_casa_carta       : $("input[name=nome-casa-carta-"+codCasaCarta+"]").val(),
        combinacao_casa_carta : $("input[name=combinacao-casa-carta-"+codCasaCarta+"]").val(),
    };
    
    // gera um id dinamico
    var randomID = "div_"+Math.round(Math.random()*10000);
    
    // gera uma div para receber os dados
    var newDiv = "<div id='"+randomID+"'></div>";
    
    // acrescenta no body
    $("body").append(newDiv);
    
    // obtem o container
    ACTIVE_DIALOG = $('#'+randomID);
    
    // carrega os dados no container via ajax
    ACTIVE_DIALOG.load(
        SITE_URL+"/tarot/preencherCasa",
        data
    );
    
    // abre o dialog
    ACTIVE_DIALOG.dialog({
        width   : 700,
        height  : 500,
        modal   : true,
        close   : fecharDialog
    });
}

function clickSetorVida(){
    // obtem o codigo do setor da vida clicado
    var codSetorVida = $(this).attr("cod_setor_vida")
    
    // salva o setor da vida clicado no input
    $("input[name=setor-vida-redirecionar]").val(codSetorVida);
    
    // executa o submit do formulario
    $("form").submit();
}

function fecharDialog(){
    alert("ok");
}


</script>
    
</body>
</html>