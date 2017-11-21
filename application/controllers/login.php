<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public function activate(){
        // obtem o token
        $md5 = $this->input->get("token");
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        try{
            // busca o cadastro
            $usuario = $this->login->get(array("md5_ativacao" => $md5));
        }catch(Exception $e){
            // todo tratamento de erro
        }
        
        try{
            // ativa o cadastro
            $result = $this->login->activateByID($usuario->cod);
        }catch(Exception $e){
            // todo tratamento de erro
        }
        
        // envia o e-mail de ativacao do usuario
        $this->sendEmailNovoUsuarioAtivado($usuario);
        
        // carrega a view com a resposta
        $this->template->view("login_activate", array(
            "title"  => "Cadastro ativado com sucesso"
        ));
    }
    
    public function signup()
    {
        // carrega as models
        $this->load->model("pais_model", "pais");
        $this->load->model("estado_model", "estado");
        $this->load->model("cidade_model", "cidade");

        // checa se veio da tela de compra
        @session_start();
        $compra = $_SESSION['compra'];
        
        try{
            // obtem os paises
            $paises = $this->pais->get();
        }catch(Exception $e){
            // TODO
        }
        
        try{
            // obtem os estados do brasil
            $estados = $this->estado->get(array(
                "pais" => 30 // brasil
            ));
            
            // obtem as cidades
            $cidadesBD = $this->cidade->get();
        }catch(Exception $e){
            // TODO
        }
        
        $cidades = array();
        
        // organiza as cidades
        foreach($cidadesBD as $cidade){
            $cidades[$cidade->cod_estado][] = $cidade;
        }
        
        $this->template->view("login_signup", array(
            "title"   => "Cadastre-se",
            "paises"  => $paises,
            "estados" => $estados,
            "cidades" => $cidades,
            "compra" => $compra
        ));
    }
    
    public function doSignup(){
        // variavel dos parametros
        $data = array();
        
        // carrega o helper
        $this->load->helper("date_helper");
        
        // obtem os parametros
        $data["nome"]            = $this->input->post("nome");
        $data["data_nascimento"] = human_to_sql($this->input->post("data_nascimento"));
        $data["email"]           = $this->input->post("email");
        $data["senha"]           = md5($this->input->post("senha"));
        $data["cod_pais"]        = $this->input->post("pais");
        $data["profissao"]       = $this->input->post("profissao");
        $telefone                = $this->input->post("telefone");
        $senhaConfirmar          = md5($this->input->post("senha_confirmar"));
        $cidadeID 		 = $this->input->post("cidade_id");
        $estadoID 		 = $this->input->post("estado_id");
        $estado   		 = $this->input->post("estado");
        $cidade   		 = $this->input->post("cidade");
        $posicao                 = $this->input->post("posicao");
        $posicaoOutros           = $this->input->post("posicao_outros");

        // TODO validar os parametros
        
        // se for pais brasil obtem os ids do estado e cidade
        if($cidadeID != "" && is_numeric($cidadeID)){
                $data["cod_cidade"] = $cidadeID;
        }
        if($estadoID != "" && is_numeric($estadoID)){
                $data["cod_estado"] = $estadoID;
        }
        if($estado != "" && is_numeric($estado)){
                $data["estado_outro"] = $estado;
        }
        if($cidade != "" && is_numeric($cidade)){
                $data["cidade_outro"] = $cidade;
        }
        
        // checa a posicao
        if($posicao == "Outros"){
            $data["posicao"] = $posicaoOutros;
        }else{
            $data["posicao"] = $posicao;
        }
        
        // formata o telefone 
        $data["ddi"] = substr($telefone, 1, 2);
        $data["ddd"] = substr($telefone, 5, 2);
        $data["telefone"] = str_replace("-","",substr($telefone, 9, strlen($telefone)));
        
        // monta o token de ativacao
        $data["md5_ativacao"] = md5($data["nome"].$data["email"]."oracvlvm2013".time());

        // ja cadastra como ativo
        $data['ativo'] = 1;
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        try{
            // insere o usuario
            $this->login->save($data);
        }catch(Exception $e){
            // TODO tratamento de erro
        }
        
        // obtem o id inserido
        $usuarioID = $this->db->insert_id();
        
        // envia o link de ativacao
        // DESATIVADO
        //$this->sendActivationLink($usuarioID);

        // ja loga o usuario
        $this->doSignin($data['email'], $data['senha']);

        die;
        
        // carrega a view com a resposta
        $this->template->view("login_do_signup", array(
            "title"  => "Cadastro feito com sucesso"
        ));
    }

     public function doSaveCadastro(){
        // variavel dos parametros
        $data = array();
        
        // carrega o helper
        $this->load->helper("date_helper");
        
        // obtem os parametros
        $data["nome"]            = $this->input->post("nome");
        $data["data_nascimento"] = human_to_sql($this->input->post("data_nascimento"));
        $data["email"]           = $this->input->post("email");
        $data["cod_pais"]        = $this->input->post("pais");
        $data["profissao"]       = $this->input->post("profissao");
        $telefone                = $this->input->post("telefone");
        $cidadeID                = $this->input->post("cidade_id");
        $estadoID                = $this->input->post("estado_id");
        $estado                  = $this->input->post("estado");
        $cidade                  = $this->input->post("cidade");
        $posicao                 = $this->input->post("posicao");
        $posicaoOutros           = $this->input->post("posicao_outros");

        $trocarSenha = false;

        // checa se houve mudanca de senha
        if(trim($this->input->post("senha")) != ""){
            $trocarSenha             = true;
            $data["senha"]           = md5($this->input->post("senha"));
            $senhaConfirmar          = md5($this->input->post("senha_confirmar"));
        }

        // TODO validar os parametros
        
        // se for pais brasil obtem os ids do estado e cidade
        if($cidadeID != "" && is_numeric($cidadeID)){
                $data["cod_cidade"] = $cidadeID;
        }
        if($estadoID != "" && is_numeric($estadoID)){
                $data["cod_estado"] = $estadoID;
        }
        if($estado != "" && is_numeric($estado)){
                $data["estado_outro"] = $estado;
        }
        if($cidade != "" && is_numeric($cidade)){
                $data["cidade_outro"] = $cidade;
        }
        
        // checa a posicao
        if($posicao == "Outros"){
            $data["posicao"] = $posicaoOutros;
        }else{
            $data["posicao"] = $posicao;
        }
        
        // formata o telefone 
        $data["ddi"] = substr($telefone, 1, 2);
        $data["ddd"] = substr($telefone, 5, 2);
        $data["telefone"] = str_replace("-","",substr($telefone, 9, strlen($telefone)));
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        try{
            // salva o usuario
            $this->login->save($data, Auth::getData("cod"));
        }catch(Exception $e){
            // TODO tratamento de erro
        }
        
        // carrega a view com a resposta
        $this->template->view("login_do_save_cadastro", array(
            "title"  => "Cadastro Atualizado com sucesso"
        ));
    }
    
    public function signin(){
        
        // obtem a sessao
        @session_start();
        
        $pedido = $casasPreenchidas = $setorVidaCod = $redirectUrl = null;
        
        // checa se possui algum pedido na sessao e guarda
        if(isset($_SESSION["pedido"]) && !is_null($_SESSION["pedido"])){
            $pedido = $_SESSION["pedido"];
        }
        
        // checa se possui alguma url de redirect setada
        if(isset($_SESSION["redirect_url"])){
            $redirectUrl = $_SESSION["redirect_url"];
        }

        if(isset($_SESSION["source_url"])){
            $sourceURL = $_SESSION["source_url"];
        }
        
        // destroi a sessao atual
        $_SESSION["logged"] = false;
        @session_destroy();
        
        // salva os dados
        @session_start();
        $_SESSION["pedido"] = $pedido;

        if(isset($sourceURL)){
            $_SESSION["source_url"] = $sourceURL;
        }
        
        $this->template->view("login_login", array(
            "title"  => "Oracvlvm",
            "verticalTabs" => true
        ));
    }

    public function signinUsuarioLite(){
        
        // obtem a sessao
        @session_start();

        if(isset($_SESSION["source_url"])){
            $sourceURL = $_SESSION["source_url"];
        }
        
        // destroi a sessao atual
        $_SESSION["logged"] = false;
        @session_destroy();
        
        // salva os dados
        @session_start();

        if(isset($sourceURL)){
            $_SESSION["source_url"] = $sourceURL;
        }

        $cadastroFull = false;

        if(strstr($sourceURL, "pedido/mapeamento")){

            $cadastroFull = true;
        }
        
        $this->template->view("login_sign_usuario_lite", array(
            "title"  => "Entre com seus dados",
            "cadastroFull" => $cadastroFull
        ));
    }
    
    public function doSignin($email = null, $senha = null)
    {
        $this->load->model("url_jogo_model", "url_jogo");

        if(is_null($email) == true AND is_null($senha) == true)
        {
            // obtem os parametros
            $email = $this->input->post("email");
            $senha = $this->input->post("senha");
        }

        if(isMd5($senha) == false)
        {
            $senha = md5($senha);
        }
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        try{
            $login = $this->login->get(array(
               "email" => $email,
               "senha" => $senha,
			   "ativo" => true
            ));
        }catch(Exception $e){
            // todo tratar erro
        }
        
        if(count($login) <= 0){
            // login nao encontrado retorna a pagina de login
            return $this->signin();
        }
        
        try{
            // busca o saldo do login
            $saldo = $this->login->getSaldo(array(
                "cod_usuario" => $login->cod
            ));
        }catch(Exception $e){
            // todo tratar erro
        }
        
        // armazena o saldo
        $login->saldo = $saldo;
        
        // monta a session
        @session_start();
        
        // armazena
        $_SESSION["usuario"] = serialize((array)$login);
        $_SESSION["logged"] = true;

        // checa o source URL
        if(isset($_SESSION["source_url"]) && !is_null($_SESSION["source_url"])){

            // armazena
            $url = $_SESSION["source_url"];

            // limpa
            unset($_SESSION["source_url"]);

            // redireciona
            redirect($url);
        }
        
        // checa se tem pedido salvo na session
        if(isset($_SESSION["pedido"]) && !is_null($_SESSION["pedido"])){
            // obtem o pedido
            $pedido = unserialize($_SESSION["pedido"]);
            
            // monta os params da url
            $params = "?ama=".$pedido["arcanoMaiorCod"]."&ame1=".$pedido["arcanoMenor1Cod"]
                      ."&ame2=".$pedido["arcanoMenor2Cod"];
            
            // limpa o pedido da session
            unset($_SESSION["pedido"]);
            
            // encaminha para a tela da compra
            redirect("compra/confirmar".$params);
        }

        // checa se tem compra de jogo completo na session
        $this->load->library("session");
        $token = $this->session->userdata("token_jogo");
        if(isMd5($token)){
            redirect("compra/jogo/confirm");
        }
        
        // encaminha para a tela principal
        redirect("tarot/escolherSetor");
        
        /*
        $this->template->view("login_dosignin", array(
           "title"  => "Login efetuado com sucesso"
        ));
         * 
         */
    }

    public function doSigninUsuarioLite(){
        
        // helper
        $this->load->helper("date_helper");

        // obtem os parametros
        $email = $this->input->post("email");
        $nome  = $this->input->post("nome");
        $dataNascimento = human_to_sql($this->input->post("data_nascimento"));
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        try{
            $login = $this->login->get(array(
               "email" => $email,
               "ativo" => true
            ));
        }catch(Exception $e){
            // todo tratar erro
        }
        
        // login nao registrado ?
        if(count($login) <= 0){

            // valida
            if(strlen(trim($email)) <= 0 OR strlen(trim($dataNascimento)) <= 0){

                die("erro na validacao dos dados");
            }
            
            // registra o login simples
            $codUsuario = $this->login->save(array(
                "email" => $email,
                "nome"  => $nome,
                "data_nascimento" => $dataNascimento,
                "cod_usuario_tipo" => 2,
                "ativo" => 1
            ));

            // busca o usuario recem-cadastrado
            $login = $this->login->get(array("usuarioID" => $codUsuario));
        }
        
        try{
            // busca o saldo do login
            $saldo = $this->login->getSaldo(array(
                "cod_usuario" => $login->cod
            ));
        }catch(Exception $e){
            // todo tratar erro
        }
        
        // armazena o saldo
        $login->saldo = $saldo;
        
        // monta a session
        @session_start();
        
        // armazena
        $_SESSION["usuario"] = serialize((array)$login);
        $_SESSION["logged"] = true;

        // checa o source URL
        if(isset($_SESSION["source_url"]) && !is_null($_SESSION["source_url"])){

            // armazena
            $url = $_SESSION["source_url"];

            // limpa
            unset($_SESSION["source_url"]);

            // redireciona
            redirect($url);
        }
        
        // encaminha para a tela principal
        redirect("tarot/escolherSetor");
    }
    
    public function sendActivationLink($usuarioID){
        // carrega o model
        $this->load->model("login_model", "login");
        
        try{
            // busca o usuario no banco
            $usuario = $this->login->get(array("usuarioID" => $usuarioID));
            
        }catch(Exception $e){
            // todo tratamento de erro
        }
        
        // monta o from
        $recipient = $usuario->email;
        
        // seta o assunto
        $subject   = "Ativação do cadastro - Oracvlvm";

        // monta a mensagem
        $msg = 	"Clique no link abaixo para ativar seu cadastro<br/><br/><br/>".
                        "<b>Link:</b> ".site_url()."/login/activate?token=".$usuario->md5_ativacao."<br/><br/>";

        // monta os headers
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Oracvlvm <oracvlvm@ORACVLVM.COM>' . "\r\n";

        // dispara o email
        mail($recipient, $subject, $msg, $headers);
        
        // envia o email para informar sobre o novo cadastro
        $recipient = "rackel.santos@gmail.com";
        
        // seta o assunto
        $subject = "Novo usuário cadastrado";
        
        // monta a mensagem
        $msg = "Um novo usuário se cadastrou no site, nome: ". $usuario->nome . ", email: " . $usuario->email
               ."<br/><br/><br/>Lembre-se que ainda falta este usuário ativar seu cadastro."
               ."<br/><br/><br/>Obs: Este e-mail foi enviado pelo sistema desenvolvido pelo gostosão do seu marido.";

        // aguarda um tempo para nao caracterizar spam
        sleep(0.4);
        
        // dispara o email
        mail($recipient, $subject, $msg, $headers);
    }
    
    public function forgotPassword(){
        
        $this->template->view("login_forgot_password", array("title" => "Recupera&ccedil;&atilde;o de senha"));
    }
    
    public function sendMailPasswordLost(){
        // obtem o parametro
        $email = $this->input->post("email");
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        // busca o usuario
        $usuario = $this->login->get(array("email" => $email));
        
        // valida o usuario
        if(is_object($usuario) == false || isset($usuario->cod) == false){
            die("Erro: Email invalido");
        }
        
        // monta o from
        $recipient = $usuario->email;
        
        // seta o assunto
        $subject = "Link para recuperação da senha";

        // monta a mensagem
        $msg = 	"Clique no link abaixo para cadastrar uma nova senha<br/><br/><br/>".
                        "<b>Link:</b> <a href='".site_url()."/login/newPassword?token=".$usuario->md5_ativacao."'>".
                            site_url()."/login/newPassword?token=".$usuario->md5_ativacao.
                        "</a><br/><br/>";

        // monta os headers
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Oracvlvm <oracvlvm@ORACVLVM.COM>' . "\r\n";

        // dispara o email
        $result = mail($recipient, $subject, $msg, $headers);
        
        $this->template->view("login_send_mail_password_lost", array("title" => "Recuperação de Senha"));
    }
    
    public function newPassword(){
        // obtem o token
        $md5 = $this->input->get("token");
        
        // valida o md5
        if(isMd5($md5) == false){
            die("Erro: token invalido.");
        }
        
        // carrega a model
        $this->load->model("login_model", "login");
        
        // busca o usuario pelo token
        $usuario = $this->login->get(array("md5_ativacao" => $md5));
        
        // valida o usuario
        if(is_object($usuario) == false || isset($usuario->cod) == false){
            die("Erro: token invalido.");
        }
        
        // carrega a tela
        $this->template->view("login_new_password", array(
            "title"   => "Definir nova senha",
            "usuario" => $usuario
        ));   
    }
    
    public function doNewPassword(){
        // obtem os parametros
        $md5   = $this->input->post("token");
        $senha = $this->input->post("senha");
        
        // valida o md5
        if(isMd5($md5) == false){
            die("Erro: token invalido.");
        }
        
        // carrega a model 
        $this->load->model("login_model", "login");
        
        // executa a troca da senha
        $result = $this->login->changePasswordByMd5(array("md5_ativacao" => $md5, "senha" => md5($senha)));
        
        $this->template->view("login_do_new_password", array("title" => "Senha alterada com sucesso"));
    }
    
    public function checkEmailIfExists(){
        // obtem o email
        $email = $this->input->post("email");

        // obtem o usuario
        $codUsuario = $this->input->post("codUsuario");
        
        // carrega a model
        $this->load->model("login_model", "login");

        // checa se passa para ignorar o usuario atual
        if(is_numeric($codUsuario) AND $codUsuario > 0){

            $result = $this->login->get(array("email" => $email, "cod_usuario_not" => $codUsuario));

        }else{
            $result = $this->login->get(array("email" => $email));
        }
        
        
        
        if(is_object($result) && isset($result->cod)){
            die("true");
        }else{
            die("false");
        }
    }
    
    public function sendEmailNovoUsuarioAtivado($usuario){
        // envia o email de boas vindas para o usuario
        $recipient = $usuario->email;
        
        // seta o assunto
        $subject = "Combinações do Tarot";
        
        // monta a mensagem
        $msg = $this->getWelcomeMessage($usuario);
        
        // monta os headers
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Oracvlvm <atendimento@ORACVLVM.COM>' . "\r\n";
        
        // dispara o email
        mail($recipient, $subject, $msg, $headers);


        // envia o email para informar sobre o novo cadastro ativado
        $recipient = "rackel.santos@gmail.com";
        
        // seta o assunto
        $subject = "Novo usuário ativado";
        
        // monta a mensagem
        $msg = "Um novo usuário se cadastrou no site e ativou o cadastro, nome: ". $usuario->nome . ", email: " . $usuario->email
               ."<br/><br/><br/>Obs: Este e-mail foi enviado pelo sistema desenvolvido pelo gostosão do seu marido.";
        
        // monta os headers
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Oracvlvm <atendimento@ORACVLVM.COM>' . "\r\n";
        
        // dispara o email
        mail($recipient, $subject, $msg, $headers);
    }

    public function getWelcomeMessage($usuario){
        $msg =  "<p>Olá <b>". $usuario->nome . ",</b></p>"
                ."<p style='text-align: justify'>Se você é profissional do taro ou joga cartas para si mesmo, já pensou em um sistema que disponibiliza mais de 7 milhões de combinações do tarot ? Se sim acesse a área profissional agora mesmo e veja a amostra gratuita em: <a href='http://www.oracvlvm.com/tarot/index.php/tarot/escolherSetor'>Faça seu Jogo</a>. Este jogo é especifico para quem joga as cartas em sua própria mesa em sua casa e apenas retira o resultado em nosso sistema.</p>"
                ."<p style='text-align: justify'>Clique em: <a href='http://www.oracvlvm.com/index.php/combinacoes-do-taro/'>Ver Combinações Disponíveis</a>  e veja as que já estão prontas para a visualização. E veja os principais benefícios que estão ativos em seu cadastro</p>"
                ."<p style='text-align: justify'><b>Mapeamentos salvos</b><br/>Você pode acompanhar as previsões e reler quantas vezes achar necessário. A cada jogo completo realizado será armazenado em seu cadastro automaticamente;</p>"
                ."<p style='text-align: justify'><b>Compra de conteúdo permanente</b><br/>Cada combinação custa apenas R$1,00, e o mapeamento completo, R$10,00. Isso quer dizer que se eventualmente houver outros jogos em qualquer setor, e se, cair a mesma combinação do jogo anterior não será cobrado novamente;</p>"
                ."<p style='text-align: justify'><b>Atualização gratuita de conteúdo</b><br/>Nosso banco de dados atual conta com quase sete milhões de combinações somente para o jogo da cruz celta. E ainda estamos atualizando todo o conteúdo para atingir o máximo de precisão e coerência no jogo. Quando o seu mapeamento for salvo, você terá mais conteúdo e cada vez com mais qualidade. Pois os nossos especialistas em significação atualizarão o conteúdo do sistema constantemente.</p>"
                ."<p style='text-align: justify'><b>Média de dez a 30 páginas de conteúdo</b><br/>Em nossa página do site, você terá dez páginas de conteúdo que são as dez casas da cruz celta interpretada. Mas em um arquivo word podemos chegar de dez a 30 páginas só de texto. Porque podemos proporcionar um conteúdo robusto com muita informação sobre a sua consulta;</p>"
                ."<p style='text-align: justify'><b>Conheça o que vem por ai</b><br/>1.Cursos gratuitos presencial em São Paulo<br/>2.Videos comentando sobre a taromancia<br/>3.Centenas de monografias virtuais com significados detalhados das cartas como você nunca viu !<br/>4.Atualização do sistema para deixar sua experiência mais dinâmica com o Oracvlvm<br/>5. instruções gratuitas e inéditas!</p>"
                ."<p style='text-align: justify'>Se você é um cliente e deseja apenas uma consulta, acesse: <a href='http://www.oracvlvm.com/tarot/index.php/jogo/escolherSetorVida'>Consulta Virtual</a>  e boa orientação.</p>"
                ."<p style='text-align: justify'>Permanecemos à sua inteira disposição em nosso atendimento por e-mail.</p>"
                ."<p>Atenciosamente,</p>"
                ."<p>Raquel Oliveira<br/><a href='http://www.oracvlvm.com'>wwww.oracvlvm.com</a><br/>"
                ."<a href='http://www.oracvlvm.com'><img src='http://www.oracvlvm.com/wp-content/uploads/2013/01/Oracvlvmlogopequeno2.png'/></a></p>";


        return $msg;

    }

    public function saveCadastro(){

        // checa se esta logado
        $this->auth->check();

        // carrega as models
        $this->load->model("pais_model", "pais");
        $this->load->model("estado_model", "estado");
        $this->load->model("cidade_model", "cidade");
        $this->load->model("login_model", "login");
        
        try{
            // obtem os paises
            $paises = $this->pais->get();
        }catch(Exception $e){
            // TODO
        }
        
        try{
            // obtem os estados do brasil
            $estados = $this->estado->get(array(
                "pais" => 30 // brasil
            ));
            
            // obtem as cidades
            $cidadesBD = $this->cidade->get();
        }catch(Exception $e){
            // TODO
        }
        
        $cidades = array();
        
        // organiza as cidades
        foreach($cidadesBD as $cidade){
            $cidades[$cidade->cod_estado][] = $cidade;
        }

        // obtem o usuario
        $login = $this->login->get(array("usuarioID" => Auth::getData("cod")));

        // ajusta o telefone
        $countTelefone = (strlen($login->telefone) == 8) ? 4 : 5;
        $login->telefone = substr($login->telefone, 0, $countTelefone) . "-" . substr($login->telefone, $countTelefone, 4);

        // define um array das posicoes que nao esta no bd
        $posicoes = array("Aluno", "Apenas Cliente", "Professor de Tar&ocirc;", "Tarologista", "Outros");

        // carrega o helper necessario
        $this->load->helper("date_helper");
        
        $this->template->view("login_save_cadastro", array(
            "verticalTabs" => true,
            "title"   => "Meu Cadastro",
            "paises"  => $paises,
            "estados" => $estados,
            "cidades" => $cidades,
            "posicoes" => (object) $posicoes,
            "login"   => $login,
            "menuLateral"           => false
        ));
    }
}

?>