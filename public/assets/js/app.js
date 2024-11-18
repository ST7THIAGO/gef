var $blurredElement = null;

function switchForms() {
    let formLoginContainer = document.querySelector(".form-login-container").style;
    let formRegisterContainer = document.querySelector(".form-register-container").style;

    if (formLoginContainer || formRegisterContainer) {
        let display = formLoginContainer.display ?? "block";
        switch (display) {
            case "block":
                formLoginContainer.display = "none";
                formRegisterContainer.display = "block";
                break;
            case "none":
                formLoginContainer.display = "block";
                formRegisterContainer.display = "none";
                break;
            default:
                formLoginContainer.display = "none";
                formRegisterContainer.display = "block";
                break;
        }

    }
}

function closeBlur() {
    let blurred = document.querySelector(".blur-background-form");
    $blurredElement = blurred;
    let blurStyle = blurred.style.backdropFilter;
    let blurLevel = parseInt(blurred.dataset.blurlevel, 10);
    if (blurStyle == "" && isNaN(blurLevel)) {
        blurred.style.display = "none";
    }
}

function enableBlur() {
    let blurred = document.querySelector(".blur-background-form");
    blurred.style.display = "block";
    blurred.style.display = "flex";

}


function onRegisterUser(event) {
    event.preventDefault();
    const form = $('#cadastro').parsley();
    const isValid = form.isValid();
    console.log("form registro valido? " + isValid);
    if (isValid) document.getElementById('cadastro').submit();
    return false;
}

function handleLogin(event) {
    event.preventDefault(); // não acione o servidor com uma requisicao
    const form = $('#login').parsley(); // instancia via jquey a classe parsley responsavel pela validacao
    const isValid = form.isValid(); // checa se os dados do form estão de acordo com os critérios de validacao
    console.log("form de login valido? " + isValid);
    if (isValid) document.getElementById('login').submit(); // submit manual
    return false;
}

function handleLogout(event) {
    console.log(event)
    event.preventDefault();
    const form = document.getElementById('form-logout');
    if (form) form.submit();
}
