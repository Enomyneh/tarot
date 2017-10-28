<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>
<? if(strlen($msg) > 3 && trim($msg) != ""): ?>
    <div class="mensagem"><?=$msg?></div>
<? endif; ?>
<div class="container">
    <form name="frm" action="<?=site_url()?>/tarot/doInclusaoEmMassa" method="POST">
        <h1>Inclusão em massa</h1>
        <div class="clearfix">
            <div>
                <p>
                    <b>Texto 1</b>
                </p>
                <textarea name="texto-1" class="ckeditor"><?=$texto1?></textarea>
            </div>
            <div>
                <p>
                    <b>Texto 2</b>
                </p>
                <textarea name="texto-2" class="ckeditor"><?=$texto2?></textarea>
            </div>
            <div>
                <p>
                    <b>Texto 3</b>
                </p>
                <textarea name="texto-3" class="ckeditor"><?=$texto3?></textarea>
            </div>
            <div>
                <p><b>Setores da Vida</b> - <input type="checkbox" name="all-setor"/>todos</p>
                <? foreach($setoresVida as $setorVida): ?>
                    <input id="setor<?=$setorVida->cod_setor_vida?>" type="checkbox" name="setor-vida[]" value="<?=$setorVida->cod_setor_vida?>"/>
                    <label for="setor<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></label>
                <? endforeach; ?>
            </div>
            <div>
                <p><b>Casas das cartas</b> - <input type="checkbox" name="all-casas"/>todos</p>
                <? foreach($casasCartas as $casaCarta): ?>
                    <input id="casa<?=$casaCarta->cod_casa_carta?>" type="checkbox" name="casa-carta[]" value="<?=$casaCarta->cod_casa_carta?>"/>
                    <label for="casa<?=$casaCarta->cod_casa_carta?>"><?=$casaCarta->nome_casa_carta?></label>
                <? endforeach; ?>
            </div>
            <div>
                <p><b>Arcanos Maiores</b></p>
                <select name="arcano-maior">
                    <? foreach($arcanosMaiores as $arcanoMaior): ?>
                        <? $selected = ($arcanoMaior->cod_carta == $arcanoMaiorSel) ? "selected='selected'" : "" ?>
                        <option <?=$selected?> value="<?=$arcanoMaior->cod_carta?>"><?=$arcanoMaior->nome_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <p><b>Arcanos Menores 1</b></p>
                <select name="arcano-menor1">
                    <? foreach($arcanosMenores as $arcanoMenor): ?>
                        <? $selected = ($arcanoMenor->cod_carta == $arcanoMenor1Sel) ? "selected='selected'" : "" ?>
                        <option <?=$selected?> value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <p><b>Arcanos Menores 2</b></p>
                <select name="arcano-menor2">
                    <? foreach($arcanosMenores as $arcanoMenor): ?>
                        <? $selected = ($arcanoMenor->cod_carta == $arcanoMenor2Sel) ? "selected='selected'" : "" ?>
                        <option <?=$selected?> value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>
        </div>
        <div style="margin: 40px 0; text-align: center;">
            <input type="submit" class="button" value="Salvar"/>
        </div>
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/ckeditor/ckeditor.js"></script>

<script>

$("document").ready(function(){
    
    $("input[name=all-setor]").click(function(){
        if($(this).is(":checked")){
            $("input[name='setor-vida[]']").each(function(){
                this.checked = "checked";
            });
        }else{
            $("input[name='setor-vida[]']").each(function(){
                this.checked = "";
            });
        }
    });
	
	$("input[name=all-casas]").click(function(){
        if($(this).is(":checked")){
            $("input[name='casa-carta[]']").each(function(){
                this.checked = "checked";
            });
        }else{
            $("input[name='casa-carta[]']").each(function(){
                this.checked = "";
            });
        }
    });
    
    $("input[type=submit]").click(function(evt){
        evt.preventDefault();
        
        // valida o setor vida
        if($("input[name='setor-vida[]']:checked").length <= 0){
            alert("Erro: preencha o setor vida");
            return false;
        }
        if($("input[name='casa-carta[]']:checked").length <= 0){
            alert("Erro: preencha a casa carta");
            return false;
        }
        
        $("form").submit();
        
    });
});

</script>

</body>
</html>