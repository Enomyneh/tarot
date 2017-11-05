<p class="sub-title versalete" style="font-size: 28px;">
    Consulta Virtual
</p>

<div>
    <p><b><?= Auth::getData("nome"); ?></b>, Seja bem vindo à consulta virtual online.</p>
    <p class="justify">Voce esta em uma área de consulta virtual à taromancia. Há dez setores da vida para fazer o mapeamento. Concentre-se sobre uma area de sua vida, escolha o setor abaixo e realize a consulta.</p>
</div>
<div>
    <div class="div-border">
        <div class="tCenter"><b>Arcanos Maiores</b></div>
        <div class="cartas-1">
            <? for($i=0; $i<22; $i++): ?>
                <span class="ama" style="z-index: <?=(30-$i)?>; left: <?=(370+(25*($i)))?>px;"></span>
            <? endfor; ?>
        </div>
    </div>
    <div class="div-border tMargin10">
        <div class="tCenter"><b>Arcanos Menores</b></div>
        <div class="cartas-2">
            <? for($i=0; $i<28; $i++): ?>
                <span class="ame" style="z-index: <?=(30-$i)?>; left: <?=(370+(20*($i)))?>px;"></span>
            <? endfor; ?>
        </div>
        <div class="cartas-3">
            <? for($i=0; $i<28; $i++): ?>
                <span class="ame" style="z-index: <?=(30-$i)?>; left: <?=(370+(20*($i)))?>px;"></span>
            <? endfor; ?>
        </div>
    </div>
    <div class="div-border tMargin10 tCenter" style="background-color: #D6FFBF; padding-bottom: 10px;'">
        <div class="tCenter"><b>Cartas Selecionadas</b></div>
        <div class="cartas-selecionas">
            <? for($i=0; $i<3; $i++): ?>
                <div class="casas">
                    <label>Casa <?=($i+1)?></label>
                    <span id="c1-<?=$i+1?>" class="c-1 hidden" style="left: <?=522+127*$i?>px;"></span>
                    <span id="c2-<?=$i+1?>" class="c-2 hidden" style="left: <?=522+127*$i?>px;"></span>
                    <span id="c3-<?=$i+1?>" class="c-3 hidden" style="left: <?=522+127*$i?>px;"></span>
                </div>
            <? endfor; ?>
        </div>
    </div>
    <div class="tMargin20 tCenter clearfix">
        <a class="newBlueButton" href="<?=site_url()?>/jogo/consultaVirtual">
            <span>Come&ccedil;ar de novo</span>
        </a>
        <a id="btnAleatorio" class="newBlueButton lMargin80">
            <span>Escolher aleatoriamente</span>
        </a>
    </div>
    <div>
        <form action="<?=site_url("jogo/verSetor")?>">
            <h2 class="versalete" style="font-size: 18px;">Setores Da Vida</h2>
            <div style="display: inline-block; width: 50%">
                <select name="sv" style="width: 100%;">
                  <option selected="selected" value="">Escolha o setor</option>
                  <? foreach($setoresVida as $setorVida): ?>
                      <option value="<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></option>
                  <? endforeach; ?>
                </select>
            </div>

            <div style="display: inline-block; width: 11%">
                <div id="submit" class="tMargin10" style="padding-left: 10px; text-align: center;">
                    <a id="btnSubmit" class="newBlueButton"><span>Avan&ccedil;ar</span></a>
                </div>
            </div>

            <input type="hidden" name="p" value="<?=$profissional?>"/>
            <input type="hidden" name="cuc" value="<?=$codUsuarioCombinacao?>"/>
            <input type="hidden" name="setor-vida" value=""/>
        </form>
    </div>
</div>
<?
$this->load->view('div_consultas_realizadas', array(
    'jogosConsultaVirtual' => $jogosConsultaVirtual,
    'jogosAutoConsulta' => $jogosAutoConsulta
))
?>
<script>

var COUNT_ARCANO_MAIOR = 0;
var COUNT_ARCANO_MENOR = 0;
var QTDE_CASAS = 3;

