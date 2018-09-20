<?php

$secret = "6LdjMnEUAAAAAAmT2yYyy5_GhywHvzrzSMkRX6zU";
require_once '../../autoload.php';
$recaptcha = new \ReCaptcha\ReCaptcha($secret);


require_once ('../Abstraction/ContactForm.Abstraction.php');
require_once ('../Repository/ContactForm.Repository.php');

if (isset($_POST) && !empty($_POST)) {

	if ($_POST["g-recaptcha-response"]) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}

	//Sanitize post values and put into array.
	foreach ($_POST as $k => $v) {
		$contactForm[$k] = strip_tags(trim($v));
	}

	//Spin up new instance of abstraction layer.
	$Abstraction = new Abstraction\ContactForm($contactForm);

	//This repo instance can be reused as desired.
	$Repository = new Repository();

	//Save captured form data.
	$response = $Repository->Save($Abstraction);

	//If we have a valid id returned, send email.
	//There's better way to do this.
	//May the Lifeblue gods forgive me.
	if ($response) {
		mail(
			"joe@airbanana.com",
			"New Form Submission",
			"Name:" . $Abstraction->name . "<br>
			Email:" . $Abstraction->email . "<br>
			Phone:" . $Abstraction->phone . "<br>
			How did you hear about us?:" . $Abstraction->acquisition_method . "<br>
			Budget:" . $Abstraction->budget . "<br>"
		);
		echo "<a href='https://youtu.be/dQw4w9WgXcQ'>Everything was successful! Click here to return...</a>";
	} else {
		echo "nahh";
	}
}
