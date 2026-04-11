// Normalise une valeur pour que la recherche soit insensible aux majuscules,
// aux accents et aux espaces superflus.
function normalizeSearchValue(value) {
    // Transforme la valeur en chaîne comparable pour simplifier les recherches.
    return String(value || "")
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .trim();
}

// Initialise un filtre de recherche classique sur une liste d'éléments.
// La saisie dans le champ masque ou affiche les éléments correspondants.
function initSearchFilter(config) {
    // Récupère les éléments nécessaires dans le DOM.
    const input = document.querySelector(config.inputSelector);
    const emptyMessage = document.querySelector(config.emptySelector);

    // Si le champ ou le message n'existe pas, on arrête l'initialisation.
    if (!input || !emptyMessage) {
        return;
    }

    // Convertit la liste cible en tableau pour pouvoir la parcourir facilement.
    const rows = Array.from(document.querySelectorAll(config.itemSelector));
    // S'il n'y a aucun élément à filtrer, il n'y a rien à faire.
    if (rows.length === 0) {
        return;
    }

    // Permet de garder l'affichage d'origine si besoin, par exemple "flex" ou "block".
    const displayVisible = config.visibleDisplay || "";

    // Fonction appelée à chaque saisie dans la barre de recherche.
    const filterItems = function () {
        // Valeur tapée par l'utilisateur, normalisée pour faciliter la comparaison.
        const query = normalizeSearchValue(input.value);
        let visibleCount = 0;

        // Parcourt chaque élément de la liste et décide s'il doit être affiché.
        rows.forEach(function (item) {
            // On cherche le texte à comparer dans data-search si disponible,
            // sinon on utilise le texte visible de l'élément.
            const haystack = normalizeSearchValue(item.dataset.search || item.textContent);
            // L'élément est visible si la recherche est vide ou si le texte contient la requête.
            const isVisible = query === "" || haystack.includes(query);
            // Affiche ou masque l'élément selon le résultat du test.
            item.style.display = isVisible ? displayVisible : "none";

            // Compte les éléments visibles pour savoir si la liste est vide.
            if (isVisible) {
                visibleCount += 1;
            }
        });

        // Affiche le message d'absence de résultat uniquement si aucun élément ne correspond.
        emptyMessage.hidden = visibleCount !== 0;
    };

    // Le filtrage se lance à chaque modification du champ de recherche.
    input.addEventListener("input", filterItems);
}
