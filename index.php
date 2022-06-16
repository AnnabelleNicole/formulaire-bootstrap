
    <?php
    if (session_status() === PHP_SESSION_NONE)
        session_start();
    require_once './DBConnect.php';
    try {
        $dataBase = DBConnect::getMySQLConnection();
    } catch (Exception $e) {
        die('Erreur :' . $e->getMessage());
    }

    /********inscription */

    if (isset($_REQUEST['action'])) {
        if ($_REQUEST['action'] === 'inscription') {

            $first_name = htmlspecialchars($_POST['first_name']);
            $last_name = htmlspecialchars($_POST['last_name']);

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['mail'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $dataBase->prepare("SELECT * FROM users WHERE mail=:mail");
            $query->bindParam("mail", $email, PDO::PARAM_STR);
            $query->execute();

            if ($query->rowCount() > 0) {
                echo '<h2 style="text-align:center; margin-top: 1%">Vous avez déjà un compte chez nous</h2>';
                require_once './login.html';
            }

            if ($query->rowCount() == 0) {
                $query = $dataBase->prepare("INSERT INTO users(first_name, last_name,password,mail) VALUES (:first_name, :last_name, :password_hash,:mail)");
                $query->bindParam("first_name", $first_name, PDO::PARAM_STR);
                $query->bindParam("last_name", $last_name, PDO::PARAM_STR);
                $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
                $query->bindParam("mail", $email, PDO::PARAM_STR);


                if (!preg_match('/^[\w\-.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $email)) {
                    echo '<h2 style="text-align:center; margin-top: 1%">Le courriel n\'est pas conforme.<br />Veuillez recommencer.</h2>';
                    require_once './inscription-form.html';
                    exit;
                }

                if (!preg_match('/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[\W])(?=\S*[\d])\S*$/', $password)) {
                    echo '<h2 style="text-align:center; margin-top: 1%">Le mot de passe n\'est pas conforme.<br />Veuillez recommencer.</h2>';
                    require_once './inscription-form.html';
                    exit;
                }

                if ($_POST['password'] !== $_POST['confirm_password']) {
                    echo '<h2 style="text-align:center; margin-top: 1%">Les mots de passe ne sont pas identiques. <br /> Veuillez recommencer, merci.</h2>';
                    require_once './inscription-form.html';
                    exit;
                }

                $result = $query->execute();
                if ($result) {
                    echo '<h2 style="text-align:center; margin-top: 1%">Merci pour votre inscription ' . $first_name . ' ' .  $last_name . '</h2>';
                    require_once('./login.html');
                }
            }
        }
    } else {
        require_once './inscription-form.html';
    }


    ?>