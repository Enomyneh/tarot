<div class="form">
    <form id="form" action="<?=site_url()?>/login/doSignup" method="POST">

        <? if($compra == 1): ?>
            <p class="sub-title">
                <b class="versalete">Cadastre-se</b>
            </p>
            <p>Para continuar sua compra, preencha o cadastro abaixo.</p>
        <? else: ?>
            <p class="sub-title">
                <b class="versalete">Olá, seja bem-vindo(a)!</b>
            </p>
            <p>Cadastre-se para que você obtenha o melhor de nosso site.</p>
        <? endif; ?>

        <p class="sub-title tMargin30">
            <b class="versalete">Sobre você</b>
        </p>

        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget extrato">
                            <span><input type="text" name="nome" placeholder="Nome completo" /></span>
                            <span>
                                <input type="text" name="data_nascimento" placeholder="Data de nascimento" />
                                <span>(dd/mm/aaaa)</span>
                            </span>
                            <span>
                                <input type="text" name="profissao" placeholder="Profiss&atilde;o">
                            </span>
                            <span>
                                <select name="posicao" style="width: 317px; margin: 10px 20px 0 0;">
                                    <option value="0" selected="selected">Qual a sua posi&ccedil;&atilde;o?</option>
                                    <option>Aluno</option>
                                    <option>Apenas Cliente</option>
                                    <option>Professor de Tar&ocirc;</option>
                                    <option>Tarologista</option>
                                    <option>Outros</option>
                                </select>
                                <span>
                                    <input style="width: 200px;" type="text" name="posicao_outros" placeholder="Outros?"/>
                                </span>
                            </span>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>

        <p class="sub-title tMargin30">
            <b class="versalete">Seus contatos</b>
        </p>

        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget extrato">
                            <span>
                                <input type="text" name="telefone" placeholder="Telefone">
                                <span>(ddi)(ddd) 9999-9999</span>
                            </span>
                            <span>
                                <input type="text" name="email" placeholder="E-mail">
                                <input type="hidden" name="email-duplicado" value="false"/>
                                <span id="checking-email" class="hidden">Checando email...</span>
                                <span id="email-cadastrado" class="hidden erro-not-found"><b>Erro:</b> E-mail j&aacute; cadastrado.</span>
                            </span>
                            <span>
                                <input type="password" name="senha" placeholder="Nova senha">
                                <span>No m&iacute;nimo 6 caracteres</span>
                            </span>
                            <span>
                                <input type="password" name="senha_confirmar" placeholder="Confirmar nova senha">
                            </span>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>

        <p class="sub-title tMargin30">
            <b class="versalete">Endereço</b>
        </p>

        <div class="big-widget">
            <div class="widget">
                <div class="widget-bottom">
                    <div class="widget-content">
                        <div class="textwidget extrato">
                            <span>
                                <select name="pais" style="width: 317px; margin: 10px 20px 0 0;">
                                    <? foreach($paises as $pais): ?>
                                        <? $selected = ""; ?>
                                        <? if($pais->cod == 30): ?>
                                            <? $selected = "selected='selected'"; ?>
                                        <? endif; ?>
                                        <option <?=$selected?> value="<?=$pais->cod?>"><?=$pais->pais?></option>
                                    <? endforeach; ?>
                                </select>
                            </span>
                            <span>
                                <input type="text" name="estado" placeholder="Estado">
                                <input type="hidden" name="estado_id" />
                                <span id="estado-not-found" class="hidden erro-not-found"><b>Erro:</b> Nenhum resultado encontrado</span>
                            </span>
                            <span>
                                <input type="text" name="cidade" placeholder="Cidade">
                                <input type="hidden" name="cidade_id" />
                                <span id="cidade-not-found" class="hidden erro-not-found"><b>Erro:</b> Nenhum resultado encontrado</span>
                            </span>
                        </div>
                    </div> <!-- end .widget-content-->
                </div> <!-- end .widget-bottom-->
            </div>
        </div>
        
        <div style="margin: 10px 0;">
            <input type="checkbox" name="termos" id="termos"/>
            <span>
                <label for="termos">Declaro que li e aceito os <a target="_blank" href="http://www.taromancia.com.br/index.php/termos-e-condicoes-de-uso/">termos de uso do site</a>.</label>
            </span>
        </div>
        <div class="clearfix tMargin30">
            <a id="btnSubmit" class="newGreenButton submit"><span>Enviar</span></a>
            <button type="submit" class="hidden" />
        </div>
    </form>
