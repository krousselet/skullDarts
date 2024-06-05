//GENERAL VALUES
document.querySelector('#username').addEventListener("input", checkEmail);
document.querySelector('#password').addEventListener("input", checkPassword);
let login = document.querySelector("#login");
//BOOLEAN VALUES
let email = false;
let password = false;
function checkEmail() {
    let regex = new RegExp("\\S+@\\S+.\\S+");
    email = regex.test(this.value)
    checkAll();
}

function checkPassword() {
    password = this.value.length > 5;
    checkAll();
}
function checkAll() {
    if(email && password) {
        document.querySelector("#login").removeAttribute("disabled")
    }else document.querySelector("#login").setAttribute("disabled", "disabled")
}