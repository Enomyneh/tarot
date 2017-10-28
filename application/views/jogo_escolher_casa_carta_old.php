<div>

<style type="text/css">
  #container {
    width: 670px;
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
</style>
    <form action="<?=site_url("jogo/resultadoCuc")?>">

        <div id="wrapper">
          <div id="container">
            <div><div><img height="400" src="<?=base_url()?>/assets/images/escolher-setor-da-vida-imagem.jpg"/></div></div>
            <div>
                <div style="padding: 10px;">
                    <h2 class="versalete">Casa da Carta</h2>
                    <select name="cc">
                        <option selected="selected">Selecione</option>
                        <? foreach($casasCarta as $casaCarta): ?>
                            <option value="<?=$casaCarta->cod_casa_carta?>"><?=$casaCarta->nome_casa_carta?></option>
                        <? endforeach; ?>
                    </select>

                    <input type="hidden" name="sv" value="<?=$setorVidaCod?>"/>
                    <input type="hidden" name="cuc" value="<?=$codUsuarioCombinacao?>"/>
                </div>
                <div id="submit" class="tMargin10" style="padding-left: 10px;">
                    <a id="btnSubmit" class="newGreenButton"><span>Avan&ccedil;ar</span></a>
                </div>
            </div>
          </div>
        </div>
    </form>
</div>
<script>
$("document").ready(function(){

    $("#btnSubmit").click(function(){

        if($("select[name=cc]").val() == "" || $("select[name=cc]").val() == "Selecione"){
            alert("Erro: Escolha a casa carta!");

            return false;
        }

        $("form").submit();
    });

});
</script>