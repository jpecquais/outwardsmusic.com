<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!---<meta http-equiv="refresh" content="0; URL=confirmation.">--->
</head>

<?php
$mymail = 'outwards.contact@gmail.com'; // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $usermail)) // On filtre les serveurs qui rencontrent des bogues 
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$username = htmlspecialchars($_POST['name']);
$usermail = htmlspecialchars($_POST['email']);
$message_txt = htmlspecialchars($_POST['message']);
$message_html = "<html><head></head><body><p>$message_txt</p></body></html>";
//==========
 
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========
 
//=====Définition du sujet.
$sujet = "Question - Demande de contact Outwards";
//=========
 
//=====Création du header de l'e-mail.
$header = "From: \"$username\"<$usermail>".$passage_ligne;
$header.= "Reply-to: \"$username\" <$usermail>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
 
//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;


//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;

//=====Ajout du message au format HTML.
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========

//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
 
//=====Envoi de l'e-mail.
if(isset($usermail) && $usermail != '' && isset($username) && $username != '' && isset($message_txt) && $message_txt != '' && isset($_POST['email2']) && $_POST['email2'] == '' && $usermail != $mymail)
{
	mail($mymail,$sujet,$message,$header);
}
header('Location: confirmation.html'); // redirige vers une page de confirmation où l'utilisateur peut cliquer sur un bouton pour revenir à l'accueil
//==========
?>