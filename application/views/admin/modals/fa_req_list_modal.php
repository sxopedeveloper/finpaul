<style type="text/css">

#requirement_list{
	z-index: 10000000000000;
}

.edit-req-detail{
	cursor: pointer;
	cursor: hand;
	color: #3c94d6;
}

.delete-req-detail{
	cursor: pointer;
	cursor: hand;
	color: #3c94d6;
}
/*#modal-dialog-menu{
	max-width: 400px;
}*/

</style>

<!-- View Modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="requirement_list">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title">Requirement List <span class="pull-right btn btn-primary btn-xs add-requirement-details"><i class="fa fa-plus"></i> &nbsp; Add</span></h4> 
      </div>
      <div class="modal-body" id="requirement_list_body">
      	<div class="add_req_detail_container">
        	<div class="row">
        		<div class="col-md-12">
        			<div class="row row-input">
        				<div class="col-md-4">
        					<label>Short Requirement Name</label>
        				</div>
        				<div class="col-md-8">
        					<input type="text" name="short_name" class="form-control input-sm short_name" id="short_name">
        				</div>
        			</div>
        			<div class="row row-input">
        				<div class="col-md-4">
        					<label>Full Requirement Name</label>
        				</div>
        				<div class="col-md-8">
        					<input type="text" name="full_name" class="form-control input-sm full_name" id="full_name">
        				</div>
        			</div>
        			<div class="row row-input">
        				<div class="col-md-3 col-md-offset-9">
        					<div class="btn-group pull-right">
        						<span class="btn btn-primary btn-xs add-req-details">Add</span>
        						<span class="btn btn-default btn-xs close-req-details">Close</span>
        					</div>
        				</div>
        			</div>
        			<hr>
        		</div>
        	</div>
        </div>
      	<div class="table_container">
	        <div class="row">
	        	<div class="col-md-12">
	        		<table class="table table-bordered table-striped mb-none" id="datatable-default" style="white-space: nowrap;">
	        			<thead>
	        				<th></th>
	        				<th></th>
	        				<th>Short Name</th>
	        				<th>Full Name</th>
	        			</thead>
	        			<tbody id="req_list_tbl_body">
	        				
	        			</tbody>
	        		</table>
	        	</div>
	        </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

