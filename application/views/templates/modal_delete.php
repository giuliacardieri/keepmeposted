<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <div class="modal-body">
                <p>Delete Postcard?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary delete" data-dismiss="modal" data-href="<?php echo site_url('postcard/delete/' . $this->uri->segment(2)); ?>">Delete</button>
            </div>
        </div>
    </div>
</div>