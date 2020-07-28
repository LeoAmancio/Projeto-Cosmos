var currentTab = 0;
var x = document.getElementsByClassName("form-step");
var tabCompleted = [];
showTab(currentTab);

function showTab(n) {
    x[n].style.display = "flex";
    document.getElementsByClassName("step-number")[n].style.boxShadow = "0 3px 8px rgba(0,0,0,0.6)";
    tabCompleted[n] = true;

    if (n == 0) {
        document.getElementsByClassName("btn-back")[0].style.visibility = "visible";
    } else {
        document.getElementsByClassName("btn-back")[0].style.visibility = "hidden";
    }
    fixStepIndicator(n);
}

function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("step-number");
    var y = document.getElementsByClassName("line-step");
    for (i = n; i >= 0; i--) {
        x[i].style.background = "#003bfb";
        x[i].style.cursor = "pointer";
        if (i > 0) {
            y[i - 1].style.background = "#003bfb";
        }
    }
}

function goToTab(n) {
    if (n < currentTab || tabCompleted[n] == true) {
        x[currentTab].style.display = "none";
        document.getElementsByClassName("step-number")[currentTab].style.boxShadow = "none";
        x[n].style.display = "flex";
        document.getElementsByClassName("step-number")[n].style.boxShadow = "0 3px 8px rgba(0,0,0,0.6)";
        currentTab = n;
        if (n == 0) {
            document.getElementsByClassName("back-button")[0].style.visibility = "visible";
        } else {
            document.getElementsByClassName("back-button")[0].style.visibility = "hidden";
        }
    }
}

function next() {
    if (!validateForm()) return false;
    x[currentTab].style.display = "none";
    document.getElementsByClassName("step-number")[currentTab].style.boxShadow = "none";
    currentTab = currentTab + 1;
    if (currentTab >= x.length) {
        document.getElementById("form-register").submit();
        return false;
    }
    window.scrollTo(0, 0);
    showTab(currentTab);

}

function validateForm() {
    var y, i, valid = true;
    y = x[currentTab].getElementsByClassName("mdl-textfield");

    for (i = 0; i < y.length; i++) {
        if (y[i].getElementsByTagName("input")[0].value == "" && !y[i].getElementsByTagName("input")[0].classList.contains("no-required") || y[i].getElementsByTagName("input")[0].type == "email" || y[i].getElementsByTagName("input")[0].name == "cpf") {
            x[currentTab].getElementsByClassName("mdl-textfield")[i].classList.add("is-invalid");
            valid = false;
            if (y[i].getElementsByTagName("input")[0].type == "email") {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(y[i].getElementsByTagName("input")[0].value)) {
                    valid = true;
                    x[currentTab].getElementsByClassName("mdl-textfield")[i].classList.remove("is-invalid");
                } else {
                    valid = false;
                }
            }

            if (y[i].getElementsByTagName("input")[0].name == "cpf") {
                if (validaCPF(y[i].getElementsByTagName("input")[0].value)) {
                    valid = true;
                    x[currentTab].getElementsByClassName("mdl-textfield")[i].classList.remove("is-invalid");
                } else {
                    x[currentTab].getElementsByClassName("mdl-textfield")[i].classList.add("is-invalid")
                    valid = false;
                }
            }
        }
    }

    return valid;
}

var password = document.getElementById("input-password"),
    confirm_password = document.getElementById("input-password-confirm"),
    txt_confirm_password = document.getElementById("txt-password-confirm");

function validatePassword() {
    if (password.value != confirm_password.value) {
        txt_confirm_password.classList.add("is-invalid");
    } else {
        txt_confirm_password.classList.remove("is-invalid");
    }
}

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('input-street').value = ("");
    document.getElementById('input-neighborhood').value = ("");

}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('input-street').value = (conteudo.logradouro);
        document.getElementsByClassName("form-street")[0].classList.add("is-dirty");
        document.getElementById('input-neighborhood').value = (conteudo.bairro);
        document.getElementsByClassName("form-neighborhood")[0].classList.add("is-dirty");
        document.getElementById("estadosBrasil").value = (conteudo.uf);
        document.getElementById('input-city').value = (conteudo.localidade);
        document.getElementsByClassName('form-city')[0].classList.add("is-dirty");
        document.getElementById('input-complement').value = (conteudo.complemento);
        if(document.getElementById('input-complement').value != '') {
            document.getElementsByClassName('form-complement')[0].classList.add("is-dirty");
        }
        document.getElementById("input-number").focus();


    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        document.getElementsByClassName("form-cep")[0].classList.add("is-invalid");
    }
}

function pesquisacep(valor) {

    //variável cep somente com numeros.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {
            var script = document.createElement('script');


            script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';


            document.body.appendChild(script);

        } else {
            //cep é inválido.
            limpa_formulário_cep();
            document.getElementsByClassName("form-cep")[0].classList.add("is-invalid");

        }
    } else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

function validaCPF(cpf1) {
    var cpf = cpf1.replace(/\D/g, '');
    var aux = 0;
    if (cpf.length == 0) {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf.length > 11) {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "00000000000") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "11111111111") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "22222222222") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "33333333333") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "44444444444") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "55555555555") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "66666666666") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "77777777777") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "88888888888") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else if (cpf == "99999999999") {
        document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
        return false;
    } else {
        var digitoA = 0;
        var digitoB = 0;


        for (i = 0, j = 10; i <= 8; i++, j--) {
            digitoA += cpf[i] * j;
        }
        for (i = 0, j = 11; i <= 9; i++, j--) {

            digitoB += cpf[i] * j;
        }
        var somaA = ((digitoA % 11) < 2) ? 0 : 11 - (digitoA % 11);

        var somaB = ((digitoB % 11) < 2) ? 0 : 11 - (digitoB % 11);

        if (somaA != cpf[9] || somaB != cpf[10]) {
            document.getElementsByClassName("form-cpf")[0].classList.add("is-invalid");
            return false;
        }
    }
    return true;
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;


function normalInput(input) {
    input.classList.remove("is-invalid");
}

document.getElementsByTagName("input").onkeyup = normalInput;

$(document).ready(function() {
    $('#input-cpf').mask('000.000.000-00', { reverse: true });
    $('#input-cep').mask('00000-000', { reverse: true });
    $('#input-phone_number').mask('(00) 00000-0000');
});