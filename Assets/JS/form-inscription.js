document.addEventListener("DOMContentLoaded", function () {
    /* Récupère le formulaire d'inscription de la carte d'authentification. */
    const form = document.querySelector(".auth-card form");

    /* Si le formulaire n'existe pas sur la page, on arrête le script. */
    if (!form) return;

    /* Intercepte l'envoi pour contrôler les champs avant la validation. */
    form.addEventListener("submit", function (e) {
        /* Indique si le formulaire est valide ou non. */
        let valid = true;

        /* Liste des champs à vérifier pour s'assurer qu'ils ne sont pas vides. */
        const champs = ["nom", "prenom", "email", "mdp"];

        /* Parcourt chaque champ pour appliquer la vérification de base. */
        champs.forEach(function (nom) {
            const input = form.querySelector("[name='" + nom + "']");
            const error = form.querySelector("[name='" + nom + "']")
                ?.closest(".form-group")
                ?.querySelector(".form-error");

            /* Si le champ est introuvable, on passe au suivant. */
            if (!input) return;

            /* Vérifie que le champ contient bien une valeur non vide. */
            if (input.value.trim() === "") {
                valid = false;
                input.style.borderColor = "red";
                if (error) error.textContent = "Ce champ est obligatoire.";
            } else {
                input.style.borderColor = "";
            }
        });

        /* Récupère le champ email pour appliquer un contrôle de format. */
        const emailInput = form.querySelector("[name='email']");
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        /* Vérifie que l'email respecte une structure minimale valide. */
        if (emailInput && emailInput.value.trim() !== "" && !emailRegex.test(emailInput.value)) {
            valid = false;
            emailInput.style.borderColor = "red";
            const emailGroup = emailInput.closest(".form-group");
            let error = emailGroup?.querySelector(".form-error");

            /* Crée un message d'erreur si aucun n'existe déjà dans le bloc. */
            if (!error) {
                error = document.createElement("small");
                error.classList.add("form-error");
                emailGroup.appendChild(error);
            }

            error.textContent = "Format d'email invalide.";
        }

        /* Bloque l'envoi si une erreur a été détectée. */
        if (!valid) {
            e.preventDefault();
        }
    });
});
