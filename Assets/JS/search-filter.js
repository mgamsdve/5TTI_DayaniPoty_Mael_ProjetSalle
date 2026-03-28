// Normalise une valeur pour que la recherche soit insensible aux majuscules,
// aux accents et aux espaces superflus.
function normalizeSearchValue(value) {
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

// Initialise un filtre de recherche sur les options d'une liste déroulante.
// La recherche réduit les choix affichés dans le select.
function initSelectSearch(config) {
    // Récupère le champ de recherche, le select et le message éventuel.
    const input = document.querySelector(config.inputSelector);
    const select = document.querySelector(config.selectSelector);
    const emptyMessage = document.querySelector(config.emptySelector);

    // Sans champ ou sans select, la fonctionnalité ne peut pas fonctionner.
    if (!input || !select) {
        return;
    }

    // Sauvegarde toutes les options d'origine avant de commencer à filtrer.
    const sourceOptions = Array.from(select.options).map(function (option) {
        return {
            value: option.value,
            text: option.textContent,
            disabled: option.disabled
        };
    });

    // Fonction appelée à chaque frappe dans la recherche.
    const filterOptions = function () {
        // Recherche normalisée pour comparer les libellés des options.
        const query = normalizeSearchValue(input.value);
        // Conserve la valeur actuellement sélectionnée pour essayer de la restaurer.
        const currentValue = select.value;
        // Indique si au moins une option non vide correspond à la recherche.
        let hasMatch = false;

        // On reconstruit le contenu du select à chaque saisie pour n'afficher que les options utiles.
        select.innerHTML = "";

        // Parcourt les options d'origine et garde seulement celles qui correspondent.
        sourceOptions.forEach(function (optionData) {
            // La première option vide est généralement un placeholder et doit rester disponible.
            const isPlaceholder = optionData.value === "";
            // Une option est conservée si elle est vide, si la recherche est vide,
            // ou si son texte contient la requête.
            const matches = isPlaceholder || query === "" || normalizeSearchValue(optionData.text).includes(query);

            // Si l'option ne correspond pas, on ne l'ajoute pas au select.
            if (!matches) {
                return;
            }

            // Recrée une option DOM à partir des données sauvegardées.
            const option = document.createElement("option");
            option.value = optionData.value;
            option.textContent = optionData.text;
            option.disabled = optionData.disabled;

            // Conserve la sélection actuelle si cette option existe encore après filtrage.
            if (optionData.value === currentValue) {
                option.selected = true;
            }

            // Une vraie option correspondante signifie qu'il y a au moins un résultat.
            if (!isPlaceholder) {
                hasMatch = true;
            }

            // Ajoute l'option filtrée dans la liste déroulante.
            select.appendChild(option);
        });

        // Si la valeur sélectionnée n'existe plus, on réinitialise le select.
        if (!Array.from(select.options).some(function (option) { return option.value === currentValue; })) {
            select.value = "";
        }

        // Affiche le message d'absence de résultats quand aucune option ne correspond.
        if (emptyMessage) {
            emptyMessage.hidden = hasMatch || query === "";
        }
    };

    // Le filtrage se déclenche à chaque changement du champ de recherche.
    input.addEventListener("input", filterOptions);
}
