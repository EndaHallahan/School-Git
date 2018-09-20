<?php 
	class Emailer {
		private $senderAddress;
		private $recieverAddress;
		private $subject;
		private $message;

		function __construct() {
			$this->senderAddress = "";
			$this->recieverAddress = "";
			$this->subject = "";
			$this->message = "";
		}

		public function getSenderAddress() {
			return $this->senderAddress;
		}
		public function setSenderAddress($inString) {
			$this->senderAddress = $inString;
		}

		public function getRecieverAddress() {
			return $this->recieverAddress;
		}
		public function setRecieverAddress($inString) {
			$this->recieverAddress = $inString;
		}

		public function getSubject() {
			return $this->subject;
		}
		public function setSubject($inString) {
			$this->subject = $inString;
		}

		public function getMessage() {
			return $this->message;
		}
		public function setMessage($inString) {
			$this->message = $inString;
		}

		public function sendEmail() {
			$headers = "From: " . $this->senderAddress;
			$body = str_replace("\n", "\r\n", $this->message);
			return mail($this->recieverAddress, $this->subject, $body, $headers);
		}
	}
?>