<div class="dialog-cartas">
    <div id="carregando" class="hidden">Carregando...</div>
    <div class="carta-escolher">
        <select name="arcano-maior" style="width: 150px; font-size: 10px; padding: 6px;">
            <? if(!is_numeric($arcMaiorAtual) || $arcMaiorAtual<=0): ?>
                <option value="0" selected="selected">Arcano-maior:</option>
            <? endif; ?>
            <? foreach($arcanosMaiores as $arcanoMaior): ?>
                <? $selected = ($arcMaiorAtual == $arcanoMaior->cod_carta) ? "selected='selected'" : ""; ?>
                <option <?=$selected?> value="<?=$arcanoMaior->cod_carta?>"><?=$arcanoMaior->nome_carta?></option>
            <? endforeach; ?>
        </select>
        <span class="carta-imagem">
            <? if(is_numeric($arcMaiorAtual) && $arcMaiorAtual >= 0): ?>
                <img src="<?=base_url()?>assets/images/cartas/<?=$arcMaiorAtual?>.jpg" width="150" height="262"/>
            <? endif; ?>
        </span>
    </div>
    <div class="carta-escolher">
        <select name="arcano-menor-1" style="width: 150px; font-size: 10px; padding: 6px;">
            <? if(!is_numeric($arcMenor1Atual) || $arcMenor1Atual<=0): ?>
                <option value="0" selected="selected">Arcano-menor 1:</option>
            <? endif; ?>
            <? foreach($arcanosMenores as $arcanoMenor): ?>
                <? $selected = ($arcMenor1Atual == $arcanoMenor->cod_carta) ? "selected='selected'" : ""; ?>
                <option <?=$selected?> value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
            <? endforeach; ?>
        </select>
        <span class="carta-imagem">
            <? if(is_numeric($arcMenor1Atual) && $arcMenor1Atual >= 0): ?>
                <img src="<?=base_url()?>assets/images/cartas/<?=$arcMenor1Atual?>.jpg" width="150" height="262"/>
            <? endif; ?>
        </span>
    </div>
    <div class="carta-escolher">
        <select name="arcano-menor-2" style="width: 150px; font-size: 10px; padding: 6px;">
            <? if(!is_numeric($arcMenor2Atual) || $arcMenor2Atual<=0): ?>
                <option value="0" selected="selected">Arcano-menor 2:</option>
            <? endif; ?>
            <? foreach($arcanosMenores as $arcanoMenor): ?>
                <? $selected = ($arcMenor2Atual == $arcanoMenor->cod_carta) ? "selected='selected'" : ""; ?>
                <option <?=$selected?> value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
            <? endforeach; ?>
        </select>
        <span class="carta-imagem">
            <? if(is_numeric($arcMenor2Atual) && $arcMenor2Atual >= 0): ?>
                <img src="<?=base_url()?>assets/images/cartas/<?=$arcMenor2Atual?>.jpg" width="150" height="262"/>
            <? endif; ?>
        </span>
    </div>
    <div class="tCenter">
        <? $class = (is_numeric($arcMaiorAtual) && $arcMaiorAtual >= 0) ? "" : "hidden"; ?>
        <input type="button" name="escolher" class="<?=$class?> newBlueButton tMargin20" value="Escolher"/>
    </div>
    <div id="comprar-combinacao" class="tCenter tMargin20 hidden">
        <input type="button" name="comprar" class="newBlueButton" value="Comprar"/>
    </div>
    <div class="tCenter div-erro hidden tMargin20"></div>
    <input type="hidden" id="casa-cod" value="<?=$casaCod?>" />
</div>
<script>
var FIRST_CHANGE = {
    "arcanoMaior" : true,
    "arcanoMenor1" : true,
    "arcanoMenor2" : true
};

$(document).ready(function(){
   // adiciona os eventos
   $("select").change(changeSelect);
   $("input[name=escolher]").click(clickEscolher);
});

function changeSelect(){
    // obtem o select
    var select = $(this);
    
    // carrega a imagem
    loadImage(select);
    
    // checa a disponibilidade
    checkDisponibilidade();
    
    // remove o option default (se necessario)
    removeDefaultValue(select);
}

function checkDisponibilidade(){
    // checa se todas as cartas foram selecionadas
    var arcMaior = $("select[name=arcano-maior]");
    var arcMenor1 = $("select[name=arcano-menor-1]");
    var arcMenor2 = $("select[name=arcano-menor-2]");
    
    if(arcMaior.val() == 0 || arcMenor1.val() == 0 || arcMenor2.val() == 0){
        return false;
    }

    // nao checa mais apenas mostra
    $("input[name=escolher]").show();
}

