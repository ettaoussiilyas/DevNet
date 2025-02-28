import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Post Manager
const PostManager = {
    init() {
        this.bindEvents();
        ImagePreviewHandler.init();
        TagInputHandler.init();
        LikeHandler.init();
        CommentHandler.init();
        ShareHandler.init();
    },

    bindEvents() {
        // Modal Controls
        window.openPostModal = () => this.openModal();
        window.closePostModal = () => this.closeModal();
        window.togglePostType = (type) => this.togglePostType(type);

        // Form Submission
        const postForm = document.getElementById('postForm');
        if (postForm) {
            postForm.addEventListener('submit', (e) => this.handlePostSubmit(e));
        }

        // Escape key to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeModal();
        });
    },

    openModal() {
        const modal = document.getElementById('postModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        document.getElementById('postContent')?.focus();
    },

    closeModal() {
        const modal = document.getElementById('postModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        this.resetForm();
    },

    resetForm() {
        const form = document.getElementById('postForm');
        if (form) {
            form.reset();
            ImagePreviewHandler.removeExistingPreview();
        }
    },

    togglePostType(type) {
        const sections = {
            image: document.getElementById('imageUpload'),
            video: document.getElementById('videoUpload'),
            article: document.getElementById('articleEditor')
        };

        // Hide all sections first
        Object.values(sections).forEach(section => {
            if (section) section.classList.add('hidden');
        });

        // Show selected section
        if (sections[type]) {
            sections[type].classList.remove('hidden');
        }

        // Update hidden input
        const postTypeInput = document.getElementById('postType');
        if (postTypeInput) postTypeInput.value = type;
    },

    async handlePostSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const submitButton = form.querySelector('[type="submit"]');

        try {
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const result = await response.json();
            this.closeModal();
            window.location.reload(); // Refresh to show new post
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to create post. Please try again.');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Post';
        }
    }
};

// Image Preview Handler
const ImagePreviewHandler = {
    init() {
        const fileInput = document.querySelector('input[type="file"][name="image"]');
        if (fileInput) {
            fileInput.addEventListener('change', this.handleImagePreview.bind(this));
        }
    },

    handleImagePreview(event) {
        const file = event.target.files[0];
        if (!file) return;

        this.removeExistingPreview();

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = this.createPreviewElement(e.target.result);
                const container = event.target.parentElement;
                container.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    },

    removeExistingPreview() {
        const existingPreview = document.getElementById('imagePreview');
        if (existingPreview) {
            existingPreview.remove();
        }
    },

    createPreviewElement(src) {
        const div = document.createElement('div');
        div.id = 'imagePreview';
        div.className = 'mt-3 relative';
        div.innerHTML = `
            <img src="${src}" class="rounded-lg max-h-64 w-full object-contain">
            <button type="button" onclick="ImagePreviewHandler.removeExistingPreview()"
                    class="absolute top-2 right-2 bg-gray-900 bg-opacity-50 rounded-full p-1 hover:bg-opacity-75 transition">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        return div;
    }
};

// Like Handler
const LikeHandler = {
    init() {
        document.querySelectorAll('[data-like-button]').forEach(button => {
            button.addEventListener('click', this.handleLike.bind(this));
        });
    },

    async handleLike(event) {
        const button = event.currentTarget;
        const postId = button.dataset.postId;

        try {
            const response = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const result = await response.json();
            this.updateLikeUI(button, result.liked);
        } catch (error) {
            console.error('Error:', error);
        }
    },

    updateLikeUI(button, isLiked) {
        button.classList.toggle('text-blue-600', isLiked);
        button.classList.toggle('text-gray-600', !isLiked);
    }
};

// Initialize everything when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    PostManager.init();
});

// Export handlers for global access
window.ImagePreviewHandler = ImagePreviewHandler;
window.PostManager = PostManager;
window.LikeHandler = LikeHandler;
