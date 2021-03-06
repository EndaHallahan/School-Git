/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return v_ify; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return V_; });
/* harmony import */ var _defaultMessages_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(1);
var _defaultMessages_json__WEBPACK_IMPORTED_MODULE_0___namespace = /*#__PURE__*/__webpack_require__.t(1, 1);


class V_ {
	constructor(formOrOpts, opts) {
		this.options = undefined;
		this.messages = undefined;
		this.defaultMessages = _defaultMessages_json__WEBPACK_IMPORTED_MODULE_0__;
		if (formOrOpts && formOrOpts.nodeName && formOrOpts.nodeName === "FORM") {
			let form = formOrOpts;
			this.setValidations(form);
			if (opts) {
				this.options = opts;
				if (opts.messages) {
					this.messages = opts.messages
				}
			}
		} else if (formOrOpts && !formOrOpts.nodeName) {
			this.options = formOrOpts;
			if (formOrOpts.messages) {
				this.messages = formOrOpts.messages
			}
		}
	}

	// Calls validatorBuilder on form inputs.
	setValidations(form) {
		form.querySelectorAll("input, textarea, datalist, label").forEach(input => {
			this.validatorBuilder(input, this.defaultMessages);
		});
	}

	// Assigns validation functions to an input element based on its data attributes.
	// Only validations specified in the data attributes will be run.
	validatorBuilder(input) {
		let validations = input.dataset;
		let validationSet = [];
		let messageSet = [];
		for (let filter in validations) {
			if (filter.startsWith("v_")) {
				if (this[filter]) {
					validationSet.push(this[filter]);
					if (this.messages && this.messages[filter]) {
						messageSet.push(this.messages[filter]);
					} else if (this.defaultMessages[filter]) {
						messageSet.push(this.defaultMessages[filter]);
					} else {
						throw new Error(`Missing a fail message for '${filter}'`);
					}
				} else {
					console.warn(`Validation warning: V_ did not recognize attribute '${filter}', skipping...`)
				}
			}
		}
		if (validationSet.length) {
			input.addEventListener("input", (e) => {
				this.validator(e.target, validationSet, messageSet);
			});
		}
	}

	// Runs through an element's array of validations constructed by validatorBuilder.
	validator(input, validationSet, messageSet) {
		let content = input.value.trim();
		let reset = true;
		for (let i = 0; i < validationSet.length; i++) {
			let check = validationSet[i](input, content, messageSet[i]);
			if (check === false) {
				reset = false;
				return;
			} else if (check === null) {
				reset = false;
				continue;
			}
		}
		if (reset) {
			input.setCustomValidity("");
		}
	}

	// Adds a custom validation function to the V_ object.
	// Validators should be constructed as objects with the following fields:
	// 	name - Name of the validation, used as data attribute to assign it.
	// 	validationFunction(inputValue [, dataAttributeValue]) - Function to be evaluated. Must return a boolean.
	// 	failMessage - The message to be displayed to the user if the validation fails.
	addCustomValidation(validObj) {
		let funcName = validObj.name;
		let validFunc = validObj.validationFunction;
		let errorMessage = validObj.failMessage ? validObj.failMessage : this.defaultMessages.generic;
		if (!this.messages) {this.messages = {};}
		this.messages[funcName] = errorMessage;
		let newValidation = function (input, content, message) {
			let valiVal = input.dataset[funcName];
			if (!validFunc(content, valiVal)) {
				input.setCustomValidity(message);
				return false;
			} else {
				return true;
			}
		}
		this[funcName] = newValidation;
		return newValidation;
	}

	/*-- VALIDATION FUNCTIONS --*/

