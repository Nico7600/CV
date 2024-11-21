// Code pour activer/désactiver le mode sombre
const darkModeToggle = document.getElementById('darkModeToggle');
darkModeToggle.addEventListener('change', () => {
    document.body.classList.toggle('dark-mode', darkModeToggle.checked);
});

// Code pour animer les barres de progression
function animateProgressBars() {
    const progressBars = document.querySelectorAll('.progress');
    progressBars.forEach(bar => {
        const value = bar.getAttribute('data-value');
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = value + '%';
        }, 100); // Délai pour déclencher l'animation
    });
}
document.addEventListener('DOMContentLoaded', animateProgressBars);

// Code pour gérer l'envoi du formulaire et afficher les notifications
const contactForm = document.getElementById('contactForm');
const successNotification = document.getElementById('successNotification');
const errorNotification = document.getElementById('errorNotification');

contactForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    const formData = new FormData(contactForm);

    fetch(contactForm.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Analyse la réponse comme JSON
    .then(result => {
        if (result.success) {
            successNotification.textContent = result.message;
            successNotification.style.display = 'block';
            setTimeout(() => {
                successNotification.style.display = 'none';
            }, 3000); // Cache la notification après 3 secondes
        } else {
            errorNotification.textContent = result.message;
            errorNotification.style.display = 'block';
            setTimeout(() => {
                errorNotification.style.display = 'none';
            }, 3000); // Cache la notification après 3 secondes
        }
    })
    .catch(error => {
        errorNotification.textContent = "Une erreur s'est produite. Veuillez réessayer.";
        errorNotification.style.display = 'block';
        setTimeout(() => {
            errorNotification.style.display = 'none';
        }, 3000);
    });
});
