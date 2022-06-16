<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

require_once './DBConnect.php';

try {
    $dataBase = DBConnect::getMySQLConnection();
} catch (Exception $e) {
    die('Erreur :' . $e->getMessage());
}

if (isset($_POST['login'])) {
    $email = $_POST['mail'];
    $password = $_POST['password'];
    $query = $dataBase->prepare("SELECT * FROM users WHERE mail=:mail");
    $query->bindParam("mail", $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($_POST['password'], $result['password'])) {

        $_SESSION['mail'] = $result['mail'];

        echo
        '<!DOCTYPE html>
        <html lang="fr-ca">
        
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="./cleaned/style.css">
        <title>Formulaire Bootstrap</title>
        </head>
        
        <body>
        <section class="container-form mb-3 mt-3   pt-0 pb-5 rounded-1 row row-cols-1 bg-paleBlue">
        <h2 class="text-center display-4 my-md-5 my-4 text-darkBlue fw-normal">Bonjour ' . $result['first_name'] . " " . $result['last_name']  . ', nous sommes heureux de vous revoir!</h2>
        <p class="text-darkGrey text-start mt-3 text-center"><a class="text-darkGrey" href="./login.html">Déconnexion</a></p>
        </body>
        
        </html>';
    } else {
        echo '<p class="text-center my-md-5 my-4 text-danger fw-normal">La combinaison de votre courriel et mot de passe n\'est pas valide. Veuillez réessayer.</p>';
        require_once './login.html';
        exit;
    }
}