</div>
<script type='text/javascript' src='<?=base_url()?>assets/js/plugins/jquery.maskedinput.min.js'></script>
<script>
var CHECKING_EMAIL = false;    
var ESTADOS = [];
var CIDADES = {};

<? foreach($estados as $estado): ?>
ESTADOS.push({cod : <?=$estado->cod?>, label : '<?=$estado->estado?>, <?=$estado->sigla?>'});
<? endforeach; ?>

<? foreach($cidades as $k => $cidadePorEstado): ?>
CIDADES.estado<?=$k?> = [];
<? endforeach; ?>

<? foreach($cidades as $k => $cidadePorEstado): ?>
<? 		foreach($cidadePorEstado as $cidade): ?>
CIDADES.estado<?=$k?>.push({cod : <?=$cidade->cod?>, label : '<?=$cidade->cidade?>'});
<? 		endforeach; ?>
<? endforeach; ?>

function checkEmail(){
    // checa se ja esta checando
    if(CHECKING_EMAIL){
        return false;
    }
    
    // seta como esta checando ajax
    CHECKING_EMAIL = true;
    
    // obtem o email
    var email = $("input[name=email]").val();
    
    // valida o email
    if(RegExp("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$")
        .test(email) == false){
        
        CHECKING_EMAIL = false;
        
        return false;
    }
    
    // esconde o erro se houver
    $("#email-cadastrado").hide();
    
    // mostra a msg carregando
    $("#checking-email").fadeIn();
    
    // checa se ja existe
    $.ajax({
        type: "POST",
        url: "<?=site_url()?>"+"/login/checkEmailIfExists",
        data: { email: email }
    }).done(function( msg ) {
        // seta como terminou de checar
        CHECKING_EMAIL = false;
        
        if(msg == "true"){
            // esconde a msg carregando
            $("#checking-email").fadeOut(400, function(){
                // mostra o erro
                $("#email-cadastrado").fadeIn();
            });
            
            // seta a flag de validacao
            $("input[name=email-duplicado]").val("true");
        }else{
            // esconde a msg carregando
            $("#checking-email").fadeOut();
        
            // seta a flag de validacao
            $("input[name=email-duplicado]").val("false");
        }
    });
}

