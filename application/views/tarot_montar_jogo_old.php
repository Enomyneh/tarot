<div class="montar-jogo">
    <h2 style="margin-top: 0px;">Escolha as cartas de cada casa</h2>
    <div class="casas clearfix">
        <span class="casa-1" casa="1"><label>Casa<br/>1</label></span>
        <span class="casa-2" casa="2"><label>Casa<br/>2</label></span>
        <span class="casa-3" casa="3"><label>Casa<br/>3</label></span>
        <span class="casa-4" casa="4"><label>Casa<br/>4</label></span>
        <span class="casa-5" casa="5"><label>Casa<br/>5</label></span>
        <!--<span class="casa-6" casa="6"><label>Casa<br/>6</label></span>
        <span class="casa-7" casa="7"><label>Casa<br/>7</label></span>
        <span class="casa-8" casa="8"><label>Casa<br/>8</label></span>
        <span class="casa-9" casa="9"><label>Casa<br/>9</label></span>
        <span class="casa-10" casa="10"><label>Casa<br/>10</label></span> -->
    </div>
    <div>
        <label class="ver-resultado"><a class="newGreenButton ver-resultado"><span>VER RESULTADO</span></a></label>
        <h2>Setor da vida</h2>
        <p style="font-size: 20px"><b><?=$setorVida->nome_setor_vida?></b></p>
    </div>
    <div class="tMargin20">
        <a class="defaultButton" href="<?=site_url("tarot/escolherSetor");?>">Voltar</a>
    </div>
</div>
<div id="dialog-cartas"></div>
<form id="frm" method="POST" action="<?=site_url("/tarot/verResultado")?>">
    <input type="hidden" name="casas-preenchidas"/>
    <input type="hidden" name="setor-vida" value="<?=$setorVida->cod_setor_vida?>"/>
</form>
<script>
// array para armazenar as casas preenchidas
var casasPreenchidas = [];

$("document").ready(function(){
    
    // obtem as casas ja preenchidas
    var casasPreenchidasStr = '<?=$casasPreenchidas?>';
    
    // valida e preenche as casas
    if(casasPreenchidasStr && casasPreenchidasStr.length > 4){
        // splita
        var casas = casasPreenchidasStr.split("|");
        
        // percorre as casas e preenche no array
        for(var i = 0; i < casas.length; i++){
            // preenche no array
            casasPreenchidas.push(casas[i].replace(/\-/g, "#"));
            
            // obtem o codigo da casa preenchida
            var casaCod = casas[i].split("-")[0];
            
            // acerta a classe das casas preenchidas
            $("span.casa-"+casaCod).addClass("casa-preenchida");
        }
    }
    
    // seta o evento de click no ver resultado
    $("a.ver-resultado").click(clickVerResultado);
    
    // seta o evento de click nas cartas
    $("div.casas span").click(function(){
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
                               width: 550,
                               height: 420,
                               modal: true,
							   dialogClass : "dialog",
                               close: function(){ $("#dialog-cartas").html("").dialog("destroy") }
                           });
    });
});

function clickVerResultado(){

    // checa se existe pelo menos uma casa preenchida
    if(casasPreenchidas.length < 5){
        alert("Preencha as 5 casas para poder visualizar o resultado!");
        return false;
    }
    
    // salva as casas preenchidas no input
    $("input[name=casas-preenchidas]").val(casasPreenchidas);
    
    // posta o form
    $("#frm").submit();
}

</script>



