window.addEventListener("load", () => {
	document.querySelectorAll("form").forEach(form => {
		new v_(form);
	});
}, false);

class v_ {
	constructor(form) {
		form.addEventListener("submit", (e) => {
			e.preventDefault();
			e.target.submit();
		});
		form.querySelectorAll("input, textarea, select, datalist").forEach(input => {
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

	v_isDmacc(input) {
		let content = input.value.trim();
		if (!/.*@dmacc\.edu$/.test(content)) {
			input.setCustomValidity("Email must be a vaild DMACC email address.")
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
			console.error("Validation error: Minimum is not a number")
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
			console.error("Validation error: Maximum is not a number")
			return false;
		}
	}
}