import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Add this to your resources/js/app.js or create a new file

function openPostModal() {
    document.getElementById('postModal').classList.remove('hidden');
}

function closePostModal() {
    document.getElementById('postModal').classList.add('hidden');
}

function togglePostType(type) {
    const codeEditor = document.getElementById('codeEditor');
    const imageUpload = document.getElementById('imageUpload');

    if (type === 'snippet') {
        codeEditor.classList.remove('hidden');
        imageUpload.classList.add('hidden');
    } else {
        codeEditor.classList.add('hidden');
        imageUpload.classList.remove('hidden');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('postModal');
    if (event.target === modal) {
        closePostModal();
    }
}

function toggleComments(postId) {
    const commentsSection = document.getElementById(`comments-${postId}`);
    commentsSection.classList.toggle('hidden');
}
