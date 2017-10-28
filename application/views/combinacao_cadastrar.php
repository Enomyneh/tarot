<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>
<div class="container">
    <? if($message == "sucesso"): ?>
        <div class="mensagem">Jogo cadastrado com sucesso!</div>
    <? endif; ?>
    <div class="tMargin20">
        <a class="button" href="<?=site_url()?>/tarot/index">VOLTAR</a>
    </div>
    <form name="frm" action="<?=site_url()?>/combinacao/doCadastrar" method="POST">
        <h1>Cartas</h1>
        <div>
            <select name="carta-1">
                <option value="">Arcano maior:</option>
                <option value="">TODOS</option>
                <? foreach ($cartas as $key => $carta): ?>
                    <? if($carta->cod_tipo_carta == 1): ?>
                        <option value="<?=$carta->cod_carta?>"><?=$carta->nome_carta?></option>
                    <? endif; ?>
                <? endforeach; ?>
            </select>
            <input type="text" name="carta-1-valor" class="moeda" />
        </div>
        <div>
            <select name="carta-2">
                <option value="">Arcano menor 1:</option>
                <option value="">TODOS</option>
                <? foreach ($cartas as $key => $carta): ?>
                    <? if($carta->cod_tipo_carta == 2): ?>
                        <option value="<?=$carta->cod_carta?>"><?=$carta->nome_carta?></option>
                    <? endif; ?>
                <? endforeach; ?>
            </select>
            <input type="text" name="carta-2-valor" class="moeda" />
        </div>
        <div>
            <select name="carta-3">
                <option value="">Arcano menor 2:</option>
                <option value="">TODOS</option>
                <? foreach ($cartas as $key => $carta): ?>
                    <? if($carta->cod_tipo_carta == 2): ?>
                        <option value="<?=$carta->cod_carta?>"><?=$carta->nome_carta?></option>
                    <? endif; ?>
                <? endforeach; ?>
            </select>
            <input type="text" name="carta-3-valor" class="moeda" />
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
        <div id="texto-carta-1" class="hidden">
            <p>
                <b>Texto - Carta 1</b>
            </p>
            <textarea name="combinacao-carta-1" class="ckeditor"></textarea>
        </div>
        <div id="texto-carta-2" class="hidden">
            <p>
                <b>Texto - Carta 2</b>
            </p>
            <textarea name="combinacao-carta-2" class="ckeditor"></textarea>
        </div>
        <div id="texto-carta-3" class="hidden">
            <p>
                <b>Texto - Carta 3</b>
            </p>
            <textarea name="combinacao-carta-3" class="ckeditor"></textarea>
        </div>
        <div style="margin: 40px 0; text-align: center;">
            <input type="submit" class="button" value="SALVAR"/>
        </div>
    </form>
</div>


<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/ckeditor/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script>
$("document").ready(function(){

    $("input.moeda").maskMoney({
        prefix : 'R$ ',
        thousands : '.',
        decimal : ','
    });

    $("select[name=carta-1],select[name=carta-2],select[name=carta-3]").change(function(){

        var carta = $(this).attr("name");

        if($(this).val() == ""){

            $("div#texto-"+carta).hide();
            $("textarea[name=combinacao-"+carta+"]").html("");

        }else{

            $("div#texto-"+carta).show();
        }

    });

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

        var carta1 = $("select[name=carta-1]").val();
        var carta2 = $("select[name=carta-2]").val();
        var carta3 = $("select[name=carta-3]").val();

        // checa se pelo menos 2 cartas foram escolhidas
        var countCartas = 0;

        if(carta1 != "" && parseInt(carta1) > 0){ countCartas++; }
        if(carta2 != "" && parseInt(carta2) > 0){ countCartas++; }
        if(carta3 != "" && parseInt(carta3) > 0){ countCartas++; }

        if(countCartas < 1){
            alert("Erro: Preencha pelo menos 1 carta!");
            return false;
        }

        // checa se a carta2 e carta3 sao diferentes
        if(carta2 == carta3 && parseInt(carta2) > 0 ){
            alert("Erro: O arcano menor 2 e o arcano menor 3 devem ser diferentes!");
            return false;
        }

        var count = 0;

        // checa os setores da vida
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