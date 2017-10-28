<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>
<? if(strlen(@$msg) > 3 && trim(@$msg) != ""): ?>
    <div class="mensagem"><?=$msg?></div>
<? endif; ?>
<div class="container">
    <form name="frm" action="<?=site_url()?>/carta/doPreencherDescricao" method="POST">
        <h1>Preencher descricao</h1>
        <div>
            <label>Carta</label>
            <select name="carta">
                <option value="0">Selecione</option>
                <? $selected = ""; ?>
                <? foreach($cartas as $carta): ?>
                    <? if(is_object($cartaSelecionada)): ?>
                        <? $selected = ($carta->cod_carta == $cartaSelecionada->cod_carta) ? "selected='selected'" : "" ?>
                    <? endif; ?>
                    <option <?=$selected?> value="<?=$carta->cod_carta?>"><?=$carta->nome_carta?></option>
                <? endforeach; ?>
            </select>
        </div>
        <? if(is_object($cartaSelecionada) && $cartaSelecionada->cod_tipo_carta == 2): ?>
            <div>
                <label>Sub-tipo</label>
                <select name="sub-tipo">
                    <option value="0">Selecione</option>
                    <option <?=($subTipo=="ATIVO") ? "selected='selected'" : ""?>>ATIVO</option>
                    <option <?=($subTipo=="PASSIVO") ? "selected='selected'" : ""?>>PASSIVO</option>
                </select>
            </div>
        <? endif; ?>
        <div>
            <p>
                <br/><br/><b>Texto</b>
            </p>
            <textarea name="descricao" class="ckeditor"><?=@$descricao->descricao?></textarea>
        </div>
        <div style="margin: 40px 0; text-align: center;">
            <input type="submit" class="button" value="Salvar"/>
        </div>
        <a class="button" href="<?=site_url()?>/tarot/">Voltar</a>
        <input type="hidden" name="cod-tipo-carta" value="<?=@$cartaSelecionada->cod_tipo_carta?>"/>
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/ckeditor/ckeditor.js"></script>

<script>

$("document").ready(function(){
    $("select[name=carta]").change(function(){
        // obtem o codigo
        var cod = $(this).val();
        
        // redireciona a pagina 
        window.location.href = '<?=site_url()?>'+'/carta/preencherDescricao?c='+cod;
    });
    
    $("select[name=sub-tipo]").change(function(){
        // obtem o codigo
        var codCarta = $("select[name=carta]").val();
        var subTipo = $(this).val();
        
        // redireciona a pagina 
        window.location.href = '<?=site_url()?>'+'/carta/preencherDescricao?c='+codCarta+"&st="+subTipo;
    });
    
    $("input[type=submit]").click(function(evt){
        evt.preventDefault();
        
        // obtem os dados
        var codTipo = $("input[name=cod-tipo-carta]").val();
        var subTipo = $("select[name=sub-tipo]").val();
        var codCarta = $("select[name=carta]").val();
        
        // valida 
        if(codTipo == 2 && (subTipo == "" || subTipo == 0)){
            alert("Erro: Escolha o sub-tipo");
            return false;
        }
        if(codCarta == "" || codCarta == 0){
            alert("Erro: Escolha a carta"); return false;
        }
       
        $("form").submit();
        
        return true;
    });
});

</script>

</body>
</html>