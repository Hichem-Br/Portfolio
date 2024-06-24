<?php
// Vérification de l'appel via le formulaire
if (count($_POST)==0) {
	// Si le le tableau est vide, on affiche le formulaire
	header('location: ../contact.php');
}
$affichage_retour = '';														// Lignes à ajouter au début des vérifications
$erreurs=0;
// Récupération des données du formulaire
if (!empty($_POST['name'])) {
	$nom=$_POST['name'];
} else {
    $affichage_retour .='Le champ NOM est obligatoire<br>';
    $erreurs++;
}
if (!empty($_POST['subject'])) {
	$prenom=$_POST['subject'];
} else {
    $affichage_retour .='Le champ PRENOM est obligatoire<br>';
    $erreurs++;
}
if (!empty($_POST['message'])) {
	$message=$_POST['message'];
} else {
    $affichage_retour .='Le champ MESSAGE est obligatoire<br>';
    $erreurs++;
}
if (!empty($_POST['email'])) {
    // Si le champ email contient des données
        // Verification du format de l'email
        if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
        $email=$_POST['email'];
      } else {
      // Si l'email est incorrect on retourne au formulaire  
      $affichage_retour .='Adresse mail incorrecte<br>';
      $erreurs++;
      }
  // Si le champ email est vide, on retourne au formulaire     
  } else {
    $affichage_retour .='Le champ EMAIL est obligatoire<br>';
    $erreurs++;
  }


    if ($erreurs == 0) {

        // Préparation des données 
        $prenom=ucfirst(mb_strtolower($prenom));
        $nom=ucfirst(mb_strtolower($nom));
        //Préparation des variables pour l'envoi du mail de contact
        $subject='SAE204 :'.$prenom.''.$nom;
        $headers['From']=$email;							// Pour pouvoir répondre à la demande de contact
        $headers['Reply-to']=$email;						// On donne l'adresse de l'utilisateur comme adresse de réponse
        $headers['X-Mailer']='PHP/'.phpversion();			// On précise quel programme à généré le mail

        // On fixe l'adresse du destinataire - Pour ce Mail il s'agit de notre adresse MMI@mmi-troyes.fr
        $email_dest="hichem.bnbr@gmail.com";
        //Envoi du mail de contact)
        if (mail($email_dest,$subject,$message,$headers)) {
        $erreurs=0;
        } else {
            $affichage_retour .='echec, votre message n\'a pas été envoyé, message d\'erreur: bugenvoie1<br>';
        $erreurs++;
        }
        
        // Préparation des données pour la confirmation
        $subject ="Confirmation de votre message à hichem.bnbr";
        $email_dest= $email;
        $headers['From']="hichem.bnbr@gmail.com";						
        $headers['Reply-to']="zhpe77@gmail.com";						
        $headers['X-Mailer']='PHP/'.phpversion();
        $headers['MIME-Version'] = '1.0';
        $headers['content-type'] = 'text/html; charset=utf-8';
        $message = "<h1>".'Bonjour '.$nom."</h1>".
        "<h3>".'Nous avons bien pris en compte votre demande '."<span>".$prenom."</span>"."</h3>"
        ."<style>
        span{color:red;}
        </style>
        ";
        //Envoi du mail de confirmation
        if (mail($email_dest,$subject,$message,$headers)) {
        $erreurs=0;
        } else {
            $affichage_retour .='echec, votre message n\'a pas été envoyé, message d\'erreur: bug envoie2<br>';
        $erreurs++;
        }
            
    }
?>

<main>
<?php
if ($erreurs == 0) {                                       // aucune erreur
echo '<div id="reussite">'."\n";
echo '<p>'.$affichage_retour.'Votre message a bien été envoyé</p>'."\n";
echo '<form action="../index.html">'."\n";
echo '<button type="submit">Retour</button>'."\n";        // on retourne sur la page accuei
echo '</form>'."\n";
echo '</div>'."\n";

} else {                                                  // Erreurs de saisie ou d'envoi du mail

echo '<div id="echec">'."\n";
echo '<p>'.$affichage_retour, $erreurs.'</p>'."\n";
echo '<form action="../index.html">'."\n";
echo '<button type="submit">Retour</button>'."\n";        // on retourne sur la page accueil
echo '</form>'."\n";
echo '</div>'."\n";
}
?>

</main>


