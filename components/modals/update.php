<style>
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        10%,
        30%,
        50%,
        70%,
        90% {
            transform: translateX(-5px);
        }

        20%,
        40%,
        60%,
        80% {
            transform: translateX(5px);
        }
    }

    .shake {
        animation: shake 0.5s ease-in-out;
    }

    .limit-reached {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
</style>

<div class="modal fade" id="updateModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Update Post
                </h5>
            </div>
            <div class="modal-body">
                <form id="postUploadForm" method="POST" action="/actions/update_action.php">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="updatePostIdInput" name="postId">
                    </div>
                    <div class="mb-3">
                        <!-- the texts -->
                        <textarea id="updatePostBody" class="form-control" name="body" rows="5"
                            placeholder="What's on your mind?" required></textarea>
                        <div id="updatePostLimit" class="form-text">0/300</div>
                    </div>

                    <input type="hidden" id="parentId" name="parent_id" value="0">

                    <input type="hidden" id="postStatus" name="status" value="active">
                    <!-- the image -->
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Add Image (Not working)</label>
                        <input class="form-control" type="file" id="postImage" name="image" accept="image/*">
                        <div class="form-text">Max file size: 5MB</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="postUploadForm" class="btn btn-primary">Post</button>
            </div>
        </div>
    </div>
</div>

<script>
    const updateModal = document.getElementById("updateModal");
    const updatePostIdInput = document.getElementById("updatePostIdInput");
    const updatePostBody = document.getElementById("updatePostBody");
    const updatePostLimit = document.getElementById("updatePostLimit");

    // Focus and Auto input postID
    if (updateModal) {
        updatePostBody.focus();

        updateModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const postId = button.getAttribute('data-bs-postid');

            updatePostIdInput.value = postId;

            const currentupdatePostBody = document.getElementById('post-' + postId + '-body')
            if (currentupdatePostBody) {
            updatePostBody.value = currentupdatePostBody.innerText;
            }
            
        })
    }

    // Limit Text
    function countCharacters(text) {
        const cjkMatches = text.match(cjkRegex);
        const cjkCount = cjkMatches ? cjkMatches.length : 0;
        const nonCjkCount = text.length - cjkCount;
        return cjkCount * 2 + nonCjkCount;
    }

    function showLimitFeedback() {
        console.log("Ye Shunguang's big schlong")
        updatePostBody.classList.add("shake")
        setTimeout(() => {
            updatePostBody.classList.remove('shake');
        }, 500);
    }

    // This is to handle Firefox bs
    updatePostBody.addEventListener("input", updatePostBodyEvent);
    updatePostBody.addEventListener("keyup", updatePostBodyEvent);
    updatePostBody.addEventListener("change", updatePostBodyEvent);
    updatePostBody.addEventListener("paste", updatePostBodyEvent);
    updatePostBody.addEventListener("cut", updatePostBodyEvent);

    function updatePostBodyEvent(e) {
        newBody = e.target.value
        bodyLength = countCharacters(newBody);

        // Remove red border from error
        if (bodyLength <= textLimit) {
            if (updatePostBody.classList.contains('border-danger')) {
                updatePostBody.classList.remove('border-danger')
            }
            if (updatePostLimit.classList.contains('text-danger')) {
                updatePostLimit.classList.remove('text-danger')
            }
        }

        // Remove text if exceeds limit
        if (bodyLength > textLimit) {
            if (e.data != null) {
                updatePostBody.value = newBody.slice(0, -1 * (countCharacters(e.data)));
                showLimitFeedback();
            }
        }

        updatePostLimit.innerHTML = Math.min(bodyLength, 300) + "/" + textLimit;
    }
</script>