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


