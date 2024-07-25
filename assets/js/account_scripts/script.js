const checkboxInput = document.getElementById('check');
const buttonRegister = document.getElementById('regSend');
const btnShowPass = document.getElementById('eye-login');
const passwordLogin = document.getElementById('logPass');

checkboxInput.addEventListener('change', function(){
    if (this.checked){
        console.log("habilitado");
        buttonRegister.disabled = false;
    }
    else{
        console.log("deshabilitado");
        buttonRegister.disabled = true;
    }
});
 
btnShowPass.addEventListener("click", function(){
    if (passwordLogin.type === "password"){
        passwordLogin.type = "text";
    }
    else{
        passwordLogin.type = "password";
    }
})

//variables
const btnRegister = document.getElementById('regSend'); //boton de enviar form de registro
const checkbox = document.getElementById('check');//input de tipo checkbox
const textChangeForm = document.getElementById('changeForm');//texto para alternar forms
const formRegister = document.getElementById('register');//formulario de registro
const formLogin = document.getElementById('login');//formulario de login
const message = document.querySelector('.message');//mensajes de usuario
const containerOtp = document.getElementById('containerOtp');


//marcar checkbox para deshabilitar el boton
checkbox.addEventListener('change', function() {
    if (this.checked) {
        console.log("checkbox marcado");
        btnRegister.disabled = false;
        
    } else {
        console.log('El checkbox ha sido desmarcado');
        btnRegister.disabled = true;  
    }
});


//prevenir el evento de post para cambiar entre formularios
textChangeForm.addEventListener("click", (e)=> {
    e.preventDefault();
    formRegister.classList.add("show");
    formLogin.classList.add("hide");
})



//ocultar el mensaje
/*if(message){
    setTimeout(() => {
        message.style.opacity = 0;
    }, 2000);
}*/



//creacion del codigo otp
/*function generarOtp(){
    let otp_lenght = 5; 
    let code_otp = "";

    for(let i = 0; i < otp_lenght; i++){
        code_otp += Math.floor(Math.random() * 9);
    }
    return code_otp;
}

btnRegister.addEventListener("click", (e)=>{
    e.preventDefault();
    containerOtp.value = generarOtp();
})*/

