<div class="big-widget">
    <div class="widget">
        <div class="widget-bottom">
            <div class="widget-content">
                <div class="textwidget extrato">
                    <h2>Seja Bem Vindo(a) <?= Auth::getData("nome"); ?></h2>
                    <form method="POST" action="<?= site_url()?>/pedido/mapeamentoSolicitado">
                        <input type="hidden" name="cod-setor-vida" value="<?= $setorVida->cod_setor_vida ?>"/>
                        <input type="hidden" name="cod-sub-setor-vida" value="<?= $subSetor->cod ?>"/>
                        <input type="hidden" name="cod-tipo-mapeamento" value="<?= $tipoMapeamento->cod ?>"/>

                        <div>
                            Vamos fazer uma triagem de atendimento? Assim poderemos ter uma ideia do que mais esta necessitando como resposta na sua analise. Confirme os dados abaixo:<br/>
                        </div>
                        <div class="tMargin10">
                            <b>Setor: </b>
                            <span><?= $setorVida->nome_setor_vida ?></span>
                            <br/>
                            <b>Sua situa&ccedil;&atilde;o: </b>
                            <span><?= $subSetor->sub_setor ?></span>
                            <br/>
                            <b>Sua an&aacute;lise: </b>
                            <span><?= $tipoMapeamento->tipo ?></span>
                            <br/><br/>
                            <span>Para alterar <a href="http://www.oracvlvm.com/index.php/consulta-oracular/" target="_blank">clique aqui</a></span>
                            <br/><br/>
                            <b>Gostaríamos de adequar a escrita da sua análise à sua orientação sexual. Poderia nos informar? (opcional)</b>
                            <input type="text" class="large" name="orientacao-sexual" placeholder="Ex. Heterosexual" />
                            <br/><br/>
                            <b>Gostaria de nos contar o que está ocorrendo com você? (opcional)</b>
                            <textarea name="primeira-pergunta" rows="3" style="width: 99%; padding: 10px;"></textarea>
                            <br/><br/>
                            <b>Informe as perguntas que deseja obter resposta sobre sua <b>situação</b> (opcional):</b>
                        </div>
                        <div class="questions">
                            <input type="text" class="large" name="perguntas[]" placeholder="Pergunte aqui..." />
                        </div>
                        <div class="tMargin10 clearfix">
                            <a class="newGreenButton newQuestion"><span>Quero fazer outra pergunta</span></a>    
                        </div>
                        <div class="tMargin20">
                            <b>Esta linha de analise atende as necessidades de pessoas:</b><br/>
                            <span>Que investem no seu desenvolvimento pessoal, para potencializar o seu autoconhecimento;</span><br/>
                            <span>Avalia e admite seus erros em qualquer causa mesmo sendo ela negativa;</span><br/>
                            <span>Pessoas que desejam obter autocontrole bem como gerenciar suas rotas do destino para ter melhor qualidade de vida.</span>
                        </div>
                        <div class="tMargin20">
                            <b>Ao responder esse pré-atendimento, você afirma que:</b><br/>
                            <span>Sou maior de 18 anos;</span><br/>
                            <span>Gozo de perfeita saúde e sobriedade mental;</span><br/>
                            <span>Não sou gestante;</span><br/>
                            <span>Sou responsável pelas minhas ações e escolhas;</span><br/>
                            <span>Mais informações leia o <a target="_blank" href="http://www.oracvlvm.com/index.php/sobre-o-projeto-oracvlvm/arquitetura-do-site/"><b>termo de uso</b></a></span>
                        </div>
                        <div class="tMargin20 clearfix">
                            <a class="newGreenButton submit"><span>Solicitar an&aacute;lise</span></a>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">

$("document").ready(function(){

    $(".newQuestion").click(clickNewQuestion);

    $("a.submit").click(function(){

        /*
        // checa se preencheu ao menos uma pergunta
        var hasPerguntas = false;

        $("input[name='perguntas[]']").each(function(){

            if($(this).val() != "" && $(this).val().length > 0)){
                hasPerguntas = true;

                return true;
            }
        });

        if(hasPerguntas == false){

            alert("Erro: Preencha alguma pergunta antes de solicitar a analise!");
        }*/

        $("form").submit();
    });
});

function clickNewQuestion(){

    var otherQuestions = true;

    // checa se os outros inputs estao preenchidos
    $("input[name='perguntas[]']").each(function(){

        if($(this).val() == ""){

            alert("Preencha as outras perguntas antes de criar uma nova pergunta!");

            otherQuestions = false;
            return false;
        }
    });

    // valida
    if(otherQuestions == false){
        return false;
    }

    // add um novo input
    $("div.questions").append("<input class=\"large\" type=\"text\" name=\"perguntas[]\" placeholder=\"Pergunte aqui...\" />");
}
</script>