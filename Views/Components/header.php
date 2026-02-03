<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/Salle">Salle</a></li>
    <?php if(isset($_SESSION["user"])) : ?>
        <li><a href="/deconnexion">Deconnexion</a></li>
        <li><a href="/Profil">Profil</a></li>
    <?php else :?>
        <li><a href="/connexion">Connexion</a></li>
        <li><a href="/inscription">Insription</a></li>
    <?php endif ?>
    <li><a href="/Utilisateur">Utilisateur</a></li>
</ul>