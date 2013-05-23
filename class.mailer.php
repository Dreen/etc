<?php
/**
 * Shorthand for using PHPMailer
 */
define('MAIL_HOST', '94.229.67.122');
define('MAIL_USER', 'holidays');
define('MAIL_PASS', '!LZ#bF-TuDO-');
define('MAIL_FROM', 'noreply@mediacitizens.com');
define('MAIL_NAME', 'Do Not Reply');

include 'class.phpmailer.php';

class mailer
{
        var $mail;
        var $mTpl;
        
        function mailer ()
        {
  	$this->mail = new PHPMailer();
		$this->mail->IsSMTP();
		$this->mail->SMTPAuth = true;
		$this->mail->IsHTML = 	true;
		$this->mail->Port = 	25;
		
		$this->mail->Host = 	MAIL_HOST;
		$this->mail->Username = MAIL_USER;
		$this->mail->Password = MAIL_PASS;
		$this->mail->SetFrom(MAIL_FROM, MAIL_NAME);
		$this->mail->AddReplyTo(MAIL_FROM, MAIL_NAME);
        }
	
	function newMsg($tpl)
	{
		$this->mail->ClearAllRecipients();
		$this->mTpl = new tpl($tpl);
	}
	
	function setSubject($msg)
	{
		$this->mail->Subject = $msg;
	}
	
	function addTo($email)
	{
		$this->mail->AddAddress($email);
	}
        
        function send ()
        {
		$mailBdy = $this->mTpl->build();
		$this->mail->MsgHTML($mailBdy);
		if(!$this->mail->Send())
			echo "Mailer Error: " . $this->mail->ErrorInfo;
        }
}
?>
