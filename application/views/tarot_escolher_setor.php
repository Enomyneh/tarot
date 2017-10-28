<div>
    <form action="<?=site_url("tarot/montarJogo")?>" method="POST">
        <h2>Escolha o setor da vida</h2>
        <select name="setor-vida">
            <option selected="selected">Selecione</option>
            <? foreach($setoresVida as $setorVida): ?>
                <option value="<?=$setorVida->cod_setor_vida?>"><?=$setorVida->nome_setor_vida?></option>
            <? endforeach; ?>
        </select>
        <div id="descricao-setor-vida" class="hidden">
            <h2>Descri&ccedil;&atilde;o do setor da vida</h2>
            <? foreach($setoresVida as $setorVida): ?>
                <div id="descricao-<?=$setorVida->cod_setor_vida?>" class="hidden">
                    <?=$setorVida->descricao?>
                </div>
            <? endforeach; ?>
        </div>
        <div id="submit" class="hidden tMargin20">
            <input type="submit" class="greenButton" value="Avan&ccedil;ar" />
        </div>
    </form>
</div>
<script>
$("document").ready(function(){
    
    // seta o evento de change do select
    $("select[name=setor-vida]").change(function(){
        // esconde todas as descricoes
        $("#descricao-setor-vida div").hide();
        
        // obtem o id do setor selecionado
        var codSetor = $(this).val();
        
        // mostra o cabecalho e a descricao selecionada
        $("#descricao-setor-vida, #descricao-"+codSetor).show();
        
        // mostra o botao para avancar
        $("#submit").show();
    });
    
    
});
</script>