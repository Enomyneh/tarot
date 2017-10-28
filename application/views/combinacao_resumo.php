<div>
    <h2>Combinações de Cartas</h2>
    <p>Você poderá desenvolver-se nas suas consultas ao tarô inovando o seu conceito de significado das cartas. Obtenha significados impactantes para diversos assuntos questionados ao tarô. Acesse ao nosso banco de dados com milhares de significados de cartas combinados. Caso ainda não tenha créditos, <a href="<?= site_url('/conta/ver') ?>">clique aqui</a>.</p>
    <h3>Selecione a combinação desejada</h3>
    <div class="clearfix">
        <div class="dialog-cartas">
            <div class="carta-escolher" style="height: 70px;">
                <select name="arcano-maior" style="width: 150px; font-size: 10px; padding: 6px;">
                    <option value="0" selected="selected">Arcano-maior:</option>
                    <? foreach($arcanosMaiores as $arcanoMaior): ?>
                        <option value="<?=$arcanoMaior->cod_carta?>"><?=$arcanoMaior->nome_carta?></option>
                    <? endforeach; ?>
                </select>
                <span class="carta-imagem"></span>
            </div>
            <div class="carta-escolher" style="height: 70px;">
                <select name="arcano-menor-1" style="width: 150px; font-size: 10px; padding: 6px;">
                    <option value="0" selected="selected">Arcano-menor 1:</option>
                    <? foreach($arcanosMenores as $arcanoMenor): ?>
                        <option value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                    <? endforeach; ?>
                </select>
                <span class="carta-imagem"></span>
            </div>
            <div class="carta-escolher" style="height: 70px;">
                <select name="arcano-menor-2" style="width: 150px; font-size: 10px; padding: 6px;">
                    <option value="0" selected="selected">Arcano-menor 2:</option>
                    <? foreach($arcanosMenores as $arcanoMenor): ?>
                        <option value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                    <? endforeach; ?>
                </select>
                <span class="carta-imagem"></span>
            </div>
            <div class="clearfix hidden btn-escolher center-button tMargin10">
                <a href="<?=site_url()?>/compra/confirmar" class="newGreenButton escolher"><span>Escolher</span></a>
            </div>
        </div>
        <div class="tCenter second-box">
            <img width="320" src="http://www.taromancia.com.br/wp-content/uploads/2016/01/Professora.png"/>
            <br/>
            <a style="display: inline-block; width: 277px;" class="newBlueButton" href="http://www.taromancia.com.br/index.php/cursos-de-taromancia-2/" target='_blank'>
                <span>Quer aprender a jogar taromancia? Clique aqui.</span>
            </a>
        </div>
    </div>
    
    <!-- <div><a href="<?= site_url() ?>/monografia/verTodas">Comprar monografias</a></div> -->

    <br/>
    <div class="horiz-line"></div>

    <p></p>
    <? if(count($combinacoes) == 0): ?>
        <h2>No momento não há combinações armazenadas.</h2>
    <? endif; ?>

    <? if(count($combinacoes) > 0): ?>
        <div>
            <h2>Minhas Combinações de Cartas</h2>
        </div> 
        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="item-1">Data da compra</th>
                                        <th class="item-2">Combina&ccedil;&atilde;o</th>
                                        <th class="item-3">Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? $count = 0; ?>
                                    <? foreach($combinacoes as $combinacao): ?>
                                        <? $count++ ?>
                                        <? $class = ($count%2 == 1) ? " class='impar'" : ""  ?>
                                        <tr<?= $class ?>>
                                            <td><?= mysql_to_br($combinacao->data_compra_combinacao) ?></td>
                                            <td><?=$combinacao->nome_arcano_maior?> - <?=$combinacao->nome_arcano_menor_1?> - <?=$combinacao->nome_arcano_menor_2?></td>
                                            <td><a href="<?=site_url()?>/jogo/escolherSetorVida?cuc=<?=$combinacao->cod_usuario_combinacao?>">Ver Combinação</a></td>
                                        </tr>
                                    <? endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
    <? endif; ?>   
</div>


<script>

$(document).ready(function(){
   // adiciona os eventos
   $("select").change(changeSelect);
   $("a.escolher").click(clickEscolher);
});

function changeSelect(){
    // obtem o select
    var select = $(this);
    
    // carrega a imagem
    loadImage(select);

    // mostra o botao escolher
    $(".btn-escolher").show();

    // remove a restricao de tamanho das divs
    $("div.carta-escolher").css("height", "300px");
}

function loadImage(select){
    // obtem o codigo da imagem
    var cod = select.val();
    
    // carrega a imagem
    select.parent()
           .find("span.carta-imagem")
           .html("<img src=\"<?=base_url()?>assets/images/cartas/"+cod+".jpg\" width=\"150\" height=\"262\"/>");
}

function clickEscolher(evt){
    evt.preventDefault();

    // obtem os codigos das cartas
    var codArcanoMaior = $("select[name=arcano-maior]").val();
    var codArcanoMenor1 = $("select[name=arcano-menor-1]").val();
    var codArcanoMenor2 = $("select[name=arcano-menor-2]").val();
    
    // valida as selecoes
    if(codArcanoMaior == "0"){
        alert("Escolha um arcano maior valido!");
        return false;
    }
    if(codArcanoMenor1 == "0"){
        alert("Escolha o arcano menor 1!");
        return false;
    }
    if(codArcanoMenor2 == "0"){
        alert("Escolha o arcano menor 2!");
        return false;
    }
    if(codArcanoMenor1 == codArcanoMenor2){
        alert("O arcano menor 1 deve ser diferente do arcano menor 2!");
        return false;
    }
    
    // obtem a url
    var url = $(this).attr("href");

    // redireciona
    window.location.href = url + "?ama=" + codArcanoMaior + "&ame1=" + codArcanoMenor1 + "&ame2=" + codArcanoMenor2 + "&o=comb";
}
</script>