	v_isNumber(input, content, message) {
		if (content === "") {return true;}
		if (isNaN(parseFloat(content))) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_isInteger(input, content, message) {
		if (content === "") {return true;}
		let val = parseFloat(content);
		if (isNaN(val) || !Number.isSafeInteger(val)) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_isAlphanumeric(input, content, message) {
		if (content === "") {return true;}
		if (typeof content !== "string" || !/^[\da-zA-Z]*$/.test(content)) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_isEmail(input, content, message) {
		if (content === "") {return true;}
		if (typeof content !== "string" 
			|| !/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(content)
		) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_isEmailWithDomain(input, content, message) {
		if (content === "") {return true;}
		let rawDomain = input.dataset.v_isEmailWithDomain;
		if (rawDomain) {
			let regStr = `^([a-zA-Z0-9_\\-\\.]+)@${rawDomain.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}$`;
			let regex = new RegExp(regStr);
			if (typeof content !== "string" || !regex.test(content)) {
				input.setCustomValidity(message.replace("[arg]", rawDomain));
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Missing argument\n" + input);
		}
	}

	v_isUrl(input, content, message) {
		if (content === "") {return true;}
		if (typeof content !== "string" 
			|| !/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(content)
		) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_isSecureUrl(input, content, message) {
		if (content === "") {return true;}
		if (typeof content !== "string" 
			|| !/https:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(content)
		) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_isUrlWithDomain(input, content, message) {
		if (content === "") {return true;}
		let rawDomain = input.dataset.v_isUrlWithDomain;
		if (rawDomain) {
			let regStr = `https?:\\/\\/(www\.)?${rawDomain.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}\\b([-a-zA-Z0-9()@:%_\\+.~#?&//=]*)$`;
			let regex = new RegExp(regStr);
			if (typeof content !== "string" || !regex.test(content)) {
				input.setCustomValidity(message.replace("[arg]", rawDomain));
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Missing argument\n" + input);
		}
	}

	v_isImageUrl(input, content, message) {
		if (content === "") {return true;}
		if (typeof content !== "string" 
			|| !/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)\.(apng|gif|jpg|jpeg|jfif|pjpeg|pjp|png|svg|webp)$/.test(content)
		) {
			input.setCustomValidity(message);
			return false;
		} else {
			return true;
		}
	}

	v_valueLessThan(input, content, message) {
		if (content === "") {return true;}
		let max = parseInt(input.dataset.v_valueLessThan);
		if (!isNaN(max)) {
			let val = parseFloat(content);
			if (isNaN(val) || val >= max) {
				input.setCustomValidity(message.replace("[arg]", max));
				return false;
			} else {
				return true;
			}	
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Maximum is not a number\n" + input);
		}
	}

	v_valueGreaterThan(input, content, message) {
		if (content === "") {return true;}
		let min = parseInt(input.dataset.v_valueGreaterThan);
		if (!isNaN(min)) {
			let val = parseFloat(content);
			if (isNaN(val) || val <= min) {
				input.setCustomValidity(message.replace("[arg]", min));
				return false;
			} else {
				return true;
			}	
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Minimum is not a number\n" + input);
		}
	}

	v_valueBetween(input, content, message) {
		if (content === "") {return true;}
		let args = input.dataset.v_valueBetween.split(",");
		let min = parseFloat(args[0]);
		let max = parseFloat(args[1]);
		if (!isNaN(min) && !isNaN(max)) {
			let val = parseFloat(content);
			if (isNaN(val) || val <= min || val >= max) {
				input.setCustomValidity(message.replace("[arg]", min).replace("[arg]", max));
				return false;
			} else {
				return true;
			}	
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: One or more args are missing or not a number\n" + input);
		}
	}

	v_lengthLessThan(input, content, message) {
		if (content === "") {return true;}
		let max = parseInt(input.dataset.v_lengthLessThan);
		if (!isNaN(max)) {
			if (typeof content !== "string" || content.length >= max) {
				input.setCustomValidity(message.replace("[arg]", max));
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Maximum is not a number\n" + input);
		}
	}

	v_lengthGreaterThan(input, content, message) {
		if (content === "") {return true;}
		let min = parseInt(input.dataset.v_lengthGreaterThan);
		if (!isNaN(min)) {
			if (typeof content !== "string" || content.length <= min) {
				input.setCustomValidity(message.replace("[arg]", min));
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Minimum is not a number\n" + input);
		}
	}

	v_lengthBetween(input, content, message) {
		if (content === "") {return true;}
		let args = input.dataset.v_lengthBetween.split(",");
		let min = parseInt(args[0]);
		let max = parseInt(args[1]);
		if (!isNaN(min) && !isNaN(max)) {
			if (typeof content !== "string" || content.length <= min || content.length >= max) {
				input.setCustomValidity(message.replace("[arg]", min).replace("[arg]", max));
				return false;
			} else {
				return true;
			}	
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: One or more args are missing or not a number\n" + input);
		}
	}

	v_matchesRegex(input, content, message) {
		if (content === "") {return true;}
		let rawRegex = input.dataset.v_matchesRegex;
		if (rawRegex) {
			if (rawRegex.startsWith("/") && rawRegex.endsWith("/")) {
				rawRegex = rawRegex.substring(1, rawRegex.length - 1);
			}
			let regex = new RegExp(rawRegex);
			if (typeof content !== "string" || !regex.test(content)) {
				input.setCustomValidity(message);
				return false;
			} else {
				return true;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Missing argument\n" + input);
		}
	}

	v_matchesField(input, content, message) {
		if (content === "") {return true;}
		let fieldName = input.dataset.v_matchesField;
		if (fieldName) {
			let parentForm = input.form;
			if (parentForm) {
				let comparisonField = parentForm.querySelector(`*[name=${fieldName}]`);
				if (comparisonField) {
					let comparison = comparisonField.value.trim();
					if (comparison !== content) {
						input.setCustomValidity(message);
						return false;
					} else {
						return true;
					}
				} else {
					input.setCustomValidity("An error has occurred. Please check the console for details.");
					throw new Error(`Validation error: Could not find field named '${fieldName}'\n` + input);
				}	
			} else {
				input.setCustomValidity("An error has occurred. Please check the console for details.");
				throw new Error(`Validation error: Element must be a child of a form element\n` + input);
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Missing argument\n" + input);
		}
	}

	v_passwordStrengthRequirement(input, content, message) {
		if (content === "") {return true;}
		let req = parseInt(input.dataset.v_passwordStrengthRequirement);
		if (!isNaN(req) && req >= 0 && req <= 4) {
			if (content) {
				let sumset = 0;
				let sets = [
					{regex: /[a-z]/u, size: 26},
					{regex: /[A-Z]/u, size: 26},
					{regex: /[0-9]/u, size: 10},
					{regex: /[ ,.?!]/u, size: 5},
					{regex: /["£$%^&*()_=+[\]{};:'@#~<>/\\|`¬¦-]/u, size: 31}
				];
				sets.forEach(set => {if (set.regex.test(content)) {sumset += set.size}});
				if (sumset === 0) {
					input.setCustomValidity(message);
					return false;
				}
				let entropy = ((Math.log(sumset) / Math.log(2)) * content.length);
				let strength = Math.floor(entropy/30);
				input.dataset.v_passwordStrength = strength <= 4 ? strength.toString() : "4";
				if (strength <= req) {
					input.setCustomValidity(message);
					return false;
				} else {
					return true;
				}
			} else {
				input.setCustomValidity(message);
				return false;
			}	
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Password strength must be an integer between 0 and 4\n" + input);
		}
	}

	v_passwordZxcvbnRequirement(input, content, message) {
		if (content === "") {return true;}
		// Determine whether zxcvbn is available, either globally on the window or as a CommonJS module
		let vbn;
		try {vbn = zxcvbn;} catch {try {vbn = __webpack_require__(2);}  catch {}}
		
		if (!vbn) {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Use of v_password-zxcvbn-requirement requires zxcvbn.js: https://github.com/dropbox/zxcvbn\n" + input);
		}
		let req = parseInt(input.dataset.v_passwordZxcvbnRequirement);
		if (!isNaN(req) && req >= 0 && req <= 4) {
			if (content) {
				let zxc = vbn(content);
				let strength = zxc.score;
				input.dataset.v_passwordStrength = strength;
				if (strength <= req) {
					input.setCustomValidity("message"
						+ (zxc.feedback && zxc.feedback.warning ? " \nWarning: " + zxc.feedback.warning : "")
						+ (zxc.feedback && zxc.feedback.suggestions ? " \nSuggestions:\n -" + zxc.feedback.suggestions.join("\n -") : "")
					);
					return false;
				} else {
					return true;
				}
			} else {
				input.setCustomValidity(message);
				return false;
			}
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Password strength must be an integer between 0 and 4\n" + input);
		}
	}

	/*-- UI FUNCTIONS --*/

	v_charCounter(input, content, message) {
		let label = input.parentNode;
		let max;
		if (input.maxLength > 0) {
			max = input.maxLength;
		} else if ("v_lengthLessThan" in input.dataset) {
			max = parseInt(input.dataset.v_lengthLessThan);
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Input must have either a 'maxlength' or 'v_length-less-than' attribute\n" + input);
		}
		if (!isNaN(max)) {
			label.setAttribute('data-v_char-counter', message.replace("[arg]", content.length).replace("[arg]", max));
			return null;
		} else {
			input.setCustomValidity("An error has occurred. Please check the console for details.");
			throw new Error("Validation error: Maximum is not a number\n" + input);
		}
	}

	v_errorOutput(input) {
		let label = input.parentNode;
		label.dataset.v_errorOutput = input.validationMessage;
		return null;
	}

	v_passwordOutput(input) {
		let label = input.parentNode;
		label.dataset.v_passwordOutput = input.dataset.v_passwordStrength;
		return null;
	}
}

// Applies V_ to a form if specified, or to all forms on the page with the attribute "data-v_form" if not.
function v_ify(form) {
	if (form) {
		new V_(form);
	} else {
		document.querySelectorAll("form[data-v_form]").forEach(pageForm => {
			new V_(pageForm);
		});
	}
}



/***/ }),
/* 1 */
/***/ (function(module) {

module.exports = JSON.parse("{\"generic\":\"Input does not meet requirements.\",\"v_isNumber\":\"Input must be a number.\",\"v_isInteger\":\"Input must be a whole number.\",\"v_isAlphanumeric\":\"Input may only contain letters and numbers.\",\"v_isEmail\":\"Email must be a vaild email address. Ex: user@domain.net\",\"v_isEmailWithDomain\":\"Input must be a valid email address from '[arg]'\",\"v_isUrl\":\"Input must be a vaild web address. Ex: https://example.com\",\"v_isSecureUrl\":\"Input must be an SSL-secured web address beginning with 'https://'.\",\"v_isUrlWithDomain\":\"Input must be a vaild web address from '[arg]'\",\"v_isImageUrl\":\"Input must be a URL to an image file. Accepted file types are: APNG, GIF, JPEG, PNG, SVG, WebP\",\"v_valueLessThan\":\"Value must be a number below [arg]\",\"v_valueGreaterThan\":\"Value must be a number above [arg]\",\"v_valueBetween\":\"Value must be a number between [arg] and [arg]\",\"v_lengthLessThan\":\"Input may not be longer than [arg] characters.\",\"v_lengthGreaterThan\":\"Input may not be shorter than [arg] characters.\",\"v_lengthBetween\":\"Input must be between [arg] and [arg] characters in length.\",\"v_matchesRegex\":\"Input does not meet requirements.\",\"v_matchesField\":\"Input does not match.\",\"v_passwordStrengthRequirement\":\"Password is too weak. Consider using a longer password or passphrase, or including a greater variety of characters.\",\"v_passwordZxcvbnRequirement\":\"Password is too weak.\",\"v_charCounter\":\"[arg] / [arg]\",\"v_errorOutput\":\" \",\"v_passwordOutput\":\" \"}");

/***/ }),
/* 2 */
/***/ (function(module, exports) {

if(typeof zxcvbn === 'undefined') {var e = new Error("Cannot find module 'zxcvbn'"); e.code = 'MODULE_NOT_FOUND'; throw e;}
module.exports = zxcvbn;

/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _V_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(0);


window.v_ify = _V_js__WEBPACK_IMPORTED_MODULE_0__[/* v_ify */ "b"];
window.V_ = _V_js__WEBPACK_IMPORTED_MODULE_0__[/* V_ */ "a"];

window.addEventListener("load", () => {
	Object(_V_js__WEBPACK_IMPORTED_MODULE_0__[/* v_ify */ "b"])();
}, false);


/***/ })
/******/ ]);