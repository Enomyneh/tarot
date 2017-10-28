<div>
    <span style="display: inline-block; vertical-align: top;">
        <img src="<?=base_url()?>assets/images/pacote-10.jpg" />
    </span>
    <span style="display: inline-block; margin-top: -11px; margin-left: 10px; width: 420px;">
        <h2>Habilita&ccedil;&atilde;o de cr&eacute;ditos para mapeamento completo</h2>
        <br/>
        <p class="justify">Ao clicar no m&eacute;todo de pagamento de sua prefer&ecirc;ncia, selecione a quantidade de cr&eacute;ditos que desejar. Valor m&iacute;nimo de cr&eacute;ditos: 10, e voc&ecirc; poder&aacute; us&aacute;-los para liberar as 10 p&aacute;ginas da sua previs&atilde;o</p>
        <br/>
        <p>
            <b>Abaixo o tempo estimado de entrega:</b><br/>
            <span>1. Cart&atilde;o de Cr&eacute;dito, transfer&ecirc;ncia no Pagseguro ou Paypal: Em 1hora;</span><br/>
            <span>2. Boleto Banc&aacute;rio: Em dois dias &uacute;teis;</span>
        </p>
        <p>&nbsp;</p>
        <p>
            <b>Obter cr&eacute;ditos com:</b>
            <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
            <form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post">
                <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
                <input type="hidden" name="itemCode" value="3BF76FD4C9C9E4E664238F9B156B66C7" />
                <input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/209x48-comprar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
            </form>
            <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
        </p>
        <p>&nbsp;</p>
        <p>
            <b>Obter cr&eacute;ditos com:</b>
            <!-- INICIO DO PAYPAL -->
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="LRTS27KUVU7RE">
                <input type="image" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira mais fácil e segura de efetuar pagamentos online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
            </form>
            <!-- FIM DO PAYPAL -->
        </p>
    </span>
</div>

<div class="p-justify">
    <h2>O que vem incluso nos créditos:</h2>

    <p><b>Mapeamentos salvos</b></p>
    <p>Você pode acompanhar as previsões e reler quantas vezes achar necessário. Ao uma conta, a cada jogo completo realizado será armazenado automaticamente;</p>

    <p><b>Compra de conteúdo permanente</b></p>
    <p>Cada combinação custa apenas R$1,00, e o mapeamento completo, R$10,00. Isso quer dizer que se eventualmente houver outros jogos em qualquer setor, e se, cair a mesma combinação do jogo anterior não será cobrado novamente;</p>

    <p><b>Atualização gratuita de conteúdo</b></p>
    <p>Nosso banco de dados atual conta com quase sete milhões de combinações somente para o jogo da cruz celta. E ainda estamos atualizando todo o conteúdo para atingir o máximo de precisão e coerência no jogo. Quando o seu mapeamento for salvo, você terá mais conteúdo e cada vez com mais qualidade. Nossos especialistas em significação atualizarão o conteúdo do sistema constantemente.</p>

    <p><b>Média de dez a 30 páginas de conteúdo</b></p>
    <p>Em nossa página do site, você terá dez páginas de conteúdo que são as dez casas da cruz celta interpretada. Mas em um arquivo word podemos chegar de dez a 30 páginas só de texto. Porque podemos proporcionar ao nosso consulente um conteúdo robusto com muita informação sobre a sua consulta;</p>
</div>

<script>
$("document").ready(function(){
    $("img.pacote").click(function(){
        $(this).nextAll().find("input[type=image]").click();
    });
});
</script>