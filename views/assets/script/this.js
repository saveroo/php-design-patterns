function Validation(id, div) {
	var username, phone, age, gender, password, confirm, address, captcha;
	var x = document.getElementById(id).value;
	var s = document.getElementById(id);
	var e = document.getElementById(div);

	//USERNAME condition
	if (id == 'username') {

		var numeric, alpha;
		if (x == "") {
			e.innerHTML = "Username must be filled";
			s.style.border = '3px solid red';
			return false;

		} else if (x.indexOf(' ') > 1) {
			e.innerHTML = "Username must not contain space";
			s.style.border = '3px solid red';
			return false;	
		} else if (x.length < 5) {
			e.innerHTML = "Must be more than 5 character";

			s.style.border = '3px solid red';
			return false;
		} else {
			//Loop for Symbol Validation
				for(var i=0; i < x.length; i++){
				var alpha = x.charAt(i);
				var ch = alpha.charCodeAt(0);
				if (!((ch >= 48 && ch <= 57) || (ch >= 97 && ch <= 122) || (ch >= 65 && ch <= 90)))
				{
					s.style.border = '3px solid red';
					e.innerHTML = 'Symbol are present, symbol are not allowed';
					username = false;
					return false;
				}else{
					if (ch >= 47 && ch <= 57) //if number  
						numeric = true;
					if ((ch >= 97 && ch <= 122) || (ch >= 65 && ch <= 90)) //if letter  
						alpha = true;
				}
			}

			if (numeric == true && alpha == true) //if both letter and number is present then passed  
			{
				s.style.border = '3px solid green';
				e.innerHTML = '';
				return true;
			}else if(alpha == true){
				s.style.border = '3px solid green';
				e.innerHTML = '';
				return true;
			}else if(numeric == true){
				s.style.border = '3px solid green';
				e.innerHTML = '';
				return true;
			}
			// s.style.border = '3px solid green';
			// e.innerHTML = "";
			// return true;
		}

	}

	//PASSWORD condition
	if (id == "password") {
		var alpha, numeric;

		if (x == "") {
			e.innerHTML = "Password must be filled";
			s.style.border = '3px solid red';
			return false;
		}


		for (var i = 0; i < x.length; i++) {
			var alpha = x.charAt(i);
			var a = alpha.charCodeAt(0);


			if (!((a >= 48 && a <= 57) || (a >= 97 && a <= 122) || (a >= 65 && a <= 90))) //if a is anything other than letter or number return false  
			{
				s.style.border = '3px solid red';
				e.innerHTML = 'Non-alphanumeric characters are present';
				return false;
			} else {
				if (a >= 47 && a <= 57) //if number  
					numeric = true;
				if ((a >= 97 && a <= 122) || (a >= 65 && a <= 90)) //if letter  
					alpha = true;
			}
		}
		if (numeric && alpha) //if both letter and number is present then passed  
		{
			s.style.border = '3px solid green';
			e.innerHTML = '';
			password = true;
			return true;
		} else {
			e.innerHTML = 'Not alphanumeric (contains only letters or numbers)';
			return false;
		}
	}

	//confirm Function
	if (id == "confirm") {
		if (document.getElementById('password').value == x && x != "") {
			s.style.border = '3px solid green';
			confirm = true;
			return true;
		} else {
			s.style.border = '3px solid red';
			return false;
		}
	}

	//Gender Condition
	if (id == "gender") {
		if (x == "Male" || x == "Female") {
			s.style.border = '3px solid green';
			gender = true;
			return true;
		} else {
			s.style.border = '3px solid red';
			return false;
		}
	}

	//Address condition
	if (id == "address") {
		if (x.indexOf('Street') > 1 && x.length > 10) {
			s.style.border = '3px solid green';
			address = true;
			e.innerHTML = " ";
			return true;
		} else {
			e.innerHTML = "Must contain 'Street' and character must be more than 10";
			s.style.border = '3px solid red';
			return false;
		}
	}

	//Age condition
	if (id == "age") {
		if (x == "") {
			e.innerHTML = "Age must be filled";
			s.style.border = '3px solid red';

			return false;
		} else
		if (x < 15) {
			e.innerHTML = "Your age must be above 15";
			s.style.border = '3px solid red';
			return false;

		} else
		if (isNaN(x)) {

			e.innerHTML = "Age must be numeric";
			s.style.border = '3px solid red';
			return false;

		} else {
			s.style.border = '3px solid green';
			e.innerHTML = '';
			age = true;
			return true;

		}
	}

	//phone Condition
	if (id == "phone") {
		if (x == "" || x == null) {
			s.style.border = '3px solid red';
			e.innerHTML = "Phone number must be filled";
			return false;
		} else
		if (isNaN(x)) {
			s.style.border = '3px solid red';
			e.innerHTML = "Phone number must be numeric";
			return false;
		} else {
			s.style.border = '3px solid green';
			e.innerHTML = " ";
			phone = true;
			return true;
		}
	}

	//Random Captcha
	if (id == "randomCaptcha") {
		var userChar = document.getElementById("username").value;
		var XX = userChar.charAt(0);
		var XXX = userChar.charAt(1);
		var Y = Math.ceil(Math.random() * 9);
		var YY = Math.ceil(Math.random() * 9);
		var YYY = Math.ceil(Math.random() * 9);
		var concat = XX + XXX + '-' + Y + YY + YYY;

		s.value = concat.toUpperCase();
	}

	//Captcha Matching
	if (id == "captcha") {
		var rCaptcha = document.getElementById("randomCaptcha").value;
		if (x != rCaptcha || x == '') {
			s.style.border = '3px solid red';
			e.innerHTML = "Captcha doesn't match!";
			return false;
		} else {
			s.style.border = '3px solid green';
			captcha = true;
			e.innerHTML = "";
			return true;
		}
	}
}


