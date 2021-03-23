<!DOCTYPE html>
<html lang="pt-br">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NGProc</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <!-- Multiselect -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <link rel="stylesheet" href="css/register.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        /*ESTILIZANDO O MULTISELECT (PLUGIN SELECT2) DO CADASTRO DE PARCEIROS*/
        /* Caixa de seleção */
        .select2-container--default .select2-selection--multiple {
            border-radius: 36px;
            width: 100%;
            max-height: 68px;
            overflow-y: auto;

        }

        /* Barra de rolagem da caixa de seleção */
        .select2-container--default .select2-selection--multiple::-webkit-scrollbar {
            display: none;
        }

        /* Caixa de seleção em foco*/
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-radius: 36px;
            padding: 5px 10px;
        }

        /*Item escolhido localizado dentro da caixa de seleção*/
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #367fa9;
        }

        /*Item escolhido marcado dentro da lista de seleção*/
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #367fa9;
            color: #fff;
        }

        /*Item ao passar o mouse por cima*/
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #367fa9;
        }

        /* botão de excluir o item selecionado */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }
    </style>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script>
        //converte input para letras maiusculas
        function maiuscula(z) {
            v = z.value.toUpperCase();
            z.value = v;
        }
    </script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157059873-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-157059873-2');
    </script>
    
    <!-- Global site tag (gtag.js) - Google Ads: 665648971 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-665648971"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'AW-665648971');
    </script>
</head>

