<?php
// ENABLE DISPLAY SCRIPT ERRORS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'ssl0.ovh.net';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'easy_switch@becactus.be';                     //SMTP username
    $mail->Password   = 'NEPSSZ5pa0';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	


    //Recipients
    $mail->setFrom('easy_switch@becactus.be', 'BECACTUS ES');
    $mail->addAddress('bastien.brasseur@gmail.com');     //Add a recipient
    // $mail->addReplyTo('easy_switch_escalation@becactus.be', 'ES Escalation');
	
	
	// DKIM signature
	$mail->DKIM_domain = 'becactus.be';
	$mail->DKIM_private = 'key.private'; // Make sure to protect the key from being publicly accessible!
	$mail->DKIM_selector = 'dkim';
	$mail->DKIM_passphrase = 'Daniela';
	$mail->DKIM_identity = $mail->From;


    //Content
    $mail->isHTML(false);
	$mail->charSet = "UTF-8";
	$mail->Encoding = "base64";
	
	//Set email format to HTML
    $mail->Subject = '<RecipientReference>SCTES8615583825711606</RecipientReference>';
    $mail->Body    = '<ESRequest><RecipientReference>VOO000000005720</RecipientReference><Recipient>VOO</Recipient><Donor>SCT</Donor><EasySwitchNumber>1600000000004779571</EasySwitchNumber><CustomerNumber>1599989</CustomerNumber></ESRequest>';


    $mail->send();
    echo 'Le message a été envoyé';
} catch (Exception $e) {
    echo "Erreur: {$mail->ErrorInfo}";
}