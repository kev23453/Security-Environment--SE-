const inputs_code = document.querySelectorAll(".code");
const buttonOtp = document.getElementById('btnOtp');

function putFirstInput(){
    inputs_code[0].focus();
}
document.addEventListener("DOMContentLoaded", putFirstInput);

inputs_code.forEach((input, index) => {
    input.addEventListener("keyup", (e)=>{
        const currentInp = input; 
        const nextInput = input.nextElementSibling;
        const previousInput = input.previousElementSibling;

        if(currentInp.value.length > 1){
            currentInp.value = "";
            currentInp.hasAttribute("readonly", true);
        }

        if(nextInput && nextInput.hasAttribute("disabled") && currentInp != ""){
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

            if (e.keyCode === 8) { // Backspace
                inputs_code.forEach((inputSec, secIndex) => {
                    if (secIndex >= index) {
                        inputSec.setAttribute("disabled", true);
                        inputSec.value = "";
                    }
                });

                if (previousInput) {
                    previousInput.focus();
                }else{
                    inputs_code[0].removeAttribute("disabled");
                    inputs_code[0].focus();
                }
            }

        //bloque para activar el boton cuando este puesto el codigo completo
        if(inputs_code[5].disabled == false && inputs_code[5].value !== ""){
            buttonOtp.classList.add("actived");
            buttonOtp.removeAttribute("disabled");
        }
        else{
            buttonOtp.classList.remove("actived");
            buttonOtp.setAttribute("disabled", true);
        }
    })
})