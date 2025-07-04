document.addEventListener('DOMContentLoaded', function() {
    // pour la deconnexion


    // Charger les détails du message si on est sur la page de détails
    if (window.location.pathname.includes('detail_msg.html')) {
        loadMessageDetails();
    }
});

function loadMessageDetails() {
    // Récupérer l'ID du message depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const messageId = urlParams.get('id');
    
    if (!messageId) {
        console.error('Aucun ID de message trouvé dans l\'URL');
        return;
    }
    
   
    const messages = {
        '1': {
            fullName: 'Dina Kerrouche',
            phone: '0612345678',
            date: '15/04/2023 14:30',
            message: 'Bonjour, je voulais savoir si vous pouviez m\'aider avec un problème que j\'ai rencontré lors de l\'utilisation de votre service. Le problème concerne...'
        },
        '2': {
            fullName: 'Fatima Merzouk',
            phone: '0698765432',
            date: '14/04/2023 10:15',
            message: 'J\'ai un problème avec mon compte depuis hier. Chaque fois que j\'essaie de me connecter, je reçois un message d\'erreur. Pouvez-vous m\'aider?'
        },
        '3': {
            fullName: 'Siham Merzouk',
            phone: '0698765432',
            date: '13/04/2023 16:45',
            message: 'Merci pour votre aide hier. Le problème est maintenant résolu. Je voulais juste vous remercier pour votre excellent service client!'
        }
    };
    
    const message = messages[messageId];
    
    if (message) {
        document.getElementById('detail-name').textContent = message.fullName;
        document.getElementById('detail-phone').textContent = message.phone;
        document.getElementById('detail-date').textContent = message.date;
        document.getElementById('detail-message').textContent = message.message;
    } else {
        console.error('Message non trouvé');
        alert('Message non trouvé');
        window.location.href = 'messages.html';
    }
}