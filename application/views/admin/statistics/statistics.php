<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Статистика'); ?> > <?php _e('Кабинет админиcтратора'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var('current_currency', get_globalsettings('current_currency', 'USD')); ?>
    </head>

    <body class="hold-transition skin-red fixed sidebar-mini">

        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1><?php _e('Статистика'); ?></h1>

                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li class="active"><?php _e('Статистика'); ?></li>
                    </ol>
                </section>


                <section class="content">

                    <?php include_once dirname(__FILE__) . "/_nav.php"; ?>

                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-body table-responsive">
                                    <table id="_datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php _e('День'); ?></th>
                                                <th><?php _e('Показы'); ?></th>
                                                <th><?php _e('Клики'); ?></th>
                                                <th><?php _e('CTR'); ?></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

            </div>

            <footer class="main-footer"></footer>
            <div class="control-sidebar-bg"></div>
        </div>

        <?php include_once dirname(dirname(__DIR__)) . "/_scripts.php"; ?>

    </body>
</html>
