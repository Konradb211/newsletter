<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    if (empty($email)){
        $_SESSION['given_email'] = $_POST['email'];
        header('Location: index.php');
        exit();
    } else {
        require_once "database.php";

        $check = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->execute(['email' => $email]);

        if ($check->fetch()) {
            $_SESSION['mail_error'] = 'Ten adres e-mail jest już zapisany do newslettera';
            header('Location: index.php');
            exit();
        }

        $query = $conn->prepare("INSERT INTO users VALUES  (NULL, :email)" );
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();

        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;

            $mail->Username = '';
            $mail->Password = '';

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('no-reply@gmail.com', 'Dzień dobry to jest mój newsletter');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Kapibary to świetne pływaki a kicie są najlepsze';

            $mail->Body = '
            <html lang="pl">
            <head>
                <title>Tak to jest newsletter o kapibarach i kiciach</title>
            </head>
            <body>
                <h1>Dzień dobry!</h1>
                <p>Zobacz to: <a href="https://www.youtube.com/watch?v=Gp6dewwTsWQ">Kapibara</a></p>
                <hr>
                <p>Administratorem twoich danych osobowych jest:</p>
                <p>Kapikiciacziczi Sp.z.o_O, ul Wiejska 1, 63-524 Czajków</p>
            </body>
            </html>
            ';

            $mail->addAttachment('img/kot.jpg');
            $mail->send();

        } catch (Exception $e) {
            echo "Błąd wysyłania maila: {$mail->ErrorInfo}";
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <title>Zapisanie się do newslettera</title>
    <meta name="description" content="Używanie PDO - zapis do bazy MySQL">
    <meta name="keywords" content="php, kurs, PDO, połączenie, MySQL">

    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">

        <header>
            <h1>Newsletter</h1>
        </header>

        <main>
            <article>
                <p>Dziękujemy za zapisanie się na listę mailową naszego newslettera!</p>
            </article>
        </main>

    </div>

</body>
</html>