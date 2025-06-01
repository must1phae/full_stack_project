const GEMINI_API_KEY = 'AIzaSyD7tSYmmRZlYJ02_0_vLo1idKQIO7VhnDw'; // 🔐 Remplace par ta clé Gemini
 
document.addEventListener('DOMContentLoaded', () => {
    const chatbotIcon = document.getElementById('chatbotIcon');
    const chatbotWindow = document.getElementById('chatbotWindow');
    const closeChatbotButton = document.getElementById('closeChatbot');
    const actionButtons = document.querySelectorAll('.chatbot-action');
    const chatbotResponseArea = document.getElementById('chatbotResponse');

    if (!GEMINI_API_KEY || GEMINI_API_KEY === 'VOTRE_CLE_API_ICI') {
        chatbotIcon.style.display = 'none';
        return;
    }

    chatbotIcon.addEventListener('click', () => {
        chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
    });

    closeChatbotButton.addEventListener('click', () => {
        chatbotWindow.style.display = 'none';
    });

    actionButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const action = button.dataset.action;

            if (!notesForChatbot.trim()) {
                chatbotResponseArea.innerHTML = "Il n'y a pas de notes à analyser.";
                return;
            }

            chatbotResponseArea.innerHTML = '⏳ Traitement en cours...';

            const context = `Ces notes concernent le module "${currentModuleNameForChatbot}".\nNotes :\n${notesForChatbot}`;
            let prompt = "";

            switch (action) {
                case 'summarize':
                    prompt = context + "\n\nFais un résumé clair et structuré.";
                    break;
                case 'define':
                    prompt = context + "\n\nDéfinis les termes et concepts importants.";
                    break;
                case 'quiz':
                    prompt = context + "\n\nGénère un quiz de 5 QCM avec réponses.";
                    break;
            }

            try {
                const result = await callGeminiAPI(prompt);
                chatbotResponseArea.innerHTML = formatResponse(result);
            } catch (e) {
                chatbotResponseArea.innerHTML = `Erreur IA : ${e.message}`;
            }
        });
    });

    async function callGeminiAPI(promptText) {
        const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${GEMINI_API_KEY}`;

        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                contents: [{ parts: [{ text: promptText }] }]
            })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.error?.message || "Erreur API");
        return data?.candidates?.[0]?.content?.parts?.[0]?.text || "Réponse vide.";
    }

    function formatResponse(text) {
        return text
            .replace(/\n/g, '<br>')
            .replace(/^(Question\s*\d+:)/gim, '<strong>$1</strong>')
            .replace(/^(Bonne réponse:)/gim, '<strong>$1</strong>');
    }
});