<body class="hold-transition login-page">

    <div class="login-container">
        <div class="row">
            <div class="col-md-6">
                <div class="login-banner" style="background-image: url('img/Imagem-logo-login.png');"></div>
            </div>
            <div class="col-md-6 etapa1" id="etapa1" style="display:block">
                <!-- /.login-logo -->
                <div class="login-box-body">
            <form action="./php/register.php" method="post" id="form-register">
                    <h1>Vamos começar?</h1>
                    <div class="linha-titulo"></div>
                        <?php
                        if(isset($_GET['erro'])){
                            if($_GET['erro'] == 1){
                                echo '<div class="alert alert-danger" role="alert"><b>Ops!</b> Seu cadastro não pode ser finalizado.</div>';
                            }
                        }
                        ?>
                        <div class="register-subtitle">
                            Em qual perfil você se encaixa?
                        </div>
                        <div class="opcoes-cliente">
                            <input type="radio" id="cliente-radio" name="role" value="1"> Cliente<br><br>
                            <input type="radio" id="parceiro-radio" name="role" value="2"> Parceiro<br>
                        </div>
                        <button type="button" id="button-et1"
                            class="btn btn-primary btn-block btn-flat btn-login-custom btn-avancar">Avançar</button>

                        <hr />
                    <div style="text-align: center;margin-top: -9px">
                        <a href="http://login.ngproc.com.br/users/login"  class="text-center" style="text-decoration: underline">Já tem uma conta?</a>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 etapa2" id="etapa2" style="display:none">
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                        <h1>Vamos começar?</h1>
                        <div class="linha-titulo"></div>
                        <div class="register-subtitle">
                            Em qual tipo de inscrição?
                        </div>
                        <div class="form-etapa2" id="form-etapa2" style="margin: 10px">
                            <div class="form-group has-feedback">
                                <input type="radio" name="tpdoc" value="1"> Pessoa Física <br /><br />
                                <input type="radio" name="tpdoc" value="2"> Pessoa Jurídica
                                <button type="button" id="button-et2"
                                    class="btn btn-primary btn-block btn-flat btn-login-custom btn-avancar">Avançar</button>
                            </div>
                        </div>
                        <hr />
                    <div style="text-align: center;margin-top: -9px">
                        <a href="http://login.ngproc.com.br/users/login" class="text-center" style="text-decoration: underline" >Já tem uma conta?</a>
                    </div>
                    </div>
                </div>

                <div class="col-md-6 etapa3" id="etapa3" style="display:none">
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                        <h1>Vamos começar?</h1>
                        <div class="linha-titulo"></div>
                        <div class="register-subtitle">
                            Qual número de inscrição?
                        </div>
                        <div class="form-etapa3" id="form-etapa3">
                            <div class="form-group has-feedback">

                                <div class="form-group has-feedback">
                                    <input type="text" id="form-cpf" name="doc_cpf" class="form-control"
                                        placeholder="Digite seu CPF">
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="text" id="form-cnpj" name="doc_cnpj" style="display:none"
                                        class="form-control " placeholder="Digite seu CNPJ">
                                </div>
                            </div>
                            <button type="button" id="button-et3"
                                class="btn btn-primary btn-block btn-flat btn-login-custom btn-prosseguir">Prosseguir</button>
                            <hr />
                        <div style="text-align: center;margin-top: -9px">
                            <a href="http://login.ngproc.com.br/users/login" class="text-center" style="text-decoration: underline" >Já tem uma conta?</a>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 etapa4" id="etapa4" style="display:none">
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                        <h1>Vamos começar?</h1>

                        <div class="form-etapa4" id="form-etapa4">

                            <div class="form-group has-feedback">
                                <div class="form-group has-feedback">
                                    <input type="text" id="form-name" name="name" class="form-control"
                                        placeholder="Nome Completo" onkeyup="maiuscula(this)" required>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="email" id="form-email" name="email" class="form-control"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" id="form-password" name="password" class="form-control"
                                        placeholder="Senha" required>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" id="form-password-confirm" name="password-register-confirm"
                                        class="form-control" placeholder="Confirmar senha" required>
                                </div>
                                <div class="form-group" style="display: none;" id="password-rule-info">
                                    <!-- <span style="font-size: 13px; color: #ff0000;">A senha deve conter no mínimo 6 caracteres: sendo ao menos 1 letra maiúscula, 1 letra minúscula e 1 símbolo</span> -->
                                    <span style="font-size: 13px; color: #ff0000;">A senha deve conter no mínimo 6
                                        caracteres.</span>
                                </div>
                            </div>
                            <button type="button" id="button-et4"
                                class="btn btn-primary btn-block btn-flat btn-login-custom btn-prosseguir">Prosseguir</button>
                            <hr />
                        <div style="text-align: center;margin-top: -9px">
                            <a href="http://login.ngproc.com.br/users/login" class="text-center" style="text-decoration: underline"  >Já tem uma conta?</a>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 etapa5" id="etapa5" style="display:none">
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                        <h1>Nos conte mais sobre você!</h1>

                        <div class="form-etapa5">
                            <div class="form-group has-feedback">
                                <h5 class="text-muted m-0">Nível de Inglês</h5>
                                <select class="form-control" id="ingles-nivel" name="english_level"
                                    placehoder="Nível de Inglês">

                                    <option value="0">Básico</option>
                                    <option value="1">Intermediário</option>
                                    <option value="2">Fluente</option>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <h5 class="text-muted m-0">Anos de experiência em Compras</h5>
                                <select class="form-control" id="exp-compras" name="purchasing_exp"
                                    placehoder="Anos de experiencia em Compras">
                                    <option value="0">Não tenho experiência</option>
                                    <?php
                                for ($i = 1; $i <= 100; $i++) :
                                    echo "<option value=\"{$i}\">{$i}</option>";
                                endfor; ?>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="hidden" id="acting_cat" name="acting_cat" required>
                                <h5 class="text-muted m-0">Categoria de atuação</h5>
                                <select style="width:100%;" class="form-control js-example-basic-single"
                                    id="cat-atuacao" multiple="multiple">
                                    <option value="0">Todas as categorias</option>
                                    <option value="29">Nenhuma das Listadas</option>
                                    <option value="1">Apps e Jogos</option>
                                    <option value="2">Bebês</option>
                                    <option value="3">Beleza</option>
                                    <option value="4">Bolsas, Malas e Mochila</option>
                                    <option value="5">Brinquedos e Jogos</option>
                                    <option value="6">Casa</option>
                                    <option value="7">CD e Vinil</option>
                                    <option value="8">Computadores e Informática</option>
                                    <option value="9">Cozinha</option>
                                    <option value="30">Material de limpeza</option>
                                    <option value="10">DVD e Blu-Ray</option>
                                    <option value="11">Eletrodomésticos</option>
                                    <option value="12">Eletrônicos</option>
                                    <option value="13">Esporte e Aventura</option>
                                    <option value="14">Ferramentas e Materiais de Construção</option>
                                    <option value="15">Games</option>
                                    <option value="16">Jardim e Piscina</option>
                                    <option value="17">Livros</option>
                                    <option value="18">Material de Escritório e Papelaria</option>
                                    <option value="19">Móveis e Decoração</option>
                                    <option value="20">Roupas, Calçados e Joias</option>
                                    <option value="21">Saúde e Cuidados Pessoais</option>
                                    <option value="22">Lista Compras Supermercado</option>
                                    <option value="23">Médico Hospitalar</option>
                                    <option value="24">Turismo</option>
                                    <option value="25">Químico</option>
                                    <option value="26">MRO</option>
                                    <option value="27">Clube de Assinaturas</option>
                                    <option value="28">Cursos Online</option>
                                    <option value="30">Outros</option>
                                </select>

                            </div>
                        </div>
                        <button type="button" id="buttom-et5"
                            class="btn btn-primary btn-block btn-flat btn-login-custom btn-prosseguir-et4">Registrar</button>
                        <hr />
                        <div style="text-align: center;margin-top: -9px">
                        <a href="http://login.ngproc.com.br/users/login" class="text-center" style="text-decoration: underline">Já tem uma conta?</a>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 etapa6" id="etapa6" style="display:none">
                    <!-- /.login-logo -->
                    <div class="login-box-body login-box-et6">
                        <h1 class="h1-et6">Dados Bancários</h1>
                        <h3 class="h3-et6">Preencha os dados para a realização de pagamentos</h3>

                        <div class="form-etapa6">
                            <div class="form-group has-feedback">
                                <input type="text" id="nome-conta" name="bank_username" class="form-control"
                                    placeholder="Nome" onkeyup="maiuscula(this)">
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" id="cpf-conta" name="bank_cpf" class="form-control"
                                    placeholder="CPF">
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" id="banco-conta" name="bank_name" class="form-control"
                                    placeholder="Banco">
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" id="agencia-conta" name="bank_agency" class="form-control"
                                    placeholder="Agência">
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" id="cc-conta" name="bank_account" class="form-control"
                                    placeholder="Conta">
                            </div>
                        </div>
                        <button type="submit" id="submit-btn5"
                            class="btn btn-primary btn-block btn-flat btn-login-custom btn-registrar-et6">Registrar
                        </button>
                        <hr />
                    <div style="text-align: center;margin-top: -9px">
                        <a href="http://login.ngproc.com.br/users/login" class="text-center" style="text-decoration: underline">Ou cadastre sua conta do Paypal</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="login-box">

            <!-- /.login-box-body -->
        </div>
    </div>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- JQuery Mask Plugin -->
    <script type="text/javascript" src="bower_components/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Multiselect - PLUGIN SELECT2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- ARQUIVO CUSTOMIZADO 'REGISTER' -->
    <script src="js/register.js"></script>
</body>

</html>