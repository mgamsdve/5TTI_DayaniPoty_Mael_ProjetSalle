document.addEventListener("DOMContentLoaded", function () {
    /* Récupère le formulaire de création de réservation. */
    const form = document.querySelector("form[action='/create-reservation']");

    /* Si le formulaire n'est pas présent, le script s'arrête immédiatement. */
    if (!form) return;

    /* Contrôle les dates au moment de l'envoi du formulaire. */
    form.addEventListener("submit", function (e) {
        /* Récupère les deux champs de dates à comparer. */
        const dateDebut = form.querySelector("[name='dateDebut']");
        const dateFin = form.querySelector("[name='dateFin']");

        /* Si les champs sont absents, aucune validation n'est possible. */
        if (!dateDebut || !dateFin) return;

        /* Convertit les valeurs des champs en objets Date pour comparer les dates. */
        const debut = new Date(dateDebut.value);
        const fin = new Date(dateFin.value);

        /* N'applique la validation que si les deux dates ont bien été renseignées. */
        if (dateDebut.value && dateFin.value) {
            /* Vérifie que la date de fin est strictement après la date de début. */
            if (fin <= debut) {
                e.preventDefault();
                alert("La date de fin doit être après la date de début.");
                dateFin.style.borderColor = "red";
                return;
            }

            /* Calcule la durée de réservation en jours. */
            const diffJours = (fin - debut) / (1000 * 60 * 60 * 24);

            /* Bloque la soumission si la durée dépasse la limite autorisée. */
            if (diffJours > 5) {
                e.preventDefault();
                alert("La durée maximale de réservation est de 5 jours.");
                dateFin.style.borderColor = "red";
                return;
            }

            /* Réinitialise le style de bordure si la validation est correcte. */
            dateFin.style.borderColor = "";
        }
    });
});
