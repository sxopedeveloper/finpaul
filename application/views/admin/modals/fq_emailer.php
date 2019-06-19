<!-- Modal -->
<div class="modal fade" id="fq_emailer" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Email Templates</h4>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary" id="create_email_button"><i class="fa fa-plus"></i> New Template</button><br /><br />
        <table class="table table-striped table-condensed mb-none" style="white-space: nowrap;" id="datatables_email">
          <thead>
            <tr>
              <td><i class="fa fa-pencil-square-o"></i></td>
              <td><i class="fa fa-trash-o"></i></td>
              <td><b>Description</b></td>
              <td><b>Subject</b></td>
              <!-- <td><b>Attachment Path</b></td>-->
              <td><b>Created</b></td>
              <td><b>Last Updated</b></td>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($email_templates as $email_template)
            {                     
              ?>
              <tr id="email_template_main_row_<?php echo $email_template['id_email_template']; ?>" style="color:black">
                <td>
                  <span class="open-emailtemplate-details" data-email_template_id="<?php echo $email_template['id_email_template']; ?>" style="cursor: pointer; cursor: hand; color: #3c94d6;">
                    <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit Email Template"></i>
                  </span>
                </td>
                <td>
                  <span class="delete_email_template" data-email_template_id="<?php echo $email_template['id_email_template']; ?>" style="cursor: pointer; cursor: hand; color: #3c94d6;">
                    <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" data-original-title="Delete Email Template"></i>
                  </span>
                </td>
                <td id="email_description_main_row_<?php echo $email_template['id_email_template']; ?>">
                  <?php echo $email_template['description']; ?>
                </td>
                <td id="email_subject_main_row_<?php echo $email_template['id_email_template']; ?>">
                  <?php echo $email_template['subject']; ?>
                </td>
                <td><?php echo $email_template['created_at']; ?></td>
                <td><?php echo $email_template['last_updated']; ?></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--System Email template Model Start-->
<div class="modal fade" id="system_mail_template_model" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">System Email Templates</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-condensed mb-none" style="white-space: nowrap;" id="datatables_email">
          <thead>
            <tr>
              <td><i class="fa fa-pencil-square-o"></i></td>
              <td><b>Description</b></td>
              <td><b>Subject</b></td>
              <td><b>Created</b></td>
              <td><b>Last Updated</b></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($system_email_templates as $email_template) { ?>
              <tr>
                <td>
                    <span class="open-edit-emailtemplate" data-email_template_id="<?=$email_template['id_email_template'];?>" style="cursor: pointer; cursor: hand; color: #3c94d6;">
                        <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit Email Template"></i>
                    </span>
                </td>
                <td id="email_description_main_row_<?php echo $email_template['id_email_template']; ?>">
                  <?php echo $email_template['description']; ?>
                </td>
                <td id="email_subject_main_row_<?php echo $email_template['id_email_template']; ?>">
                  <?php echo $email_template['subject']; ?>
                </td>
                <td><?php echo $email_template['created_at']; ?></td>
                <td><?php echo $email_template['last_updated']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--System Email template Model End-->

<div id="open_email_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%;">
    <section class="panel">
      <header class="panel-heading">
        <h2 class="panel-title">Send Email</h2>
      </header>
      <div class="panel-body">
        <div class="modal-wrapper">
          <div class="modal-text">
            <input value="" id="email_template_id" name="email_template_id" type="hidden">
            <div class="form-group">
              <div class="input-group email_recipient_group" style="margin-bottom: 10px;">
             
                <input value="" class="form-control multi_email_recipients email_recipients" id="email_recipients" name="email_recipients" type="text" placeholder="Recipients" data-role="tagsinput">
               
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default dropdown-toggle ddown_emails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-right edit_template_recipient">
                    
                  </ul>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input value="" class="form-control" id="email_subject" name="email_subject" type="text" placeholder="Subject">
            </div>
          
            <div class="form-group">
              <div class="attachment_container">
               
                  
               
              </div>
            </div>
            <div class="form-group">
              <div class="summernote" id="email_content" name="email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary send_email_template" >Send Email</button>
            <button type="button" class="btn btn-primary save_email_template" >Save Email</button>
          </div>
        </div>
      </footer>
    </section>          
  </div>
</div>

<div id="send_blank_email_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%;">
    <section class="panel">
      <header class="panel-heading">
        <h2 class="panel-title">Send Email</h2>
      </header>
      <div class="panel-body">
        <div class="modal-wrapper">
          <div class="modal-text">
            <div class="form-group">
              <div class="input-group email_recipient_group" style="margin-bottom: 10px;">
                <input value="" class="form-control multi_email_recipients send_email_recipients" id="send_email_recipients" name="send_email_recipients" type="text" placeholder="Recipients" data-role="tagsinput">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default dropdown-toggle ddown_emails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    
                  </ul>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input value="" class="form-control" id="send_email_subject" name="send_email_subject" type="text" placeholder="Subject">
            </div>
            
            <div class="form-group attachment_container">
              <div class="input-group email_attachment_group" style="margin-bottom: 10px;">
                <select class="form-control input-sm send_email_attachment_select" name="send_email_attachment_select[]">
                
                </select>
                <span class="input-group-addon add_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-plus"></i></span>
                <span class="input-group-addon remove_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-times"></i></span>
              </div>
            </div>
            <div class="form-group">
              <div class="summernote" id="send_email_content" name="send_email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'></div>
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary send_blank_email" >Send Email</button>                     
          </div>
        </div>
      </footer>
    </section>          
  </div>
</div>

<div id="create_email_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%;">
    <section class="panel">
      <header class="panel-heading">
        <h2 class="panel-title">Create New Email Template</h2>
      </header>
      <div class="panel-body">
        <div class="modal-wrapper">
          <div class="modal-text">

          <div class="form-group">
            <div class="col-md-12">
              <div class="input-group email_recipient_group" style="margin-bottom: 10px;">
                <input value="" class="form-control multi_email_recipients email_recipients " id="email_recipients" name="email_recipients" type="text" placeholder="Recipients" data-role="tagsinput">
                
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default dropdown-toggle ddown_emails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-right new_template_recipient">
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>

            <div class="form-group">
              <div class="col-md-12">
                <input value="" class="form-control" id="new_email_description" name="new_email_description" type="text" placeholder="Description">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <input value="" class="form-control" id="new_email_subject" name="new_email_subject" type="text" placeholder="Subject">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-2 col-md-offset-10">
                <label class="pull-right">Visibility</label>
                <select class="form-control" name="new_email_visibility" id="new_email_visibility">
                  <option value="1">Global</option>
                  <option value="0">Personal</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 attachment_container">
               
                  <div class="input-group email_attachment_group" style="margin-bottom: 10px;">
                  
                      <select class="form-control input-sm new_email_attachment_select" name="new_email_attachment_select[]" id="new_email_attachment_select">
                      
                      </select>
                      <span class="input-group-addon add_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-plus" style="display:block"></i></span>
                      <span class="input-group-addon remove_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-times"></i></span>
                  </div>
              </div> 
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <div class="summernote" id="new_email_content" name="new_email_content" data-plugin-summernote data-plugin-options='{ "height": 240, "codemirror": { "theme": "ambiance" } }'>

                  <p><br></p>
                  <p><br></p>
                  <p><br></p>
                  <p ><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;">Kind Regards,</span></p>
                  <table border="0">
                    <tbody>
                      <tr>
                        <td rowspan="3">
                          <p><img src="https://staging-new.finquote.com.au/assets/img/signature_logo.png" /></p>
                        </td>
                        <td>
                        <table>
                          <tbody>
                            <tr>
                              <td>
                              <div style="padding-left: 10px;margin:0px; text-align:start; -webkit-text-stroke-width:0px"><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;"><b><span style="color:#969696">Paul Rouse</span></b> </span></div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                              <div style="padding-left: 10px;font-size:14px;margin:0px; text-align:start; -webkit-text-stroke-width:0px"><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;"><b><span style="color:#969696">FIN</span></b><b><span style="color:#16C40E">QUOTE</span></b></span></div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                              <div style="padding-left: 10px;font-size:14px;margin:0px; text-align:start; -webkit-text-stroke-width:0px"><span style="font-size:14px;font-family:Calibri,Verdana,Geneva,sans-serif;"><span style="color:#969696">Office 1300 221 466 | Direct 02 9984 9126 | Mobile 0403 919 995</span></span></div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary create_email_template_btn" >Insert New Email</button>                     
          </div>
        </div>
      </footer>
    </section>          
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="email_trail_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 90%;">
    <div class="modal-content" style="background-color: black !important;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Email History</h4>
      </div>
      <div class="modal-body" id="sent_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="forward_email_modal" class="modal fade">
  <div class="modal-dialog" style="width: 80%;">
    <section class="panel">
      <header class="panel-heading">
        <h2 class="panel-title">Send Email</h2>
      </header>
      <div class="panel-body">
        <div class="modal-wrapper">
          <div class="modal-text">
            <input value="" id="sent_email_id" name="sent_email_id" type="hidden">
            <div class="form-group">
              <div class="input-group email_recipient_group" style="margin-bottom: 10px;">
                <input value="" class="form-control multi_email_recipients email_recipients" id="email_recipients" name="email_recipients" type="text" placeholder="Recipients" data-role="tagsinput">
               
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default dropdown-toggle ddown_emails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    
                  </ul>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input value="" class="form-control" id="email_subject" name="email_subject" type="text" placeholder="Subject">
            </div>
            <div class="form-group attachment_container">
              <div class="input-group email_attachment_group" style="margin-bottom: 10px;">
                <select class="form-control input-sm email_attachment_select" name="email_attachment_select[]">
                
                </select>
                <span class="input-group-addon add_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-plus"></i></span>
                <span class="input-group-addon remove_attachment" style="cursor: pointer;cursor: hand;"><i class="fa fa-times"></i></span>
              </div>
            </div>
            <div class="form-group">
              <div id="html_message" style="border-style: solid; border-width: 1px;">
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary forward_email" >Send Email</button>
          </div>
        </div>
      </footer>
    </section>          
  </div>
</div>

<div class="modal fade" id="email_list_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 40%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Email List<span class="btn btn-primary btn-xs pull-right open_add_email_modal"><i class="fa fa-plus"></i>Add</span></h4>
      </div>
      <div class="modal-body" id="email_list_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_email_list_item" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 40%;">
    <div class="modal-content">
      <div class="modal-body" id="email_list_body">
        <input type="text" class="form-control input-sm " placeholder="Email" name="email" id="email_list_value">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add_email_to_list" >Add</button>
      </div>
    </div>
  </div>
</div>

<!--Edit Email template form model start-->

<div id="email_template_model" class="modal fade">
   <div class="modal-dialog" style="width: 80%;">
      <section class="panel">
         <header class="panel-heading">
            <h2 class="panel-title" id="mail_template_subject"></h2>
         </header>
         <form id="frm_edit_mail_template" action="" method="post">
            <div class="panel-body">
               <div class="modal-wrapper">
                  <div class="modal-text">
                     <input id="email_template_id" value="" name="email_template_id" type="hidden">
                     <div class="form-group">
                        <textarea name="template_content" id="edit_template_content" class="edit_template_content" rows="10" cols="80"></textarea>
                                * Please Don't edit the "@@" quoted text, As it is coming from database and need not to be edited
                     </div>
                  </div>
               </div>
            </div>
            <footer class="panel-footer">
               <div class="row">
                  <div class="col-md-12 text-right">
                     <!-- <button type="button" class="btn btn-primary preview_system_email_template">Preview</button> -->
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary save_system_email_template" >Save</button>
                  </div>
               </div>
            </footer>
         </form>
      </section>
   </div>
</div>

<div id="preview_email_template_model" class="modal fade">
   <div class="modal-dialog" style="width: 80%;">
      <section class="panel">
         <header class="panel-heading">
            <h2 class="panel-title">Preview Template</h2>
         </header>
         <form action="" method="post">
            <div class="panel-body">
               <div class="modal-wrapper">
                        
               </div>
            </div>
            <footer class="panel-footer">
               <div class="row">
                  <div class="col-md-12 text-right">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" >Save</button>
                  </div>
               </div>
            </footer>
         </form>
      </section>
   </div>
</div>
<!--Edit Email template form model End-->