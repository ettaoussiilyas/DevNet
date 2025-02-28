import './bootstrap';
import Alpine from 'alpinejs';

console.log('App.js loaded');


window.Alpine = Alpine;
Alpine.start();

// Make all functions globally available through the window object
window.openPostModal = function() {
    document.getElementById('postModal').classList.remove('hidden');
}

window.closePostModal = function() {
    document.getElementById('postModal').classList.add('hidden');
}

window.togglePostType = function(type) {
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

window.toggleComments = function(postId) {
    console.log('Toggle comments clicked for post:', postId);
    const commentsSection = document.getElementById(`comments-${postId}`);
    console.log('Comments section element:', commentsSection);
    commentsSection.classList.toggle('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('postModal');
    if (event.target === modal) {
        closePostModal();
    }
}

// Initialize comment functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Handle comment form submission
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const textarea = this.querySelector('textarea');
            const content = textarea.value.trim();

            if (!content) return;

            fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: content })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add new comment to the list
                        const commentsList = document.querySelector(`#comments-list-${postId}`);
                        const newComment = createCommentElement(data.comment);
                        commentsList.insertAdjacentHTML('afterbegin', newComment);

                        // Update comment count
                        const commentButton = document.querySelector(`button[onclick="toggleComments('${postId}')"]`);
                        commentButton.textContent = `Comment (${data.count})`;

                        // Clear textarea
                        textarea.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error posting comment:', error);
                });
        });
    });
});

function createCommentElement(comment) {
    return `
        <div class="flex space-x-3 comment-item">
            <img src="${comment.user.avatar}" class="w-8 h-8 rounded-full">
            <div class="flex-1 bg-gray-50 rounded-lg p-3">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold">${comment.user.name}</h4>
                    <span class="text-xs text-gray-500">${comment.created_at}</span>
                </div>
                <p class="text-sm mt-1">${comment.content}</p>
            </div>
        </div>
    `;
}
