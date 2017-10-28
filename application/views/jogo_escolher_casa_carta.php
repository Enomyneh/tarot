<style type="text/css">
  div.box-left {
    float: left;
    width: 200px;
  }
  div.box-right {
    float: left;
    width: 50%;
  }
</style>
<div class='clearfix'>
  <form action="<?=site_url("jogo/resultadoCuc")?>">
    <div class='box-left'>
        <img height="400" src="<?=base_url()?>/assets/images/escolher-setor-da-vida-imagem.jpg"/>
    </div>
    <div class='box-right'>
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