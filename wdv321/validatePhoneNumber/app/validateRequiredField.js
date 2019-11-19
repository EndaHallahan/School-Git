// JavaScript Document
const validatePhoneNumber = require("./validatePhoneNumber");

const validInput = function(inValue){
	inValue += "";	//turns all inValues into strings
	if(inValue.trim() == "" || inValue == 'null' || inValue == 'undefined'){
		return false;
	}
	return true;
}

const validPhone = (inNumber) => {
	return validInput(inNumber) && validatePhoneNumber(inNumber);
}

module.exports = {
	validInput: validInput,
	validPhone: validPhone
}

/*
var Box = function(length, width, height) {
  this.length = length;
  this.width = width;
  this.height = height;
};

Box.prototype.getVolume = function() {
  return this.length * this.width * this.height;
};

module.exports = Box;

*/