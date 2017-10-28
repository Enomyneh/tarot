<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <? if($combinacaoDisponivel == 1): ?>
        <div class="mensagem">Combina&ccedil;&atilde;o salva como dispon&iacute;vel!</div>
    <? endif; ?>
    <form action="<?=site_url();?>/tarot/escolherSetorVida" method="POST">
        <h1>Escolha a combinacao:</h1>
        <div class="form">
            <div>
                <label>Arcano Maior:</label>
                <select name="arcano-maior">
                    <option value="">Selecione</option>
                    <? foreach($arcanosMaiores as $arcanoMaior): ?>
                        <? $selected = ($arcanoMaior->cod_carta == $arcMaior) ? "selected='selected'" : "" ?>
                        <option <?=$selected?> value="<?=$arcanoMaior->cod_carta?>"><?=$arcanoMaior->nome_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>1o Arcano Menor:</label>
                <select name="arcano-menor-1">
                    <option value="">Selecione</option>
                    <? foreach($arcanosMenores as $arcanoMenor): ?>
                        <? $selected = ($arcanoMenor->cod_carta == $arcMenor1) ? "selected='selected'" : "" ?>
                        <option <?=$selected?> value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>2o Arcano Menor:</label>
                <select name="arcano-menor-2">
                    <option value="">Selecione</option>
                    <? foreach($arcanosMenores as $arcanoMenor): ?>
                        <? $selected = ($arcanoMenor->cod_carta == $arcMenor2) ? "selected='selected'" : "" ?>
                        <option <?=$selected?> value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>
            
            <div>
                <label>Tipo de Jogo:</label>
                <select name="grupo-casa-carta">
                    <? foreach($gruposCasaCarta as $grupoCasaCarta): ?>
                        <option selected="selected" value="<?=$grupoCasaCarta->cod_grupo_casa_carta?>"><?=$grupoCasaCarta->nome_grupo_casa_carta?></option>
                    <? endforeach; ?>
                </select>
            </div>
            
            <!--
            <div>
                <input id="comb-disp" type="checkbox" name="tornar-combinacao-disponivel"/>
                <label for="comb-disp">Tornar combinação disponível</label>
            </div>
            -->
            
            <div>
                <input class="button" type="submit" value="Enviar" />
            </div>
        </div>
    </form>
    <div>
        <a href="<?=site_url()?>/pedido/verTodos">Ver Pedidos Mapeamento</a><br/><br/>
        <a href="<?=site_url()?>/pedido/montarLink">Montar link produto</a><br/><br/>
        <a href="<?=site_url()?>/combinacao/cadastrar">Inclusão Inteligente</a>
        <br/><br/>
        <a href="<?=site_url()?>/carta/preencherDescricao">Descrição por carta</a>
        <br/><br/>
        <!-- <a href="<?=site_url()?>/tarot/combinacoesDisponiveis">Ver combinações disponíveis</a>
        <br/><br/> -->
        <a href="<?=site_url()?>/monografia/view">Monografias</a>
        <br/><br/>
        <a href="<?=site_url()?>/conta/verUsuarios">Usu&aacute;rios</a>
        <a href="<?=site_url()?>/admin/precosCartas">Ver precos das cartas</a>
    </div>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>

<script>

$(document).ready(function(){
   
   // adiciona os eventos
   $("select[name=arcano-menor-1],select[name=arcano-menor-2]").change(changeSelectArcanoMenor);
   
   $("input[type=submit]").click(function(evt){
       // impede o submit
       evt.preventDefault();
       
       if($("input[name=tornar-combinacao-disponivel]").is(":checked")){
           // confirma a acao
           if(confirm("Tem certeza que deseja tornar esta combinacao disponivel?")){
               $("form").submit();
           }
       }else{
           $("form").submit();
       }
       
       return true;
   });
});


function changeSelectArcanoMenor(){       
    // checa qual o select
    if($(this).attr("name") == "arcano-menor-1"){
        // select a remover
        var removeSelect = "arcano-menor-2";
    }else{
        var removeSelect = "arcano-menor-1";
    }

    // remove a option do outro select
    $('select[name='+removeSelect+'] option[value='+$(this).val()+']').remove();
}

</script>
    
</body>
</html>