function loadImage(select){
    // obtem o codigo da imagem
    var cod = select.val();
    
    // carrega a imagem
    select.parent()
           .find("span.carta-imagem")
           .html("<img src=\"<?=base_url()?>assets/images/cartas/"+cod+".jpg\" width=\"150\" height=\"262\"/>");
}

function clickEscolher(){
    // obtem os codigos das cartas
    var codArcanoMaior = $("select[name=arcano-maior]").val();
    var codArcanoMenor1 = $("select[name=arcano-menor-1]").val();
    var codArcanoMenor2 = $("select[name=arcano-menor-2]").val();
    
    // valida as selecoes
    if(codArcanoMaior == "0"){
        alert("Escolha um arcano maior valido!");
        return false;
    }
    if(codArcanoMenor1 == "0"){
        alert("Escolha o arcano menor 1!");
        return false;
    }
    if(codArcanoMenor2 == "0"){
        alert("Escolha o arcano menor 2!");
        return false;
    }
    if(codArcanoMenor1 == codArcanoMenor2){
        alert("O arcano menor 1 deve ser diferente do arcano menor 2!");
        return false;
    }
    
    // obtem o codigo da casa
    var casaCod = $("#casa-cod").val();
    
    // declara as variaveis necessarias
    var codCasaP = 0, codArcMaiorP = 0, codArcMenor1P = 0, codArcMenor2P = 0;
    
    // percorre as combinacoes ja preenchidas
    for(var i=0; i<casasPreenchidas.length; i++){
        // slipta a string
        var arr = casasPreenchidas[i].split("#");
        
        // obtem os dados
        codCasaP = arr[0]; codArcMaiorP = arr[1]; codArcMenor1P = arr[2]; codArcMenor2P = arr[3];
        
        // checa se eh a mesma casa
        if(codCasaP == casaCod){
            // remove a casa do array
            casasPreenchidas.splice(i,1);
        }
    }

    for(var i=0; i<casasPreenchidas.length; i++){
        // slipta a string
        var arr = casasPreenchidas[i].split("#");
        
        // obtem os dados
        codCasaP = arr[0]; codArcMaiorP = arr[1]; codArcMenor1P = arr[2]; codArcMenor2P = arr[3];

        // checa se ja foi usado este arcano maior
        if(codArcanoMaior == codArcMaiorP){
            alert("Este arcano maior já foi escolhido na casa "+codCasaP+". Escolha outro!");
            return false;
        }
        if(codArcanoMenor1 == codArcMenor1P){
            alert("Este arcano menor 1 já foi escolhido na casa "+codCasaP+". Escolha outro!");
            return false;
        }
        if(codArcanoMenor2 == codArcMenor2P){
            alert("Este arcano menor 2 já foi escolhido na casa "+codCasaP+". Escolha outro!");
            return false;
        }
        // checa se a combinacao ja existe em outra casa
        if(codArcanoMaior == codArcMaiorP && codArcanoMenor1 == codArcMenor1P && codArcanoMenor2 == codArcMenor2P){
            alert("Esta combinacao ja foi escolhida na casa "+codCasaP+". Escolha outra combinacao!");
            return false;
        }
    }
    
    // monta a string para salvar no array de casas preenchidas
    var str = casaCod+"#"+codArcanoMaior+"#"+codArcanoMenor1+"#"+codArcanoMenor2;
    
    // salva a combinacao no array
    casasPreenchidas.push(str);
    
    // add a classe de casa preenchida
    $("span.new-casa-"+casaCod)
        .addClass("casa-preenchida")
        .find("label.escolha").hide().end()
        .find("label.ja-escolhida").show().end();
    
    // fecha o dialog
    $("#dialog-cartas").dialog("close").html("");
    
    return true;
}

function removeDefaultValue(select){
    // checa se eh o primeiro change de cada select
    if(select.attr("name") == "arcano-maior"){
        if(FIRST_CHANGE.arcanoMaior){
            select.find("option[value=0]").remove();
            FIRST_CHANGE.arcanoMaior = false;
        }
    }
    if(select.attr("name") == "arcano-menor-1"){
        if(FIRST_CHANGE.arcanoMenor1){
            select.find("option[value=0]").remove();
            FIRST_CHANGE.arcanoMenor1 = false;
        }
    }
    if(select.attr("name") == "arcano-menor-2"){
        if(FIRST_CHANGE.arcanoMenor2){
            select.find("option[value=0]").remove();
            FIRST_CHANGE.arcanoMenor2 = false;
        }
    }
    
    return true;
}
</script>