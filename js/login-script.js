const expresiones = {
	password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,20}$/,
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
}

const formLogin = document.getElementById('form-login');
const inputs = document.querySelectorAll('#form-login input');

inputs.forEach(agregarListeners);

function agregarListeners(input){
	input.addEventListener('keyup', validarForm);
	input.addEventListener('blur', validarForm);
}

function validarForm(input){
	switch (input.target.name) {
		case "email":
			validarCampo(expresiones.email, input.target, 'Email');
			break;
		case "password":
			validarCampo(expresiones.password, input.target, 'Password');
			break;
	}
}

function validarCampo(expresion, input, objetivo){
	if(expresion.test(input.value)){
		document.getElementById(`aviso${objetivo}`).classList.remove('aviso-on');
		document.getElementById(`aviso${objetivo}`).classList.add('aviso-off');
	}
	else{
		document.getElementById(`aviso${objetivo}`).classList.remove('aviso-off');
		document.getElementById(`aviso${objetivo}`).classList.add('aviso-on');
	}
}