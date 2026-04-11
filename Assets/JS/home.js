// Anime un compteur numérique jusqu'à atteindre une valeur cible.
function animateCounter(el, target, duration = 1500) {
    // Valeur de départ et incrément calculé pour lisser l'animation.
    let start = 0;
    const step = target / (duration / 16);

    // Intervalle court pour faire évoluer le compteur de manière fluide.
    const timer = setInterval(() => {
        start += step;

        if (start >= target) {
            el.textContent = String(target);
            clearInterval(timer);
            return;
        }

        el.textContent = String(Math.floor(start));
    }, 16);
}

// Observe le scroll pour déclencher des animations quand un bloc devient visible.
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            // La classe CSS "visible" lance l'animation d'apparition.
            entry.target.classList.add("visible");
        }
    });
}, { threshold: 0.15 });

// Sélectionne tous les éléments marqués pour apparaître au scroll.
document.querySelectorAll(".animate-on-scroll").forEach((el) => {
    scrollObserver.observe(el);
});

// Repère la zone des statistiques pour n'animer les compteurs qu'au bon moment.
const statsSection = document.querySelector("#stats-section");
// Empêche de relancer les compteurs plusieurs fois.
let countersStarted = false;

if (statsSection) {
    // Observe l'entrée de la section statistiques dans le viewport.
    const countersObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !countersStarted) {
                // Déclenche les compteurs une seule fois lorsque la section devient visible.
                countersStarted = true;
                document.querySelectorAll("[data-counter-target]").forEach((counter) => {
                    // Lit la cible numérique depuis l'attribut data-*.
                    const target = Number.parseInt(counter.getAttribute("data-counter-target"), 10);
                    if (!Number.isNaN(target)) {
                        // Lance l'animation sur chaque compteur valide.
                        animateCounter(counter, target);
                    }
                });
                // Inutile de continuer à observer une fois l'animation lancée.
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.25 });

    // Démarre l'observation de la section des statistiques.
    countersObserver.observe(statsSection);
}
