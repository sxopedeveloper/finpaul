<?php
//echo '<pre>';print_r($makes);exit;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Finquote </title>
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css'); ?>" />
        <!-- bootstrap datepicker -->

        <link rel="stylesheet" href="<?= base_url();?>assets/vendor/sweetalert/sweetalert.css">

        <link rel="shortcut icon" href="<?= base_url();?>assets/img/favicon.png" type="image/x-icon">

    </head>
    <body>
        <section class="quote-request-main">
            <div class="container">
                <div class="row">
                    <div class="quote-request-inner">
                        <div class="col-md-12">
                            <img src="<?php echo base_url('assets/img/finquote.png'); ?>" width="250" height="auto" class="img-responsive" alt="finquote-logo">
                            <div class="text-center" style="color:white;">
                                Quote Submitted Successfully...
                            </div>
                            <br>
                            <div class="row">
                                <div class="row vertical-center-row">
                                    <div class="text-center col-md-4 col-md-offset-4" style="">
                                        <img src="<?=base_url();?>assets/img/tick-in-circle.png" class="img-rounded" alt="Cinque Terre">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="text-center"  style="color:white;">
                                    <h2>Thank you.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.2/jquery.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js'); ?>?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js'); ?>?v=<?php echo time();?>"></script>

        <!-- Sweet Alert -->
        <script src="<?=base_url('assets/vendor/sweetalert/sweetalert.min.js');?>?v=<?php echo time();?>"></script>
    </body>
</html>