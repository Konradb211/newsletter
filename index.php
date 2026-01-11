<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Newsletter - zapisz się!</title>
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
    <main class="container-main">
        <form action="save.php" method="post">
            <div class="container-main-form">
                <label for="email">Podaj adres e-mail</label>
                <input value="<?= htmlspecialchars($_SESSION['given_email'] ?? '', ENT_QUOTES) ?>" type="email" id="email" name="email" />
                <?php
                    if (isset($_SESSION['given_email'])) {
                        echo "<p>To nie jest poprawny adres!</p>";
                        unset($_SESSION['given_email']);
                    }
                ?>
            </div>
            <button type="submit">Wyślij</button>
        </form>
    </main>

</div>
</body>
</html>
