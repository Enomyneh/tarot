<div>
    <!-- <div><a href="<?= site_url() ?>/monografia/verTodas">Comprar monografias</a></div> -->

    <? if(count($monografias) > 0): ?>
        <div class="clearfix">
            <div class="first-box">
                <div>
                    <h2>Arquivos Virtuais</h2>
                </div>
                <div>
                    <p>Aperfeiçoe suas consultas no taro com significados inéditos nas cartas do tarô. Adquira os arquivos virtuais sobre os significados da taromancia.</p>
                    <a style="display: inline-block;" class="newBlueButton" href="http://www.taromancia.com.br/index.php/project/arquivos-digitais/" target='_blank'>
                        <span>Acesse os Arquivos Digitais</span>
                    </a>
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
                
        <div>
            <h2>Meus Arquivos Virtuais</h2>
        </div>        
        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget">
                            <div class="tabela-monografia top">
                                <table class="table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="item-1">Data da compra</th>
                                            <th class="item-2">Título</th>
                                            <th class="item-3">Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? $count = 0; ?>
                                        <? foreach($monografias as $monografia): ?>
                                            <? $count++ ?>
                                            <? $class = ($count%2 == 1) ? " class='impar'" : ""  ?>
                                            <tr<?= $class ?>>
                                                <td><?= mysql_to_br($monografia->data_compra_monografia) ?></td>
                                                <td><?= $monografia->titulo ?></td>
                                                <td><a href="<?=site_url()?>/monografia/ver?m=<?=$monografia->cod_monografia?>">Ver Arquivo</a></td>
                                            </tr>
                                        <? endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
    <? endif; ?>

    <br/>
    <div class="horiz-line"></div>
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