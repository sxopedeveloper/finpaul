<div class="modal fade" role="dialog" id="all_requirements_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">All Requirements</h4>
      </div>
      <input type="hidden" id="all_req_modal_id" value="">
      <input type="hidden" id="all_req_user" value="">
      <div class="modal-body" id="allreq_modal_body">
        <div class="row all_req_button" style="margin-bottom: 15px;">
          <div class="col-md-12">
            <a class="btn btn-success btn-xs add-allreq"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a>
          </div>
        </div>
        <hr class="all_req_button">
        <div class="all_req_container">
        </div>
        <hr>
        <div class="row" style="margin-top: 15px;">
          <div class="col-md-12 list-merged-requirements">

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="progress progress-striped light active" style="margin: 10px;" id="progress_bar" hidden>
          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">10%
          </div>
        </div>
        <button type="button" class="btn btn-success" id="all_merge_file">Initialize</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->