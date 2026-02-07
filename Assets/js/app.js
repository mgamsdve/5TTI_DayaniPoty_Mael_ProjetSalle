const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = 1;
      entry.target.style.transform = "translateY(0)";
    }
  });
});

document.querySelectorAll(".salle, .form-card").forEach((el) => {
  el.style.opacity = 0;
  el.style.transform = "translateY(20px)";
  observer.observe(el);
});
const hero = document.querySelector(".hero");

if (hero) {
  hero.addEventListener("mousemove", (e) => {
    const x = e.clientX / window.innerWidth - 0.5;
    const y = e.clientY / window.innerHeight - 0.5;

    hero.style.backgroundPosition = `
            ${50 + x * 10}% ${50 + y * 10}%,
            ${50 - x * 10}% ${50 - y * 10}%,
            center
        `;
  });
}
const cards = document.querySelectorAll(".salle");

cards.forEach((card) => {
  card.addEventListener("mousemove", (e) => {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    card.style.transform = `
            perspective(800px)
            rotateX(${-(y - rect.height / 2) / 30}deg)
            rotateY(${(x - rect.width / 2) / 30}deg)
            translateY(-6px)
        `;
  });

  card.addEventListener("mouseleave", () => {
    card.style.transform = "translateY(0)";
  });
});
