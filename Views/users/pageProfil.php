<h1>Page profil</h1>

<form action="" method="POST">

    <label for="nom">Nom</label><br>
    <input type="text" name="nom" id="nom" value=<?= $_SESSION["user"]->uti_nom ?>><br>

    <label for="prenom">Prénom</label><br>
    <input type="text" name="prenom" id="prenom" value=<?= $_SESSION["user"]->uti_prenom ?> ><br>

    <label for="email">Email</label><br>
    <input type="email" name="email" id="email" value=<?= $_SESSION["user"]->uti_email ?>><br>

    <label for="mdp">Mot de passe <a href="">Réinitialiser</a></label><br>
    <input type="submit" value="Envoyer" name="envoyer">
</form>