function getRandomInt(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
$("document").ready(function(){

    $("span.titulo").click(clickDefinirTitulo);

    $(document).click(clickDocument);

    // seta o evento de click no ver resultado
    $("#btnSubmit").click(clickVerResultado);

    $("#btn-ver-resultado").click(function(evt){
        evt.preventDefault();

        if(COUNT_ARCANO_MAIOR < 5 || COUNT_ARCANO_MENOR < 10){
            alert("Erro: Preencha todas as cartas para poder visualizar o resultado!");
            return false;
        }

        window.location.href = $(this).attr("href");
    });
    
    $("#btnAleatorio").click(function(){
        COUNT_ARCANO_MAIOR = 10;
        COUNT_ARCANO_MENOR = 20;
        
        var randoms = [];
        
        // obtem os arcanos maiores
        var arcMaiores = $("div.cartas-1 span");
        
        // mostra todos arcanos maiores
        $(arcMaiores).show();
        
        // esconde as cartas selecionadas
        $("div.cartas-selecionas span").hide();
        
        // escolhe 5 numeros aleatorios de 0 a 21
        for(var i=0; i< QTDE_CASAS; i++){
            var a = getRandomInt(0,21);
            
            while($.inArray(a, randoms) != -1){
                a = getRandomInt(0,21);
            }
            
            randoms.push(a);
            
            $(arcMaiores[a]).fadeOut();
        }
        
        // mostra todos arcmaiores selecionados
        $("div.cartas-selecionas span.c-1").fadeIn();
        
        // gasta um tempo pra mostrar os menores
        setTimeout(function(){
            
            // obtem os arcanos MENORES
            var arcMenores = $("div.cartas-2 span, div.cartas-3 span");
            
            // mostra todos
            $(arcMenores).show();
            
            randoms = [];
            
            // escolhe 10 numeros aleatorios de 0 a 55
            for(var i=0; i< (QTDE_CASAS*2) ; i++){
                var a = getRandomInt(0,55);

                while($.inArray(a, randoms) != -1){
                    a = getRandomInt(0,55);
                }

                randoms.push(a);

                $(arcMenores[a]).fadeOut();
            }
            
            // mostra todos arcMENORES selecionados
            $("div.cartas-selecionas span.c-2, div.cartas-selecionas span.c-3").fadeIn();
            
        }, 500);
    });
    
    $("div.cartas-1 span").hover(function(){
        $(this).animate({
            top: "480px"
        }, 100);
    }, function(){
        $(this).animate({
            top: "490px"
        }, 100);
    });
    
    $("div.cartas-2 span").hover(function(){
        $(this).animate({
            top: "625px"
        }, 100);
    }, function(){
        $(this).animate({
            top: "635px"
        }, 100);
    });
    
    $("div.cartas-3 span").hover(function(){
        $(this).animate({
            top: "730px"
        }, 100);
    }, function(){
        $(this).animate({
            top: "740px"
        }, 100);
    });
    
    $("div.cartas-1 span, div.cartas-2 span, div.cartas-3 span").click(function(){

        if($("div.cartas-1 span, div.cartas-2 span, div.cartas-3 span").is(":animated")){
            return false;
        }

        if($(this).hasClass("ama")){
           
           if(COUNT_ARCANO_MAIOR >= QTDE_CASAS){
               alert("Erro: Já foram escolhidos todos os Arcanos Maiores para seu jogo.");
               
               return false;
           }
            
           COUNT_ARCANO_MAIOR++;
           
           
           $(this).fadeOut(100, function(){
               $("#c1-"+COUNT_ARCANO_MAIOR).fadeIn(100);
           });
           
        }else{
            
            if(COUNT_ARCANO_MENOR >= QTDE_CASAS*2){
                alert("Erro: Já foram escolhidos todos os Arcanos Menores para seu jogo.");
               
               return false;
            }
            
            COUNT_ARCANO_MENOR++;
            
            var carta = "";
            var casa = "";
            
            if(COUNT_ARCANO_MENOR % 2 == 1){
                carta = "c2";
            }else{
                carta = "c3";
            }
            
            casa = Math.ceil(COUNT_ARCANO_MENOR / 2);
            
            $(this).fadeOut(100, function(){
               $("#"+carta+"-"+casa).fadeIn(100);
           });
        }
    });
    
    // seta o evento de change do select
    $("select[name=sv]").change(function(){
        // obtem o id do setor selecionado
        var codSetor = $(this).val();
        
        // esconde todas as descricoes
        $("#descricao-setor-vida div").hide();
        
        // mostra o cabecalho e a descricao selecionada
        $("#descricao-setor-vida, #descricao-"+codSetor).fadeIn();

        // mostra o botao para avancar
        $("#submit").fadeIn();
    });

    $("span[detalhe]").click(function(){

        var codDetalhe = $(this).attr("detalhe");

        $("div.itens:visible").fadeOut(400, function(){

            $("div[detalhe="+codDetalhe+"]").fadeIn();
        });

        $(".sumario span").removeClass("ativo");

        $(this).addClass("ativo");
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

function keypressInput(evt)
{
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

function clickVerResultado()
{
    if($("select[name=sv]").val() == "" || $("select[name=sv]").val() == "Selecione")
    {
        alert("Erro: Escolha o setor da vida");

        return false;
    }

    if(COUNT_ARCANO_MAIOR < 5 || COUNT_ARCANO_MENOR < 10)
    {
        alert("Erro: Preencha todas as cartas para poder visualizar o resultado!");
        return false;
    }
    
    $("input[name=setor-vida]").val($("select[name=sv]").val());
    
    // posta o form
    $("form").submit();
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