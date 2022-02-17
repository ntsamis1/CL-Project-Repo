document.addEventListener('DOMContentLoaded', () => {
	const $email = document.querySelector('#email');
	const $password = document.querySelector('#password');

	const $logInSubmit = document.querySelector('#login');

	const $emailError = document.querySelector('.email-error');
	const $passwordError = document.querySelector('.password-error');

	let emailIsValid = false;
	let passwordIsValid = false;

	const getEmailIsValid = (email) => {
		if (
			email !== '' &&
			/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)
		) {
			emailIsValid = true;
		} else {
			emailIsValid = false;
		}
	};

	const getPasswordIsValid = (password) => {
		if (password !== '' && password.length > 4) {
			passwordIsValid = true;
		} else {
			passwordIsValid = false;
		}
	};

	const checkSigninBtn = () => {
		if (emailIsValid && passwordIsValid) {
			$logInSubmit.removeAttribute('disabled');
		} else {
			$logInSubmit.setAttribute('disabled', 'disabled');
		}
	};

	// $email.addEventListener('input', (e) => {
	// 	getEmailIsValid(e.target.value);

	// 	if (emailIsValid) {
	// 		$emailError.style.display = 'none';
	// 	} else {
	// 		$emailError.style.display = 'block';
	// 	}

	// 	checkSigninBtn();
	// });

	// $password.addEventListener('input', (e) => {
	// 	getPasswordIsValid(e.target.value);

	// 	if (passwordIsValid) {
	// 		$passwordError.style.display = 'none';
	// 	} else {
	// 		$passwordError.style.display = 'block';
	// 	}

	// 	checkSigninBtn();
	// });

	$('#password').on('input',function(e){
		getPasswordIsValid(e.target.value);

		if (passwordIsValid) {
			$passwordError.style.display = 'none';
		} else {
			$passwordError.style.display = 'block';
		}

		checkSigninBtn();
	});

	$('#email').on('input',function(e){
		getEmailIsValid(e.target.value);
	
		if (emailIsValid) {
			$emailError.style.display = 'none';
		} else {
			$emailError.style.display = 'block';
		}
	
			checkSigninBtn();
	});

});
