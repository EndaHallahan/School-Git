// JavaScript Document

var assert = require('chai').assert;	//Chai assertion library
var {validInput, validPhone} = require('../app/validateRequiredField');

describe("Testing Input Required", function(){
	
	it("The letter a should pass", function(){
		assert.isTrue(validInput('a'));		
	});
	
	it("The number 4 should pass", function() {
		assert.isTrue(validInput(4));
	});
	
	it("Empty or '' should fail", function() {
		assert.isFalse(validInput(' '));
	});	
	
	it("A single space should fail", function() {
		assert.isFalse(validInput(' '));
	});
	
	it("Two or more spaces should fail", function(){
		assert.isFalse(validInput('  '));
	});
	
	it("The word null should fail", function() {
		assert.isFalse(validInput('null'));
	});
	
	it("The word undefined should fail", function() {
		assert.isFalse(validInput('undefined'));
	});
	
	it("The value 'a 4' should pass", function(){
		assert.isTrue(validInput('a 4'));
	});
	
});	//end "Testing Input Required"

/*
"" => false
" " => false
"alphabetic" => false
"undefined" => false
"1" => false
"12345678901" => false
"1234567890" => true
"123 456 7890" => true
"123-456-7890" => true
*/
describe("Testing Valid Phone Number", function(){
	
	it("Input is required", () => {
		assert.isFalse(validPhone(''));
		assert.isFalse(validPhone(' '));		
	});
	it("Input must be numeric", () => {
		assert.isFalse(validPhone('alphabetic'));
		assert.isFalse(validPhone('----------'));
		assert.isFalse(validPhone('alpha12345'));
		assert.isFalse(validPhone('12345betic'));
		assert.isFalse(validPhone('123456.7890'));
	});
	it("takes no more or less than ten numbers", () => {
		assert.isFalse(validPhone('1'));
		assert.isFalse(validPhone('12345678901'));
		assert.isTrue(validPhone('1234567890'));
	});
	it("takes a phone number separated by spaces", () => {
		assert.isTrue(validPhone('123 456 7890'));
	});
	it("takes a phone number separated by hyphens", () => {
		assert.isTrue(validPhone('123-456-7890'));
	});
	
});