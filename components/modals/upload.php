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

<div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Post
                </h5>
            </div>
            <div class="modal-body">
                <form id="postUploadForm" method="POST" action="/actions/post_action.php">
                    <div class="mb-3">
                        <!-- the texts -->
                        <textarea id="post-body" class="form-control" name="body" rows="5"
                            placeholder="What's on your mind?" required></textarea>
                        <div id="post-limit" class="form-text">0/300</div>
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
    const uploadModal = document.getElementById("uploadModal");
    const postBody = document.getElementById("post-body");
    const postLimit = document.getElementById("post-limit");

    // Focus
    if (uploadModal) {
        postBody.focus();
    }

    // Limit Text
    const textLimit = 300;
    const cjkRegex =
        /[\u3040-\u309F\u30A0-\u30FF\u4E00-\u9FFF\u3400-\u4DBF\uAC00-\uD7AF\u3130-\u318F\u1100-\u11FF]/g;

    function countCharacters(text) {
        const cjkMatches = text.match(cjkRegex);
        const cjkCount = cjkMatches ? cjkMatches.length : 0;
        const nonCjkCount = text.length - cjkCount;
        return cjkCount * 2 + nonCjkCount;
    }

    function showLimitFeedback() {
        console.log("Ye Shunguang's big schlong")
        postBody.classList.add("shake")
        setTimeout(() => {
            postBody.classList.remove('shake');
        }, 500);
    }

    // This is to handle Firefox bs
    postBody.addEventListener("input", postBodyEvent);
    postBody.addEventListener("keyup", postBodyEvent);
    postBody.addEventListener("change", postBodyEvent);
    postBody.addEventListener("paste", postBodyEvent);
    postBody.addEventListener("cut", postBodyEvent);

    function postBodyEvent(e) {
        newBody = e.target.value
        bodyLength = countCharacters(newBody);

        // Remove red border from error
        if (bodyLength <= textLimit) {
            if (postBody.classList.contains('border-danger')) {
                postBody.classList.remove('border-danger')
            }
            if (postLimit.classList.contains('text-danger')) {
                postLimit.classList.remove('text-danger')
            }
        }

        // Remove text if exceeds limit
        if (bodyLength > textLimit) {
            if (e.data != null) {
                postBody.value = newBody.slice(0, -1 * (countCharacters(e.data)));
                showLimitFeedback();
            }
        }

        postLimit.innerHTML = Math.min(bodyLength, 300) + "/" + textLimit;
    }
</script>