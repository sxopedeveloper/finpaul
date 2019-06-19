                <div id="payment-insert" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add a new Credit Card</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="insert_cc_info" name="insert_cc_info">
                                    <input type="hidden" id="user_id" value="<?= $user_id; ?>" name="user_id">
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>Title: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control input-sm" id="title" name="title">
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Mss">Ms</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>First Name: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control input-sm" name="first_name" id="first_name">
                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>Last Name: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control input-sm" name="last_name" id="last_name">
                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>Credit Card Number: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control input-sm" name="cc_number" id="cc_number" placeholder="Visa or Mastercard only. No spaces and/or dashes">
                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>Credit Card Type: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control input-sm" name="card_type" id="card_type" disabled>
                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>Card Expiry: </label>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control input-sm" id="exp_month" name="exp_month">
                                                <?php
                                                for ($i=1; $i < 13; $i++) 
                                                { 
                                                    echo "<option value='{$i}'>{$i}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control input-sm" id="exp_year" name="exp_year">
                                                <?php
                                                for ($i=16; $i < 51; $i++) 
                                                { 
                                                    echo "<option value='{$i}'>{$i}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-input">
                                        <div class="col-md-4">
                                            <label>CVN: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control input-sm" name="cvn" id="cvn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <span type="button" class="btn btn-primary" id="insert_cc" disabled>Save Info</span>
                            </div>
                        </div>
                    </div>
                </div>