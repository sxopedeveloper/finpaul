<style type="text/css">

/*.viewer_container {
  height: 100%;
  width: 100%;
}*/
#edit_pdf_modal_dialogue{
  height: 1400px;
  width: 1100px;
}
/*#modal-content{
  height: 100%;
  width: 100%;
}*/
#viewer{
  height: 1200px;
  width: 1000px;
}

</style>

<div class="modal fade" tabindex="-1" role="dialog" id="pdf_tron_modal">
  <div class="modal-dialog" id="edit_pdf_modal_dialogue">
    <div class="modal-content" id="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit PDF</h4>
      </div>
      <div class="modal-body" style="height: 100%">
        <div class="viewer_container">
          <div id="viewer"></div>
        </div>
      </div>
      <div class="modal-footer">

          <button type="submit" class="btn btn-success" >Submit</button>
          <button class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->