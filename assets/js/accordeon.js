// Sélectionner tous les éléments de titre d'accordéon
const accordionTitles = document.querySelectorAll('.accordion-title');

// Parcourir chaque titre d'accordéon et ajouter un écouteur d'événement au clic
accordionTitles.forEach(function(title) {
    title.addEventListener('click', function() {
        // Sélectionner l'élément de contenu correspondant à ce titre
        const content = this.nextElementSibling;
        
        // Vérifier si l'élément de contenu est déjà affiché ou non
        const isContentVisible = content.style.display === 'block';

        // Afficher ou masquer l'élément de contenu en ajoutant ou en supprimant une classe active
        if (isContentVisible) {
            content.style.display = 'none';
            this.classList.remove('active-title');
        } else {
            content.style.display = 'block';
            this.classList.add('active-title');
        }
    });
});


