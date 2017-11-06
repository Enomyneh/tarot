<style>
.b-span b { width: 135px; display: inline-block; }
</style>
<h2 class="versalete">Confirmar compra do jogo</h2>
<p>Confira as informações do seu jogo e verifique se as cartas combinadas estão corretas:</p>

<div class="lista-jogo-completo">
    <? $total = 0; ?>
    <table class='table-jogo'>
        <tr class='first-line'>
            <td colspan="5" style="text-align: left;" class='b-span'>
                <b>Produto:</b> Autoconsulta / Consulta Virtual<br/>
                <b>Leitura do Tarot:</b> Metodologia de Análise Taromantica<br/>
                <b>Setor:</b> <?= $jogoCompleto->setorVida->nome_setor_vida ?><br/>
                <b>Acesso:</b> Leitura online<br/>
            </td>
        </tr>
        <tr class='first-line'>
            <td></td>
            <td>Arcano Maior</td>
            <td>Arcano Menor 1</td>
            <td>Arcano Menor 2</td>
            <td class="border-left">Valor</td>
        </tr>
        <? foreach ($jogoCompleto->combinacoes as $key => $jogo) : ?>
            <tr>
                <td>
                    <?=$jogo["casaCarta"]->nome_casa_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMaior"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMaior"]->nome_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor1"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMenor1"]->nome_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor2"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMenor2"]->nome_carta?>
                </td>
                <td class="border-left">
                    <? if(@$jogo["comprado"] OR $jogo['casaCarta']->ja_comprada == true): ?>
                        Já comprado
                    <? else: ?>
                        <? if($jogo['casaCarta']->custo == 0): ?>
                            Grátis
                        <? else: ?>
                            R$ <?=moeda($jogo['casaCarta']->custo)?>
                        <? endif; ?>
                        <? $total += $jogo['casaCarta']->custo; ?>
                    <? endif; ?>
                </td>
            </tr>
        <? endforeach ?>
        <tr class="first-line">
            <td colspan="5">
                <h2 style="margin-top: 0; padding-bottom: 0;">Total:
                    <? if($total == 0): ?>
                        Grátis
                    <? else: ?>
                        R$ <?=moeda($total)?>
                    <? endif; ?>
                </h2>
            </td>
        </tr>
    </table>
</div>
<div>
    
</div>

<? if($total == 0): ?>

    <div>
        <br/><br/>
        <h2 class="versalete">Este jogo é gratuito. Clique para obter a leitura.</h2>
        <br/><br/>
        <a class="newBlueButton" href="<?=site_url()?>/compra/obterJogoGratis" style="padding: 10px 60px">
            <span>Obter leitura completa</span>
        </a>
    </div>

<? else: ?>
    <h2 class="versalete">Escolha a sua forma de pagamento</h2>
    <p>Ao clicar no botão comprar, você confirma estar ciente dos regulamentos e termos do site. </p>
    <br/>
    <div class="tMargin20 clearfix">
        <a class="newBlueButton buy" style="padding: 10px 60px">
            <span>Comprar</span>
        </a>
        <h3 class="carregando hidden">CARREGANDO...</h3>
        <br/><br/><br/><br/><br/>
        <p>Sua compra está protegida por: </p>
        <img src="<?= base_url() ?>/assets/images/pagseguro.jpg" width="222"/>
    </div>
    <div>
        <br/>
        <br/>
        <p class="red">Importante!</p>
        <p class='justify'>
            <b>Conteúdo:</b> Voce está adquirindo a versão 1.0. <a target="_blank" href="http://www.taromancia.com.br/index.php/atividades-recentes/">Clique aqui e acompanhe as atualizações.</a><br/><br/>
            <b>Direitos:</b> Este serviço está disponível somente para acesso online. Não autorizamos a cópia ou a disseminação nem de senha nem de conteúdo na internet. Leia os termos de Uso. Caso você tenha visto o nosso conteúdo em outro site, cópia ou quaisquer forma de distribuição deste conteúdo não hesite em denunciar e entre em contato com o nosso departamento jurídico pelo e-mail: <a href='mailto:juridico@taromancia.com.br'>juridico@taromancia.com.br</a>
        </p>
    </div>
<? endif; ?>

<script type="text/javascript">
$("document").ready(function(){
    $("a.buy").click(function(evt)
    {
        evt.preventDefault();

        trocaCarregando();

        $.ajax({
            type: "POST",
            url: "<?=site_url()?>"+"/pedido/gerarPagSeguro",
            success : successPagSeguro,
            error : errorPagSeguro
        })


    });
});

function trocaCarregando()
{
    if($('a.buy').is(":visible"))
    {
        $('a.buy').hide();
        $('.carregando').show();
    }else{
        $('a.buy').show();
        $('.carregando').hide();
    }
}

function successPagSeguro(data)
{
    try{
        var retorno = $.parseJSON(data);
    }catch (exception)
    {
        alert('ERROR: NAO FOI POSSIVEL RECEBER O RETORNO DO PAGSEGURO');
        return false;
    }

    // obtem o codigo pra checkout
    var checkoutCode = retorno.code;

    // abre o lightbox
    PagSeguroLightbox(checkoutCode);

    // tira o carregando
    trocaCarregando();
}
function errorPagSeguro()
{
    alert('erro');
}
</script>
<?php if (ENVIROMENT_PAGSEGURO == "sandbox") : ?>
    <!--Para integração em ambiente de testes no Sandbox use este link-->
    <script
            type="text/javascript"
            src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
    </script>
<?php else : ?>
    <!--Para integração em ambiente de produção use este link-->
    <script
            type="text/javascript"
            src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
    </script>
<?php endif; ?>