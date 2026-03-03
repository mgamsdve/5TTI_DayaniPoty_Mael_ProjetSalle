<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/CSS/style.css">
    <title><?= $title ?></title>
</head>

<body>
    <header class="glass">
        <div class="container">
            <?php require_once("Views/Components/header.php"); ?>
        </div>
    </header>

    <main class="fade-in">
        <?php require_once($template); ?>
    </main>

    <footer class="fade-in">
        <div class="container">
            <?php require_once("Views/Components/footer.php"); ?>
        </div>
    </footer>
</body>

</html>