<?php

class Validator {

	public function notEmpty($input) {
		return (!empty(trim($input)));
	}

	public function isNumeric($input) {
		return (is_numeric($input));
	}

	public function isLessThanCharacters($input, $limit) {
		return (strlen($input) <= $limit);
	}

	public function noSpecialChars($input) {
		return (!boolval(strpbrk($input, "&\"'<>")) || !strlen($input));
	}

	public function isPhone($input) {
		return (!preg_match("/\D/", $input) && strlen($input) === 10);
	}

	public function isEmail($input) {
		return (filter_var($input, FILTER_VALIDATE_EMAIL));
	}

	public function isURL($input) {
		return (filter_var($input, FILTER_VALIDATE_URL));
	}
}

?>