$("document").ready(function(){
    
    $("input[name=email]").blur(function(){
        checkEmail();
    });
    $("input[name=email]").focusout(function(){
        checkEmail();
    });
    
    $("input[name=email]").keypress(function(){
       // retira a msg de erro se houver
       $("#email-cadastrado").hide();
    });
    
    // define as mascaras
    $("input[name=data_nascimento]").mask("99/99/9999");
    $("input[name=telefone]").focusout(function(){
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if(phone.length > 12) {
            element.mask("(99)(99) 99999-999?9");
        } else {
            element.mask("(99)(99) 9999-9999?9");
        }
    }).trigger('focusout');
    
    // define os eventos
    $("input[name=estado]").keypress(function(){
        // limpa o id do estado
    });
    
    // define o evento de submit do form
    $("a.submit").click(function(evt){
        evt.preventDefault();
        
        // flag de validacao
        var valid = true;
        
        // variavel de mensagens de erro
        var errorMsgs = "";
        
        // valida o nome completo
        if(RegExp("^.{3,80}$").test($("input[name=nome]").val()) == false){
            valid = false;
            errorMsgs += "Campo 'Nome' preenchido incorretamente \n";
        }
        // valida o nascimento
        if(RegExp("(0[1-9]|[012][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}")
            .test($("input[name=data_nascimento]").val()) == false){
            valid = false;
            errorMsgs += "Campo 'Data de Nascimento' preenchido incorretamente \n";
        }
        // valida o email
        if(RegExp("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$")
            .test($("input[name=email]").val()) == false){
            valid = false;
            errorMsgs += "Campo 'E-mail' preenchido incorretamente \n";
        }
        if($("input[name=email-duplicado]").val() == "true"){
            valid = false;
            errorMsgs += "O email escolhido ja esta cadastrado no sistema\n";
        }
        // valida a senha
        if(RegExp("^.{6,20}$").test($("input[name=senha]").val()) == false 
        || RegExp("^.{6,20}$").test($("input[name=senha_confirmar]").val()) == false
        || $("input[name=senha]").val() != $("input[name=senha_confirmar]").val() ){
             valid = false;
             errorMsgs += "Campo 'Senha' ou 'Confirmar senha' preenchido incorretamente \n";
        }
        // valida o estado
        if(RegExp("^.{4,30}$").test($("input[name=estado]").val()) == false){
             valid = false;
             errorMsgs += "Campo 'Estado' preenchido incorretamente \n";
        }
        if($("select[name=pais]").val() == 30){
            if(isNaN($("input[name=estado_id]").val()) || $("input[name=estado_id]").val() <= 0){
                valid = false;
                errorMsgs += "Campo 'Estado' preenchido incorretamente \n";
            }
        }
        // valida a cidade
        if(RegExp("^.{4,30}$").test($("input[name=cidade]").val()) == false){
             valid = false;
             errorMsgs += "Campo 'Cidade' preenchido incorretamente \n";
        }
        if($("select[name=pais]").val() == 30){
            if(isNaN($("input[name=cidade_id]").val()) || $("input[name=cidade_id]").val() <= 0){
                valid = false;
                errorMsgs += "Campo 'Cidade' preenchido incorretamente \n";
            }
        }
        // valida o telefone
        if(RegExp("^.{18,19}$").test($("input[name=telefone]").val()) == false){
             valid = false;
             errorMsgs += "Campo 'Telefone' preenchido incorretamente \n";
        }
        // valida a profissao
        if(RegExp("^.{3,80}$").test($("input[name=profissao]").val()) == false){
             valid = false;
             errorMsgs += "Campo 'Profissao' preenchido incorretamente \n";
        }
        // valida a posicao
        if(RegExp("^.{3,80}$").test($("select[name=posicao]").val()) == false){
             valid = false;
             errorMsgs += "Campo 'Posicao' preenchido incorretamente \n";
        }
        if($("select[name=posicao]").val() == "Outros" && RegExp("^.{3,80}$").test($("input[name=posicao_outros]").val()) == false){
            valid = false;
            errorMsgs += "Informe o campo 'Outros' da posicao \n";
        }
        // valida os termos de uso
        if(!$("input[name=termos]").is(":checked")){
            valid = false;
            errorMsgs += "Marque a opcao dos termos de uso do site!";
        }
        
        if(!valid){
            alert(errorMsgs);
            return false;
        }
        
        // submita
        $("#form").submit();
    });
    
    // define os autocompletes
    $("input[name=estado]").autocomplete({
        source: function(request, response){
            if($("select[name=pais]").val() == 30){
                response($.ui.autocomplete.filter(ESTADOS, request.term));
            }else{
                return false;
            }
        },
        minLength: 2,
        response : function(event, ui){
            // se nao encontrou nada
            if(ui.content.length == 0){
                // limpa o input e o id
                $("input[name=estado],input[name=estado_id]").val("");
                
                // mostra a msg de erro
                $("#estado-not-found").fadeIn(500, function(){
                    // da um timeout
                    setTimeout(function(){
                        // esconde a msg de erro
                        $("#estado-not-found").fadeOut();
                    }, 1500);
                });
            }
        },
        select: function( event, ui ) {
            if(ui.item){
                if(parseInt(ui.item.cod) <= 0){
                    $("input[name=estado_id]").val("");
                }else{
                    $("input[name=estado_id]").val(ui.item.cod);
                }
            }else{
                $("input[name=estado_id]").val("");
            }
        }
    });
    $("input[name=cidade]").autocomplete({
        source: function(request, response){
            if($("select[name=pais]").val() == 30){
                // limpa a cidade_id
                $("input[name=cidade_id]").val("");
                
                // obtem o estado selecionado
                var estado = $("input[name=estado_id]").val();
                
                // valida 
                if(parseInt(estado) <= 0 || isNaN(parseInt(estado))){
                    return false;
                }
                
                // busca a cidade do estado selecionado
                response($.ui.autocomplete.filter(eval("CIDADES.estado"+estado), request.term));
                
            }else{
                return false;
            }
        },
        minLength: 3,
        response : function(event, ui){
            // se nao encontrou nada
            if(ui.content.length == 0){
                // limpa o input
                $("input[name=cidade],input[name=cidade_id]").val("");
                
                // mostra a msg de erro
                $("#cidade-not-found").fadeIn(500, function(){
                    // da um timeout
                    setTimeout(function(){
                        // esconde a msg de erro
                        $("#cidade-not-found").fadeOut();
                    }, 1500);
                });
            }
        },
        select: function( event, ui ) {
            if(ui.item){
                if(parseInt(ui.item.cod) <= 0){
                    $("input[name=cidade_id]").val("");
                }else{
                    $("input[name=cidade_id]").val(ui.item.cod);
                }
            }else{
                $("input[name=cidade_id]").val("");
            }
        }
    });
    
});
</script>