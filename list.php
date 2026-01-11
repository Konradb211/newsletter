<?php
session_start();

require_once 'database.php';

if (!isset($_SESSION['logged_in'])) {

    if (isset($_POST['login'])) {

        $login = filter_input(INPUT_POST, 'login',);
        $password = filter_input(INPUT_POST, 'pass');

        $userQuery = $conn->prepare('SELECT id,password FROM admins WHERE login = :login');
        $userQuery->bindValue(':login', $login, PDO::PARAM_STR);
        $userQuery->execute();

        $user = $userQuery->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = $user['id'];
            unset($_SESSION['bad_attempt']);
        } else {
            $_SESSION['bad_attempt'] = true;
            header('Location: admin.php');
            exit();
        }

    } else {
        header('Location: admin.php');
        exit();
    }
}
$all_users_query = $conn->query('SELECT * FROM users');
$all_users = $all_users_query->fetchAll();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Panel administracyjny</title>
    <meta name="description" content="Używanie PDO - odczyt z bazy MySQL">
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
    <h2>Łącznie rekordów <?= count($all_users) ?></h2>
    <div class="all_users">
            <?php
                foreach ($all_users as $user) {
                    echo "<a href='mailto:{$user['email']}'>{$user['email']}</a>";
                }
            ?>
        </div>
    <p><a class="logout" href="logout.php">Wyloguj się!</a></p>
    <main>
    </main>

</div>

</body>
</html>
