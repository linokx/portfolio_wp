<?php
	 if($_POST['message'] != null && $_POST['mail'] != null){
		$to = 'ludovic.bekaert@student.hepl.be';
		$message = htmlspecialchars($_POST['message'], ENT_QUOTES);
		$sender = htmlspecialchars($_POST['mail'], ENT_QUOTES);
		$headers = 'From: '.$sender . "\r\n" .
		'Reply-To: '.$sender . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		 try{
			mail($to,"Mail du portofolio", $message, $headers);
			echo "Message envoyé avec succès.";
		}
		catch (Exception $e){
			echo "Le message n'a pas pu être envoyé.";
		}
	}
	else
	{
		echo "Le message n'a pas pu être envoyé.";
	}
 ?>
