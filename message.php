<?php
  // Vérifie qu'il provient d'un formulaire
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //identifiants mysql
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "";

    if($_POST && isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
    
        if(!$name) {
          echo  "S'il vous plait, entrez votre nom.";
        } elseif(!$email || !preg_match("/^\S+@\S+$/", $email)) {
          echo "S'il vous plait, entrez votre adresse email.";
        } elseif(!$message) {
          echo  "S'il vous plait, entrez votre message dans le champs indiqué.";
        } else {
    
            //Ouvrir une nouvelle connexion au serveur MySQL
            $mysqli = new mysqli($host, $username, $password, $database);
            //Afficher toute erreur de connexion
            if ($mysqli->connect_error) {
              echo  'Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error;
            }  
            
            //préparer la requête d'insertion SQL
            $statement = $mysqli->prepare("INSERT INTO messages (name, email, objet, message) VALUES (?, ?, ?, ?)"); 
            //Associer les valeurs et exécuter la requête d'insertion

            $statement->bind_param('ssss', $name, $email, $subject, $message); 
            if($statement->execute()){
              echo  "OK";
            }else{
              echo "Veuillez reessayer s'il vous plait."; 
            }

            // To send a mail 

            // $success = mail('taka.alahassa@gmail.com', $subject, $name . " , d'adresse email " . $email . " vous envoie le message suivant " . $message);
            // if ($success) {
            //   echo  "OK";
            // }else{
            //     echo error_get_last()['message'];
            // }
        }
    }
  }
?>