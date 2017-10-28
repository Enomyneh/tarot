<style type="text/css">
  #container {
    width: 85%;
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
  }
  div.new-casas label {
    display: inline-block;
    margin-top: 12px;
    cursor: pointer;
  }
</style>
<div>
    <p class="sub-title versalete" style="font-size: 28px;">
        Setor da vida <?=$setorVida->nome_setor_vida?>
    </p>
    <p>Monte seu jogo</p>
</div>
<div id="wrapper">
    <div id="container">
      <div style="width: 53%">
        <div class='new-casas'>
            <span class="new-casa-1" casa="1"><label>Clique aqui e escolha a sua carta</label></span>
            <span class="new-casa-2" casa="2"><label>Clique aqui e escolha a sua carta</label></span>
            <span class="new-casa-3" casa="3"><label>Clique aqui e escolha a sua carta</label></span>
        </div>
        <div style="margin-top: 20px; text-align: center;">
            <label class="ver-resultado-new"><a class="newBlueButton ver-resultado"><span>VER RESULTADO</span></a></label>
        </div>
       </div>
      <div>
          <div style="padding: 10px;">
            <a href="http://www.taromancia.com.br/index.php/cursos-de-taromancia-2/" target="_blank">
                <img src="<?=base_url()?>/assets/images/Professora.png" width="400" height="218"/>
                <p class="justify" style="height: 65px; margin-top: 10px;">E precisa de ajuda na interpretação? Conhece a Metodologia de Analise Taromântica? Saiba como realizar o seu jogo passo a passo clicando aqui.</p>
            </a>
          </div>
      </div>
    </div>
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



