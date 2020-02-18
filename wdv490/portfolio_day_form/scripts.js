window.addEventListener("load", () => {
	document.querySelectorAll("form").forEach(form => {
		new v_(form);
	});
}, false);

class v_ {
	constructor(form) {
		form.querySelectorAll("input, textarea, datalist, label").forEach(input => {
			this.validatorBuilder(input)
		});
	}

	validatorBuilder(input) {
		let validations = input.dataset;
		let validationSet = [];
		for (let filter in validations) {
			if (filter.startsWith("v_") && this[filter]) {
				validationSet.push(this[filter]);
			}
		}
		if (validationSet.length) {
			input.addEventListener("input", (e) => {
				this.validator(e.target, validationSet);
			});
		}
	}

	validator(input, validationSet) {
		for (let i = 0; i < validationSet.length; i++) {
			if (!validationSet[i](input)) {
				return;
			}
		}
		input.setCustomValidity("");
	}

	v_isEmail(input) {
		let content = input.value.trim();
		if (!/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(content)) {
			input.setCustomValidity("Email must be a vaild email address. Ex: user@domain.net");
			return false;
		} else {
			return true;
		}
	}

	v_isDmacc(input) {
		let content = input.value.trim();
		if (!/.*@dmacc\.edu$/.test(content)) {
			input.setCustomValidity("Email must be a vaild DMACC email address.");
			return false;
		} else {
			return true;
		}
	}

	v_isUrl(input) {
		let content = input.value.trim();
		if (!/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(content)) {
			input.setCustomValidity("Input must be a vaild URL. Ex: https://example.com");
			return false;
		} else {
			return true;
		}
	}

	v_isLinkedin(input) {
		let content = input.value.trim();
		if (!/^https:\/\/www.linkedin.com*/.test(content)) {
			input.setCustomValidity("Input must be a vaild LinkedIn URL, beginning with 'https://www.linkedin.com'.");
			return false;
		} else {
			return true;
		}
	}

	v_isGithub(input) {
		let content = input.value.trim();
		if (!/^https:\/\/www.github.com*/.test(content)) {
			input.setCustomValidity("Input must be a vaild LinkedIn URL, beginning with 'https://www.linkedin.com'.");
			return false;
		} else {
			return true;
		}
	}

	v_checkRegex(input) {
		let content = input.value.trim();
		let regex = new RegExp(input.dataset.v_regex);
		if (!regex.test(content)) {
			input.setCustomValidity("Input does not match requirements.");
			return false;
		} else {
			return true;
		}
	}

	v_lengthGt(input) {
		let content = input.value.trim();
		let min = parseInt(input.dataset.v_lengthGt);
		if (!isNaN(min)) {
			if (content.length <= min) {
				input.setCustomValidity(`Input must be longer than ${min} characters.`);
				return false;
			} else {
				return true;
			}
		} else {
			console.error("Validation error: Minimum is not a number\n" + input)
			return false;
		}
	}

	v_lengthLt(input) {
		let content = input.value.trim();
		let max = parseInt(input.dataset.v_lengthLt);
		if (!isNaN(max)) {
			if (content.length >= max) {
				input.setCustomValidity(`Input must be shorter than ${max} characters.`);
				return false;
			} else {
				return true;
			}
		} else {
			console.error("Validation error: Maximum is not a number\n" + input)
			return false;
		}
	}

	v_charCounter(input) {
		let label = input.parentNode;
		let max = parseInt(input.maxLength);
		let content = input.value.trim();
		if (!isNaN(max)) {
			let dif = max - content.length;
			label.setAttribute('data-v_char-counter', `${dif}/${max}`);
			return true;
		} else {
			console.error("Validation error: Maximum is not a number\n" + input)
			return false;
		}
	}
}