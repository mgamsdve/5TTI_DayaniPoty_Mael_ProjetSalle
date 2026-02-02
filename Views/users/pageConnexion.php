<h1>Connexion</h1>
<?php if ($message != null) : ?>
    <p><?= $message ?></p>
<?php endif ?>
<form action="" method="POST">
    <label for="email">Email : </label><br>
    <input type="email" name="email" id="email">
    <br>
    <label for="mdp">Mot de passe :</label><br>
    <input type="password" name="mdp" id="mdp"><br>
    <input type="submit" value="Envoyer" id="envoyer" name="envoyer">
</form>