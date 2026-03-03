<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/Salle">Salle</a></li>
    <?php if(isset($_SESSION["user"])) : ?>
        <li><a href="/Reservation">Mes reservation</a></li>
        <li><a href="/Equipement">Equipement</a></li>
        <li><a href="/Profil">Profil</a></li>
        <li><a href="/Utilisateur">Utilisateur</a></li>
    <?php else :?>
        <li><a href="/connexion">Connexion</a></li>
        <li><a href="/inscription">Inscription</a></li>
    <?php endif ?>
</ul>
