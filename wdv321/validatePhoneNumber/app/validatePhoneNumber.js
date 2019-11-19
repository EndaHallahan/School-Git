/*
Hey Jeff, for future reference, you shouldn't include the node_modules folder when you upload these assignments.
It can cause problems when moving a project from one computer to another, and bloats the filesize uneccessarily.
It's better to not include it and just have us run `npm install`` and/or `npm install --save-dev`.`
*/ 

var validatePhoneNumber = function(inValue){
	inValue += "";	//turns all inValues into strings
	let cleanValue = inValue.replace(/[ -]/g, "");
	return cleanValue.length === 10 && !/\D/.test(cleanValue);
}

module.exports = validatePhoneNumber;