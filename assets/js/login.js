//GENERAL VALUES
document.querySelector('#username').addEventListener("input", checkEmail);
document.querySelector('#password').addEventListener("input", checkPassword);
let login = document.querySelector("#login");
login.setAttribute("disabled", "disabled");

//BOOLEAN VALUES
let email = false;
let password = false;

//FUNCTIONS
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
    if(!password || !email) {
        login.setAttribute("disabled", "disabled");
    }
    if(email && password) {
        login.removeAttribute("disabled")
    }else {
        login.setAttribute("disabled", "disabled")
    }
}

function resetFields() {
    email = false;
    password = false;
    document.querySelector('#username').value = "";
    document.querySelector('#password').value = "";
    login.setAttribute("disabled", "disabled");
}

document.querySelector("form").addEventListener("submit", function(event) {
    // event.preventDefault();
    // Perform your form submission logic here
    setTimeout(() => {
        resetFields()
    }, 500)

});