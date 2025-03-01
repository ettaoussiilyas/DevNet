// home.js

document.addEventListener('DOMContentLoaded', function() {

    alert('JavaScript file loaded successfully!');
});
document.addEventListener('DOMContentLoaded', function() {
    // Handle post creation
    const postForm = document.querySelector('form[action*="posts"]');
    if (postForm) {
        postForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await axios.post(this.action, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.data.success) {
                    // Clear the form
                    this.reset();
                    // Optionally reload the page or append the new post
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error creating post:', error);
                alert('Failed to create post. Please try again.');
            }
        });
    }

    // Handle like functionality
    document.addEventListener('click', async function(e) {
        if (e.target.matches('[data-like-button]')) {
            e.preventDefault();
            const postId = e.target.dataset.postId;
            const likeButton = e.target;
            const likeCount = likeButton.querySelector('.like-count');
            const likeIcon = likeButton.querySelector('svg');

            try {
                const response = await axios.post(`/posts/${postId}/like`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.data) {
                    // Update like count
                    if (likeCount) {
                        likeCount.textContent = response.data.count;
                    }

                    // Toggle liked state
                    if (response.data.liked) {
                        likeButton.classList.add('text-blue-600');
                        likeButton.classList.remove('text-gray-600');
                    } else {
                        likeButton.classList.remove('text-blue-600');
                        likeButton.classList.add('text-gray-600');
                    }
                }
            } catch (error) {
                console.error('Error toggling like:', error);
                alert('Failed to update like. Please try again.');
            }
        }
    });

    // Handle comment submission
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('[data-comment-form]')) {
            e.preventDefault();
            const form = e.target;
            const postId = form.dataset.postId;
            const commentInput = form.querySelector('textarea');
            const commentsContainer = document.querySelector(`#comments-container-${postId}`);
            const commentCount = document.querySelector(`#comment-count-${postId}`);

            try {
                const response = await axios.post(`/posts/${postId}/comments`, {
                    content: commentInput.value
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.data.success) {
                    // Clear input
                    commentInput.value = '';

                    // Update comment count
                    if (commentCount) {
                        commentCount.textContent = response.data.count;
                    }

                    // Add new comment to the list
                    if (commentsContainer && response.data.comment) {
                        const commentHTML = `
                            <div class="flex space-x-3 p-4 border-t">
                                <img src="${response.data.comment.user.avatar}" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold">${response.data.comment.user.name}</p>
                                    <p class="text-gray-600">${response.data.comment.content}</p>
                                </div>
                            </div>
                        `;
                        commentsContainer.insertAdjacentHTML('afterbegin', commentHTML);
                    }
                }
            } catch (error) {
                console.error('Error posting comment:', error);
                alert('Failed to post comment. Please try again.');
            }
        }
    });

    // Handle image upload preview
    const imageInput = document.querySelector('input[type="file"][name="image"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You could add preview functionality here if needed
                    console.log('Image selected');
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
