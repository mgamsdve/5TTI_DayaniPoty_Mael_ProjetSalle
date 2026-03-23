<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Assets/CSS/style.css">
    <title><?= $title ?></title>
</head>

<body>
    <header>
        <?php require_once("Views/Components/header.php"); ?>
    </header>

    <main class="fade-in">
        <?php require_once($template); ?>
    </main>

    <footer>
        <?php require_once("Views/Components/footer.php"); ?>
    </footer>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>lucide.createIcons();</script>
</body>

</html>