//Check all the validation if valid will return Success(true)
function check() {
	var username = Validation('username', 'err');
	var phone = Validation('phone', 'err');
	var age = Validation('age', 'err');
	var gender = Validation('gender', 'err');
	var password = Validation('password', 'err');
	var confirm = Validation('confirm', 'err');
	var address = Validation('address', 'err');
	var captcha = Validation('captcha', 'err');

	if ((username == true) && (gender == true) && (phone == true) && (age == true) && (password == true) && (confirm == true) && (captcha == true)) {
		alert('success');
	} else {
		alert('failed');

		//DEBUGGING
		// alert(username);
		// alert(phone);
		// alert(password);
		// alert(confirm);
		// alert(address);
		// alert(captcha);
		// alert(age);

		// }
		// if (username() == true && password() == true && confirm() == true && address() == true) {
		// 	alert('Success');
		// } else {
		// 	alert('failed');
		// }
	}
}


// Belore are just testing another way============

function username() {
	var numeric, alpha;
	var username, phone, age, gender, password, confirm, address, captcha;
	var x = document.getElementById('username').value;
	var s = document.getElementById('username');
	var e = document.getElementById('err');

	if (x == "") {
		e.innerHTML = "Username must be filled";
		s.style.border = '3px solid red';

	} else if (x.indexOf(' ') > 1) {
		e.innerHTML = "Username must not contain space";
		s.style.border = '3px solid red';
	} else if (x.length < 5) {
		e.innerHTML = "Must be more than 5 character";

		s.style.border = '3px solid red';
	} else {
		// 	for(var i=0; i < x.length; i++){
		// 	var loop = x.charAt(i);
		// 	var ch = loop.charCodeAt(i);
		// 	if (!((ch >= 48 && ch <= 57) || (ch >= 97 && a <= 122) || (ch >= 65 && ch <= 90)))
		// 	{
		// 		s.style.border = '3px solid red';
		// 		e.innerHTML = 'Symbol are present, symbol are not allowed';
		// 		username = false;
		// 		return username;
		// 	}else{
		// 		if (a >= 47 && a <= 57) //if number  
		// 			numeric = true;
		// 		if ((a >= 97 && a <= 122) || (a >= 65 && a <= 90)) //if letter  
		// 			alpha = true;
		// 	e.innerHTML= "";
		// 	s.style.border = '3px solid green';
		// 	username = true;
		// 	return true;
		// 	}
		// }
		// if (numeric && alpha) //if both letter and number is present then passed  
		// {
		// 	s.style.border = '3px solid green';
		// 	e.innerHTML = '';
		// 	username = true;
		// 	return true;
		// } else {
		// 	e.innerHTML = 'Not alphanumeric (contains only letters or numbers)';
		// 	return false;
		// }
		s.style.border = '3px solid green';
		e.innerHTML = "";
		return true;
	}
}

