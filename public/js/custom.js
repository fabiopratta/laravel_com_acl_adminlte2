$(document).ready(function() {
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.phone_with_ddd').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.money2').mask("#.##0,00", {reverse: true});
    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {reverse: true});
    $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});


    //CEP CALLBACK CLIENTES
    var options = {
        onComplete: function (cep) {
            var cep = cep.replace(/\D/g, '');
            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                if (!("erro" in dados)) {
                    console.log(dados);
                    //Atualiza os campos com os valores da consulta.
                    $("#endereco").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    alert("CEP não encontrado.");
                }
            });
        },
    };

    $('.cep_clientes').mask('00000-000', options);


    var callbackCnpj = {
            onComplete: function(cnpj)
            {
                var cnpj = cnpj.replace(/\D/g, '');
                //https://www.receitaws.com.br/v1/cnpj/

                $.ajax({
                    type: "GET",
                    dataType: 'jsonp',
                    url: "https://www.receitaws.com.br/v1/cnpj/" + cnpj,
                    crossDomain : true,
                })
                    .done(function( data ) {
                        if(data.status != "ERROR"){
                            $("#nome").val(data.nome);
                            $("#email").val(data.email);
                            $("#cep").val(data.cep.replace(/\D/g, ''));
                            $("#telefone").val(data.telefone.replace(/\D/g, ''));
                            $("#endereco").val(data.logradouro);
                            $("#numero").val(data.numero);
                            $("#bairro").val(data.bairro);
                            $("#cidade").val(data.municipio);
                            $("#estado").val(data.uf);
                        }else{
                            alert(data.message);
                        }
                    });
            },
        };

    //21360221/0001-40
    $('.cnpj').mask('00.000.000/0000-00', callbackCnpj);
});