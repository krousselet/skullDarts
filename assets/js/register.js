//GENERAL VALUES
document.querySelector('#registration_form_nom').addEventListener("input", checkNom);
document.querySelector('#registration_form_prenom').addEventListener("input", checkPrenom);
document.querySelector('#registration_form_email').addEventListener("input", checkEmail);
document.querySelector('#registration_form_telephone').addEventListener("input", checkTelephone);
document.querySelector('#registration_form_agreeTerms').addEventListener("input", checkAgreeTerms);
document.querySelector('#registration_form_plainPassword_first').addEventListener("input", checkPassword);
let register = document.querySelector("#register");
register.setAttribute("disabled", "disabled");
register.style.cursor = "default";

//BOOLEAN VALUES
let nom = false;
let prenom = false;
let email = false;
let telephone = false;
let passwordFirst = false;
let agreeTerms = false;

function checkNom() {
    nom = this.value.length > 2;
    checkAll();
}

function checkPrenom() {
    prenom = this.value.length > 2;
    checkAll();
}

function checkEmail() {
    let regex = new RegExp("\\S+@\\S+.\\S+");
    email = regex.test(this.value)
    checkAll();
}

function checkTelephone() {
    telephone = this.value.length > 9;
    checkAll();
}

function checkAgreeTerms() {
    agreeTerms = this.checked;
    checkAll();
}

function checkAll() {
    if(nom && prenom && email && agreeTerms && passwordFirst && telephone) {
        register.removeAttribute("disabled");
        register.style.cursor = "pointer";
    }else {
        register.setAttribute("disabled", "disabled");
    }
}

const PasswordStrength = {
    STRENGTH_VERY_WEAK: 'Très faible',
    STRENGTH_WEAK: 'Faible',
    STRENGTH_MEDIUM: 'Moyen',
    STRENGTH_STRONG: 'Fort',
    STRENGTH_VERY_STRONG: 'Très fort',
}

function checkPassword() {
    //INPUT RETRIEVAL
    passwordFirst = this.value;
    //DISPLAY ELEMENT RETRIEVAL
    let entropyElement = document.querySelector("#entropy");
    //STRENGTH ASSESSMENT
    let entropy = evaluatePasswordStrength(passwordFirst);
    // CLASS HANDLING
    entropyElement.classList.remove("text-red", "text-orange", "text-green");
    //TEXT COLOR GIVEN ACCORDING TO THE ENTROPY SCORE
    switch (entropy){
        case ('Très faible'):
            entropyElement.classList.add("text-red");
            passwordFirst = false;
            break;
        case ('Faible'):
            entropyElement.classList.add("text-red");
            passwordFirst = false;
            break;
        case ('Moyen'):
            entropyElement.classList.add("text-orange");
            passwordFirst = false;
            break;
        case ('Fort'):
            entropyElement.classList.add("text-green");
            passwordFirst = true;
            break;
        case ('Très fort'):
            entropyElement.classList.add("text-green");
            passwordFirst = true;
            break;
        default:
            entropyElement.classList.add("text-red");
            passwordFirst = false;
    }
    entropyElement.textContent = entropy;
    checkAll();
}

function evaluatePasswordStrength(passwordFirst){
    //STRENGTH CALCULATION OF THE PASSWORD
    let length = passwordFirst.length;
    //IF NO PASSWORD IS TYPED OR DELETED
    if(!length) {
        return PasswordStrength.STRENGTH_VERY_WEAK
    }
    //OBJECT CREATION CONTAINING CHARACTERS AND THEIR NUMBER (SEE ASCII)
    let passwordChars = {};
    for(let i= 0; i < passwordFirst.length; i++) {
        let charCode = passwordFirst.charCodeAt(i);
        passwordChars[charCode] = (passwordChars[charCode] || 0) + 1;
    }

    console.log(passwordChars);
    //CHECK THE NUMBER OF DIFFERENT CHARACTERS IN THE PASSWORD
    let chars = Object.keys(passwordChars).length;
    // CHARACTERS TYPE VARIABLES INITIALISATION
    let control = 0, digit = 0, upper = 0, lower = 0, symbol = 0, other = 0;
    for(let [chr, count] of Object.entries(passwordChars)) {
        chr = Number(chr);
        if(chr < 32 || chr === 127) {
            //CONTROL CHARACTERS
            control = 33;
        }else if(chr >= 48 && chr <= 57) {
            //CONTROL CHARACTERS
            digit = 10;
        }else if(chr <= 65 && chr <= 90) {
                //CONTROL CHARACTERS
            upper = 26;
        }else if(chr >=  97 && chr <= 122) {
                //CONTROL CHARACTERS
            lower = 26;
        }else if(chr >=  128) {
            //CONTROL CHARACTERS
            other = 128;
        }else {
            symbol = 33;
        }
    }
    //POOL CALCULATION
    let pool = control + digit + upper + lower + other + symbol ;
    //ENTROPY CALCULATION
    let entropy = chars * Math.log2(pool) + (length - chars) * Math.log2(chars);
    if(entropy >= 120) {
        return PasswordStrength.STRENGTH_VERY_STRONG;
    }else if (entropy >= 100) {
        return PasswordStrength.STRENGTH_STRONG;
    }else if (entropy >= 80) {
        return PasswordStrength.STRENGTH_MEDIUM;
    }else if (entropy >= 60) {
        return PasswordStrength.STRENGTH_WEAK;
    }else {
        return PasswordStrength.STRENGTH_VERY_WEAK;
    }

}