//PASSWORD function
function password() {
	var alpha, numeric;
	var x = document.getElementById('password').value;
	var s = document.getElementById('password');
	var e = document.getElementById(div);

	if (x == "") {
		e.innerHTML = "Password must be filled";
		s.style.border = '3px solid red';
		password = false;
	}


	for (var i = 0; i < x.length; i++) {
		var alpha = x.charAt(i);
		var a = alpha.charCodeAt(0);


		if (!((a >= 48 && a <= 57) || (a >= 97 && a <= 122) || (a >= 65 && a <= 90))) //if a is anything other than letter or number return false  
		{
			s.style.border = '3px solid red';
			e.innerHTML = 'Non-alphanumeric characters are present';
			return false;
		} else {
			if (a >= 47 && a <= 57) //if number  
				numeric = true;
			if ((a >= 97 && a <= 122) || (a >= 65 && a <= 90)) //if letter  
				alpha = true;
		}
	}
	if (numeric && alpha) //if both letter and number is present then passed  
	{
		s.style.border = '3px solid green';
		e.innerHTML = '';
		password = true;
		return true;
	} else {
		e.innerHTML = 'Not alphanumeric (contains only letters or numbers)';
		return false;
	}
}

function confirm() {
	var x = document.getElementById('confirm').value;
	var s = document.getElementById('confirm');
	var e = document.getElementById(div);
	if (document.getElementById('password').value == x) {
		s.style.border = '3px solid green';
		confirm = true;
		return true;
	} else {
		s.style.border = '3px solid red';
		return false;
	}
}

function gender() {
	if (x == "Male" || x == "Female") {
		s.style.border = '3px solid green';
		gender = true;
		return true;
	} else {
		s.style.border = '3px solid red';
		return false;
	}
}

function address() {
	var x = document.getElementById('address').value;
	var s = document.getElementById('address');
	var e = document.getElementById(div);
	if (x.indexOf('Street') > 1 && x.length > 10) {
		s.style.border = '3px solid green';
		address = true;
		e.innerHTML = " ";
		return true;
	} else {
		e.innerHTML = "Must contain 'Street' and character must be more than 10";
		s.style.border = '3px solid red';
		return false;
	}
}

function age() {
	var x = document.getElementById('age').value;
	var s = document.getElementById('age');
	var e = document.getElementById(div);
	if (x == "") {
		e.innerHTML = "Age must be filled";
		s.style.border = '3px solid red';

		return false;
	} else
	if (x < 15) {
		e.innerHTML = "Your age must be above 15";
		s.style.border = '3px solid red';
		return false;

	} else
	if (isNaN(x)) {

		e.innerHTML = "Age must be numeric";
		s.style.border = '3px solid red';
		return false;

	} else {
		s.style.border = '3px solid green';
		e.innerHTML = '';
		age = true;
		return true;

	}
}

function phone() {
	var x = document.getElementById('phone').value;
	var s = document.getElementById('phone');
	var e = document.getElementById(div);
	if (x == "" || x == null) {
		s.style.border = '3px solid red';
		e.innerHTML = "Phone number must be filled";
		return false;
	} else
	if (isNaN(x)) {
		s.style.border = '3px solid red';
		e.innerHTML = "Phone number must be numeric";
		return false;
	} else {
		s.style.border = '3px solid green';
		e.innerHTML = " ";
		phone = true;
		return true;
	}
}

function randomCaptcha() {
	var x = document.getElementById('randomCaptcha').value;
	var s = document.getElementById('randomCaptcha');
	var e = document.getElementById(div);
	var userChar = document.getElementById("username").value;
	var XX = userChar.charAt(0);
	var XXX = userChar.charAt(1);
	var Y = Math.ceil(Math.random() * 9);
	var YY = Math.ceil(Math.random() * 9);
	var YYY = Math.ceil(Math.random() * 9);
	var concat = XX + XXX + '-' + Y + YY + YYY;

	s.value = concat;
}

function captcha() {
	var x = document.getElementById('captcha').value;
	var s = document.getElementById('captcha');
	var e = document.getElementById(div);
	var rCaptcha = document.getElementById("randomCaptcha").value;
	if (x != rCaptcha && x != null) {
		s.style.border = '3px solid red';
		e.innerHTML = "Captcha doesn't match!";
	} else {
		s.style.border = '3px solid green';
		captcha = true;
		e.innerHTML = "";
	}
}