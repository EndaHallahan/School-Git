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

	// Assigns validation functions to an input element based on its data attributes.
	// Only validations specified in the data attributes will be run.
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

	// Runs through an element's array of validations constructed by validatorBuilder.
	validator(input, validationSet) {
		let content = input.value.trim();
		if (content) {
			for (let i = 0; i < validationSet.length; i++) {
				if (!validationSet[i](input, content)) {
					return;
				}
			}
		}
		input.setCustomValidity("");
	}

	v_isEmail(input, content) {
		if (typeof content !== "string" || !/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(content)) {
			input.setCustomValidity("Email must be a vaild email address. Ex: user@domain.net");
			return false;
		} else {
			return true;
		}
	}

	v_isDmacc(input, content) {
		if (typeof content !== "string" || !/.*@dmacc\.edu$/.test(content)) {
			input.setCustomValidity("Email must be a vaild DMACC email address.");
			return false;
		} else {
			return true;
		}
	}

	v_isUrl(input, content) {
		if (typeof content !== "string" || !/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(content)) {
			input.setCustomValidity("Input must be a vaild URL. Ex: https://example.com");
			return false;
		} else {
			return true;
		}
	}

	v_isLinkedin(input, content) {
		if (typeof content !== "string" || !/^https:\/\/www\.linkedin\.com.*/.test(content)) {
			input.setCustomValidity("Input must be a vaild LinkedIn URL beginning with 'https://www.linkedin.com'.");
			return false;
		} else {
			return true;
		}
	}

	v_lengthGT(input, content) {
		let min = parseInt(input.dataset.v_lengthGT);
		if (!isNaN(min)) {
			if (typeof content !== "string" || content.length <= min) {
				input.setCustomValidity(`Input must be longer than ${min} characters.`);
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Minimum is not a number\n" + input);
			return false;
		}
	}

	v_lengthLT(input, content) {
		let max = parseInt(input.dataset.v_lengthLT);
		if (!isNaN(max)) {
			if (typeof content !== "string" || content.length >= max) {
				input.setCustomValidity(`Input must be shorter than ${max} characters.`);
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Maximum is not a number\n" + input);
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