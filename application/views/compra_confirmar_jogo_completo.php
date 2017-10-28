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
                <b>Setor:</b> <?= $setorVida->nome_setor_vida ?><br/>
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
        <? foreach ($jogoCompleto as $key => $jogo) : ?>
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
                    <br/><?=$jogo["arcanoMenor2"]->nome_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor2"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMenor1"]->nome_carta?>
                </td>
                <td class="border-left">
                    <? if(@$jogo["comprado"]): ?>
                        Já comprado
                    <? else: ?>
                        R$ <?=moeda($custo)?>
                        <? $total += $custo; ?>
                    <? endif; ?>
                </td>
            </tr>
        <? endforeach ?>
        <tr class="first-line">
            <td colspan="5">
                <h2 style="margin-top: 0; padding-bottom: 0;">Total: R$ <?=moeda($total)?></h2>
            </td>
        </tr>
    </table>
</div>
<div>
    
</div>
<h2 class="versalete">Escolha a sua forma de pagamento</h2>
<p>Ao clicar no botão comprar, você confirma estar ciente dos regulamentos e termos do site. </p>
<div>
    <p>Tem certeza que deseja confirmar a compra do jogo acima?</p>
</div>
<div>Sim, debitar <b>R$ <?=moeda($total)?></b> do meu saldo de <b>R$ <?=moeda($saldo);?></b></div>
<br/>
<div class="tMargin20 clearfix">
    <a debito="R$ <?=moeda($total)?>" class="newBlueButton buy" href="<?=site_url()?>/compra/jogo/debitar" style="padding: 10px 60px">
        <span>Debitar</span>
    </a>
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

<script type="text/javascript">
$("document").ready(function(){
    $("a.buy").click(function(evt){
        evt.preventDefault();

        var valor = $(this).attr("debito");
        var url = $(this).attr("href");

        // confirma o debito
        if(confirm("Confirma o débito de "+valor+" de sua conta?")){
            window.location.href = url;
        }else{
            return false;
        }
    });
});
</script>