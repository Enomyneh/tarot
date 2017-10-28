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
            <? for($i=0; $i<5; $i++): ?>
                <div class="casas">
                    <label>Casa <?=($i+1)?></label>
                    <span id="c1-<?=$i+1?>" class="c-1 hidden" style="left: <?=392+127*$i?>px;"></span>
                    <span id="c2-<?=$i+1?>" class="c-2 hidden" style="left: <?=392+127*$i?>px;"></span>
                    <span id="c3-<?=$i+1?>" class="c-3 hidden" style="left: <?=392+127*$i?>px;"></span>
                </div>
            <? endfor; ?>
        </div>
    </div>
    <div class="tMargin20 tCenter clearfix">
        <a class="newGreenButton" href="<?=site_url()?>/jogo/escolherCartas?sv=<?=$setorVida?>&p=">
            <span>Come&ccedil;ar de novo</span>
        </a>
        <a id="btnAleatorio" class="newGreenButton lMargin80">
            <span>Escolher aleatoriamente</span>
        </a>
        <a id="btn-ver-resultado" class="newGreenButton lMargin80" href="<?=site_url()?>/jogo/montar/?sv=<?=$setorVida?>">
            <span>Ver resultado</span>
        </a>
    </div>
</div>
<script>

var QTDE_CASAS = 5;

function getRandomInt(min, max){
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
$("document").ready(function(){
    
    var COUNT_ARCANO_MAIOR = 0;
    var COUNT_ARCANO_MENOR = 0;

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
            top: "190px"
        }, 100);
    }, function(){
        $(this).animate({
            top: "200px"
        }, 100);
    });
    
    $("div.cartas-2 span").hover(function(){
        $(this).animate({
            top: "335px"
        }, 100);
    }, function(){
        $(this).animate({
            top: "345px"
        }, 100);
    });
    
    $("div.cartas-3 span").hover(function(){
        $(this).animate({
            top: "445px"
        }, 100);
    }, function(){
        $(this).animate({
            top: "450px"
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
});
</script>