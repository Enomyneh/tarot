<h2>Resultado</h2>
<div>
    <span>Setor da vida: </span>
    <span><?=$casasPreenchidas[$firstKey]["setorVida"]->nome_setor_vida?></span><br/>
    <span>Descrição do Setor da Vida: </span>
    <span><?=$casasPreenchidas[$firstKey]["setorVida"]->descricao?></span>
</div>
<? foreach($casasPreenchidas as $key => $casa): ?>
    <? $class = ($key == $firstKey) ? "" : "hidden" ?>
    <div class="<?=$class?>" id="div-casa-<?=$casa["casaCarta"]->cod_casa_carta?>">
        <div class="clearfix">
            <span class="left"><input class="greenButton" type="button" name="casa-anterior" value="Casa anterior" casa="<?=$casa["casaCarta"]->cod_casa_carta?>"/></span>
            <span class="right"><input class="greenButton" type="button" name="proxima-casa" value="Pr&oacute;xima casa"  casa="<?=$casa["casaCarta"]->cod_casa_carta?>"/></span>
        </div>
        <h2><?=$casa["casaCarta"]->nome_casa_carta?></h2>
        <div class="tCenter">
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
        <h2>Resultado</h2>
        <div><?=@$casa["resultado"]->texto_combinacao?></div>
    </div>
<? endforeach; ?>
<script>
$(document).ready(function(){
    var DIV_CASA = [
        <? foreach($casasPreenchidas as $casa): ?>
            <?=$casa["casaCarta"]->cod_casa_carta?>,
        <? endforeach; ?>
    ];
    
    $("input[name=casa-anterior]").click(clickCasaAnterior);
    $("input[name=proxima-casa]").click(clickProxCasa);

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
    }
});
</script>