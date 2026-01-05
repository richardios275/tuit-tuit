<div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Post
                        </h5>
                    </div>
                    <div class="modal-body">
                        <form id="postUploadForm" method="POST" action="actions/post_action.php">
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