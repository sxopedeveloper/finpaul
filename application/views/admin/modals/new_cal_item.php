<!-- Modal -->
<div class="modal fade" id="new_calendar_modal" tabindex="-1" role="dialog" aria-labelledby="new_calendar_modal">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Create New Calendar Item</h4>
         </div>
         <div class="modal-body">
            <form class="new-cal-form" method="post">
               <div class="table-responsive">
                  <table class="table table-bordered table-striped table-condensed mb-none" style="white-space: nowrap;">
                     <tbody>
<!--                         <tr>
                           <td>FQ Staff</td>
                           <td>
                              <select name="fk_user" class="form-control input-sm fq-staff">
                                 
                              </select>
                           </td>
                        </tr> -->
                        <tr>
                           <td>Client First Name</td>
                           <td><input type="text" class="form-control input-sm client-first-name" name="lead_first_name"></td>
                        </tr>
                        <tr>
                           <td>Client Last Name</td>
                           <td><input type="text" class="form-control input-sm client-last-name" name="lead_last_name"></td>
                        </tr>
                        <tr>
                           <td>Client Email</td>
                           <td><input type="text" class="form-control input-sm client-email" name="lead_email"></td>
                        </tr>
                        <tr>
                           <td>Primary Number</td>
                           <td><input class="form-control input-sm client-phone masked" name="lead_phone"></td>
                        </tr>
                        <tr>
                           <td>Source</td>
                           <td><input type="text" class="form-control input-sm client_source" name="client_source"></td>
                        </tr>
                        <tr>
                           <td>State</td>
                           <td>
                              <select class="form-control input-sm client-state" name="lead_state">
                                 <option value="NSW">NSW</option>
                                 <option value="VIC">VIC</option>
                                 <option value="QLD">QLD</option>
                                 <option value="WA">WA</option>
                                 <option value="TAS">TAS</option>
                                 <option value="NT">NT</option>
                                 <option value="ACT">ACT</option>
                              </select>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save_new_cal_item">Save</button>
         </div>
      </div>
   </div>
</div>