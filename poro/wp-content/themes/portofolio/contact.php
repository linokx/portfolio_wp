Traitement en cours...
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
			?>
			<SCRIPT LANGUAGE="JavaScript">document.location.href="../../../contact"</SCRIPT>
			Message envoyé avec succès. <a href="contact">Retour à la page contact</a>	
			<?php
		}
		catch (Exception $e){
			?>
			<SCRIPT LANGUAGE="JavaScript">document.location.href="../../../contact"</SCRIPT>
			Le message n'a pas pu être envoyé. <a href="contact">Retour à la page contact</a>	
			<?php
		}
	}
	else
	{
	?>
		<SCRIPT LANGUAGE="JavaScript">document.location.href="../../../contact"</SCRIPT>
		Le message n'a pas pu être envoyé. <a href="contact">Retour à la page contact</a>
		<?php
	}
 ?>
