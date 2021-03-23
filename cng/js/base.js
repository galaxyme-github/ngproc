<!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap 3.3.7 -->
    <!-- <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->

    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Multiselect - PLUGIN SELECT2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <!-- JQuery Mask Plugin -->
    <script type="text/javascript" src="bower_components/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
    <!-- Máscara CPF Parceiro -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-cpf").mask("000.000.000-00");
            $("#form-cnpj").mask("00.000.000/0000-00");
            // Iniciando o plugin SELECT2 no elemeno que o utiliza
            $('.js-example-basic-single').select2({
                placeholder: "Categorias de interesse"
            });
        });
    </script>

    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>



    <script>
        // validação do cadastramento de senha: 1 maiusculo 1 minuscula e 1 caractere especial
        $('#form-password').blur(function() {
            let senha = $(this).val();
            //let regex = /^(?=^.{6,}$)((?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/g;
            let regex = /^(?=^.{6,}$).*$/g;

            if (!regex.test(senha)) {
                //alert("A senha deve conter no mínimo 6 caracteres: sendo ao menos 1 letra maiúscula, 1 letra minúscula e 1 símbolo");
                $('#password-rule-info').show();
                this.value = '';
            } else {
                $('#password-rule-info').hide();
            }
        })
        //converte input para letras maiusculas
        function maiuscula(z) {
            v = z.value.toUpperCase();
            z.value = v;
        }
        // Checa se o e-mail é valido
        $('#form-email').blur(function() {
            let str = $(this).val();
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(str)) {
                swal("Por favor informe um e-mail válido");
                $(this).val('');
            }
        })

        //checa se o campo contem apenas letras
        let checkLetter = function() {
            let value = $(this).val();
            if (value.trim() !== "") {
                var regra = /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]+$/;
                if (!value.match(regra)) {
                    swal("Permitido somente letras");
                    $(this).val('');
                }
            }
        };

        $('#nome-conta').blur(checkLetter);
        $('#form-name').blur(checkLetter);

        //Validação de CPF/CNPJ
        /* Valida CPF jQuery */
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


        //checa se o campo tem somente numeros
        let checkNumber = function() {
            let value = $(this).val();
            if (value.trim() !== "") {
                var regra = /^[0-9]+$/;
                if (!value.match(regra)) {
                    swal("Permitido somente números");
                    $(this).val('');
                }
            }
        };

        $('#cc-conta').blur(checkNumber);
        $('#agencia-conta').blur(checkNumber);
        $('#banco-conta').blur(checkNumber);
    </script>
    <script>
        //Realizando a transitação das etapas de cadastro do parceiro
        $(document).ready(function() {
            $('#button-et1').click(function() {
                alert('funcionei')
            //     let radio = $("input[name='role']:checked");
            //     if (radio.length == 0) {
            //         swal('Selecione uma opção');
            //         return;
            //     }
            //     var radioValue = $("input[name='role']:checked").val();
            //     $('#etapa1').hide();
            //     if (radioValue == "2") {                    
            //         $('#etapa3').show();
            //     } else {                    
            //         $('#etapa2').show();
            //     }                
            })

        });
        $(document).on('click', '#button-et2', function() {
            var radioValue = $("input[name='tpdoc']:checked").val();
            if (radioValue == "2") {
                $('#form-cpf').hide();
                $('#form-cnpj').show();
            }
            $('#etapa2').hide();
            $('#etapa3').show();

        });
        $(document).on('click', '#button-et3', function() {            
            irParaEtapa3();

        });
        //Ou pressionar enter no campo imput
        $('#form-cpf').keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                irParaEtapa3();
            }
        });
        function irParaEtapa3() {
            let cpf = $('#form-cpf').val();
            let cpnj = $('#form-cnpj').val();
            var radioValue = $("input[name='tpdoc']:checked").val();
            let tpUser = $("input[name='role']:checked").val(); //Parceiro ou cliente
            if (radioValue == "2") {
                inscricao = cpnj;
                //form-label
                $('#form-name').attr("placeholder", "Razão social");
                if (!validarCNPJ(inscricao)) {
                    swal('Por favor digite um CNPJ válido antes de prosseguir');
                    return;
                }
            } else {
                inscricao = cpf;
                $('#form-name').attr("placeholder", "Nome");
                if (!validarCPF(inscricao)) {
                    swal('Por favor digite um CPF válido antes de prosseguir');
                    return;
                }
            }
            if (inscricao < 1) {
                swal('Por favor digite o CPF/CNPJ antes de prosseguir');
                return;

            } else {
                $.get(`/users/check-cpf/${tpUser}/${inscricao}`, function(data) {
                    let exist = data.exists;
                    if (exist) {
                        swal("Cadastrado já existe !", "Clique em OK para ser redirecionado à tela de recuperação de senha")
                            .then((value) => {
                                window.location.href = "/users/recover-password";
                                
                            });
                    } else {
                        $('#etapa3').hide();
                        $('#etapa4').show();
                    }
                });

            }
        }
        $(document).on('click', '#button-et4', function() {
            irParaEtapa4();
        }); //Ou pressionar enter no campo input
        $('#form-password-confirm').keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                irParaEtapa4();
            }
        });
        function irParaEtapa4(){
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
                $.get(`/users/check-email/${email}`, function(data) {

                    let exist = data.exists;
                    if (exist) {
                        swal("E-mail já cadastrado", "Clique em OK para ser redirecionado à tela de recuperação de senha")
                            .then((value) => {
                                window.location.href = "/users/recover-password";
                            });
                    } else {
                        let radio = $("input[name='role']:checked");
                        if (radio.val() == 2) {
                            $('#etapa4').hide();
                            $('#etapa5').show();

                        } else {
                            $("#form-register").submit();/*
                                    $.ajax({
                                    async:true,
                                    data: $("#conteudo").serialize(),
                                    dataType:"html",
                                    beforeSend: function (xhr) { // Add this line
                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                                    },  // Add this line
                                    success:function (data, textStatus) {
                                        console.log( data);
                                    },
                                    type:"post", url:"<?= $this->Url->build(['action' => 'register']) ?>"});
                                    return false;*/
                                 
                        }
                    }
                });
            }
        }

        $(document).on('click', '#buttom-et5', function() {
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
        $(document).on('click', '#submit-btn5', function() {
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
    </script>