$(document).ready(()=>{
    //INICIONANDO O PLUGIN iCheck
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });

    //INICIANDO AS MÁSCARAS
    $("#form-cpf").mask("000.000.000-00");
    $("#form-cnpj").mask("00.000.000/0000-00");
    // Iniciando o plugin SELECT2 no elemeno que o utiliza
    $('.js-example-basic-single').select2({
        placeholder: "Categorias de interesse"
    });

    /*
        FUNÇÕES UTILITÁRIAS
    */

    //VALIDANDO CNPJ
    function validarCNPJ(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }
    
    //VALIDANDO CPF
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
        // Valida 1o digito	
        add = 0;
        for (i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        // Valida 2o digito	
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }

    //PULANDO PARA A TELA ETAPA 4
    function irParaEtapa4() {
        //VALIDA DOS OS CAMPOS DA ETAPA 3 E PULA PARA A ETAPA 4
        let cpf = $('#form-cpf').val();
        let cpnj = $('#form-cnpj').val();
        var radioValue = $("input[name='tpdoc']:checked").val();
        let tpUser = $("input[name='role']:checked").val(); //Parceiro ou cliente
        let body = {};
        if (radioValue == "2") {
            inscricao = cpnj;
            //form-label
            $('#form-name').attr("placeholder", "Razão social");
            if (!validarCNPJ(inscricao)) {
                swal('Por favor digite um CNPJ válido antes de prosseguir');
                return;
            }else{
                //CONSULTAR SE O CNPJ EXISTE
                body['cnpj'] = inscricao;
            }
        } else {
            inscricao = cpf;
            $('#form-name').attr("placeholder", "Nome");
            if (!validarCPF(inscricao)) {
                swal('Por favor digite um CPF válido antes de prosseguir');
                return;
            }else{
                //CONSULTAR SE CPF JÁ EXISTE NO BANCO DE DADOS
                body['cpf'] = inscricao;
            }
        }
        let p = $.post('./php/consultarInscricao.php', body);
        p.done(function response(data) {
            if(data == 1){
                swal("Cadastrado já existe!", "Clique em OK para ser redirecionado à tela de recuperação de senha")
                .then((value) => {
                    window.location.href = "http://login.ngproc.com.br/users/recover-password";
                });
            }else{
                $('#etapa3').hide();
                $('#etapa4').show();
            }
        });
        if (inscricao < 1) {
            swal('Por favor digite o CPF/CNPJ antes de prosseguir');
            return;
        }
    }

    //PULANDO PARA A TELA ETAPA 5
    function irParaEtapa5(){
        //VALIDA DOS OS CAMPOS DA ETAPA 4 E PULA PARA A ETAPA 5
        let nome = $('#form-name').val();
        let email = $('#form-email').val();
        let psw = $('#form-password').val();
        let pswc = $('#form-password-confirm').val();
        
        if (psw !== pswc) {
            swal('Senha e confirmação de senha não conferem');
            return;
        }
        if ((nome.length < 1) || (email.length < 1) || (psw.length < 1) || (pswc.length < 1)) {
            swal('Todos os campos são obrigatórios');
            return;
        } else {
            //CONSULTAR SE EMAIL JÁ EXISTE NO BANCO DE DADOS
            let body = {};
            body['email'] = email;
            let p = $.post('./php/consultarInscricao.php', body);
            p.done(function response(data) {
                if(data == 1){
                    swal("E-mail já cadastrado", "Clique em OK para ser redirecionado à tela de recuperação de senha")
                    .then((value) => {
                        window.location.href = "http://login.ngproc.com.br/users/recover-password";
                    });
                }else{
                    let radio = $("input[name='role']:checked");
                    if (radio.val() == 2) {
                        $('#etapa4').hide();
                        $('#etapa5').show();
                    } else {
                        $("#form-register").submit();
                        // $.ajax({
                        // async:true,
                        // data: $("#conteudo").serialize(),
                        // dataType:"html",
                        // beforeSend: function (xhr) { // Add this line
                        //     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                        // },  // Add this line
                        // success:function (data, textStatus) {
                        //     console.log( data);
                        // },
                        // type:"post", url:"<?= $this->Url->build(['action' => 'register']) ?>"});
                        // return false;
                    }
                }
            });
        }
    }

    /*
        ETAPAS DE CADASTRO
    */

    //TELA ETAPA 1 - ESCOLHER TIPO CLIENTE OU PARCEIRO
    $('#button-et1').click(()=>{
        let radio = $("input[name='role']:checked");
        if (radio.length == 0) {
            swal('Selecione uma opção');
            return;
        }
        var radioValue = $("input[name='role']:checked").val();
        $('#etapa1').hide();
        if (radioValue == "2") {
            //PARCEIRO - TELA DE CPF
            //PARCEIRO PULA A ETAPA 2               
            $('#etapa3').show();
        } else {
            //CLIENTE - TELA DE ESCOLHA DE PESSOA FÍSICA OU JURÍDICA                 
            $('#etapa2').show();
        }          
    });

    //TELA ETAPA 2 - PARA O PARCEIRO - SOLICITANDO CPF 
    $('#button-et2').click(()=>{
        var radioValue = $("input[name='tpdoc']:checked").val();
        if (radioValue == "2") {
            $('#form-cpf').hide();
            $('#form-cnpj').show();
        }
        $('#etapa2').hide();
        $('#etapa3').show();
    });

    //TELA ETAPA 3 - POR ENQUANTO APENAS PARA CLIENTES - SOLICITANDO O TIPO DE PESSOA (FÍSICA OU JURÍDICA) 
    $('#button-et3').click(()=>{           
        irParaEtapa4();
    });

    //TELA ETAPA 4 - DADOS DE LOGIN 
    $('#button-et4').click(()=>{      
        irParaEtapa5();
    });
    //Ou pressionar enter no campo input
    $('#form-password-confirm').keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
            irParaEtapa5();
        }
    });

    //TELA ETAPA 5 - DADOS ADICIONAIS - POR ENQUANTO ENCERRANDO POR AQUI 
    $('#button-et5').click(()=>{     
        let ingles = $('#ingles-nivel').val();
        let exp = $('#exp-compras').val();
        let cat = $('#cat-atuacao').val();
        $("#acting_cat").val(cat);

        if ((ingles.length < 1) || (exp.length < 1) || cat === null || (cat.length < 1)) {
            swal('Todos os campos são obrigatórios');
            return;
        }
        let radio = $("input[name='role']:checked");
        if (radio.val() == 2) {
            $("#form-register").submit(); // encerrando o cadastro do parceiro por aqui, por solicitação do cliente
        }
        //$('#etapa5').hide();
        //$('#etapa6').show();
    });

    //TELA ETAPA 6 - DADOS BANCÁRIOS
    $('#submit-btn5').click(()=>{
        let nome = $('#nome-conta').val();
        let cpf = $('#cpf-conta').val();
        let banco = $('#banco-conta').val();
        let agencia = $('#agencia-conta').val();
        let conta = $('#cc-conta').val();
        if ((nome.length < 1) || (cpf.length < 1) || (banco.length < 1) || (agencia.length < 1) || (conta.length < 1)) {
            swal('Todos os campos são obrigatórios');
            return;
        }
        $("#form-register").submit();
    });
})