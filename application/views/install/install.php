<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdFlex - Installation</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="shortcut icon" href="/assets/imgs/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/vendor.css">
        <link rel="stylesheet" href="/assets/css/app.css">
    </head>
    <body class="login-page">

        <?php if ($requirements_error): ?>

            <div class="row" style="margin-top:200px;">
                <div class="col-md-4 col-md-offset-4">
                    <div class="box box-solid">
                        <div class="box-header with-border bg-red">
                            <i class="icon fa fa-warning"></i>
                            <h3 class="box-title">AdFlex - installation error!</h3>
                        </div>
                        <div class="box-body">
                            <?php echo nl2br($requirements_error); ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <form id="box-install-form">
                <div id="app-login" class="login-box" style="margin-top: 50px;">
                    <div class="login-logo" style="font-size: 180%;">
                        <b style="color: rgb(60, 141, 188);">AD</b>FLEX - Installation
                    </div>
                    <div id="login" class="login-box-body">
                        <div id="box-instal-error" class="callout callout-danger animated fadeIn hidden"></div>
                        <div class="form-group has-feedback">
                            <label>MySQL user</label>
                            <input type="text" name="db_user" class="form-control" autocomplete="off">
                            <span class="fa fa-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label>MySQL password</label>
                            <input type="text" name="db_pass" class="form-control" autocomplete="off">
                            <span class="ion-locked form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label>MySQL database</label>
                            <input type="text" name="db_name" class="form-control" autocomplete="off">
                            <span class="fa fa-database form-control-feedback"></span>
                        </div>
                        <div class="has-feedback">
                            <label>MySQL host</label>
                            <input type="text" name="db_host" class="form-control" autocomplete="off">
                            <span class="fa fa-globe form-control-feedback"></span>
                        </div>
                        <hr style="margin-bottom: 10px;">
                        <div class="form-group has-feedback">
                            <label>Admin email</label>
                            <input type="text" name="admin_email" class="form-control" autocomplete="off">
                            <span class="fa fa-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Admin password</label>
                            <input type="text" name="admin_pass" class="form-control" autocomplete="off">
                            <span class="ion-locked form-control-feedback"></span>
                        </div>
                        <hr style="margin-bottom: 10px;">
                        <div class="form-group has-feedback">
                            <label>
                                Envato purchase code 
                                <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Where is my code?</a>
                            </label>
                            <input type="text" name="purchase_code" class="form-control" autocomplete="off" placeholder="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX">
                            <span class="fa fa-key form-control-feedback"></span>
                        </div>
                        <div>
                            <label></label>
                            <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">
                                Install AdFlex
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div id="box-install-complete" class="row hidden" style="margin-top:200px;">
                <div id="app-login" class="login-box" style="margin-top: 50px;">
                    <div class="login-logo" style="font-size: 180%;">
                        <b style="color: rgb(60, 141, 188);">AD</b>FLEX
                    </div>
                    <div id="login" class="login-box-body">
                        <div id="box-instal-error" class="callout callout-danger animated fadeIn hidden"></div>
                        <div class="form-group">
                            <h4 class="form-group text-center">
                                AdFlex - installation completed successfully!
                            </h4>
                        </div>
                        <div>
                            <label></label>
                            <a href="/" class="btn btn-flat btn-block btn-success">
                                <i class="fa fa-sign-in fa-fw"></i>
                                <span>Sign In</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <script>

            $(function() {

                $('[name="submit"]').on('click', function(e) {
                    e.preventDefault();

                    var $button = $(this);

                    $button.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');

                    var postdata = {
                        install: true,
                        db_user: $('[name="db_user"]').val(),
                        db_pass: $('[name="db_pass"]').val(),
                        db_name: $('[name="db_name"]').val(),
                        db_host: $('[name="db_host"]').val(),
                        admin_email: $('[name="admin_email"]').val(),
                        admin_pass: $('[name="admin_pass"]').val(),
                        purchase_code: $('[name="purchase_code"]').val()
                    };

                    $.post('/install.php', postdata, function(resp) {

                        if (resp.error) {
                            $('#box-instal-error')
                                    .removeClass('hidden')
                                    .html(resp.message.replace(/\n/g, "<br>"));

                            $button.html('Install AdFlex');

                        } else if (!resp.error) {
                            $('#box-install-form').hide();
                            $('#box-install-complete').removeClass('hidden');
                        }

                    }, "json");
                });
            });

        </script>

    </body>
</html>
