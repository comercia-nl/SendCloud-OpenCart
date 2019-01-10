<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $settings_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $settings_h3; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data"
                      id="form-information" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sendcloud_api_key">API Public Key:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="sendcloud_api_key" value="<?php echo $sendcloud_api_key; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sendcloud_api_secret">API Secret Key:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="sendcloud_api_secret" value="<?php echo $sendcloud_api_secret; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="sendcloud_automate"><?php echo $default_status_label; ?></label>
                        <div class="col-sm-10">
                            <select name="sendcloud_automate" class="form-control">
                                <option value=""><?php echo $default_status; ?></option>
                                <?php foreach ($statuses as $status) { ?>
                                    <option
                                    <?php if ($sendcloud_automate == $status['order_status_id']) { ?>SELECTED<?php } ?>
                                    value="<?php echo $status['order_status_id']; ?>
                                    "><?php echo $status['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="sendcloud_address2_as_housenumber"><?php echo $sendcloud_address2_as_housenumber_label; ?></label>
                        <div class="col-sm-10">
                            <select name="sendcloud_address2_as_housenumber" class="form-control">
                                <option value="">
                                    <?php echo $text_disabled; ?>
                                </option>
                                <option
                                    <?php if ($sendcloud_address2_as_housenumber) { ?> selected <?php } ?> value = "true">
                                    <?php echo $text_enabled; ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <?php echo $shipping_method_heading; ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="sendcloud_status" class="form-control">
                                <option value=""><?php echo $text_disabled; ?></option>
                                <option <?php if ($sendcloud_status) { ?> selected <?php } ?> value = "1"><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $shipping_method_tax_class; ?></label>
                        <div class="col-sm-10">
                            <?php echo comercia\util::html()->selectbox("sendcloud_tax_class_id", $sendcloud_tax_class_id, $tax_classes, "form-control"); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $shipping_method_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="sendcloud_sort_order" value="<?php echo $sendcloud_sort_order; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $entry_locationpicker; ?></label>
                        <div class="col-sm-10">
                            <select name="sendcloud_locationpicker" class="form-control">
                                <option value=""><?php echo $text_disabled; ?></option>
                                <option <?php if ($sendcloud_locationpicker) { ?> selected <?php }?> value = "1"><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="panel-heading"><?php echo $tracking_heading; ?></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_update_url;?></label>
                        <div class="col-sm-10">
                            <div class="form-control"><?php echo $url_api_tracking;?></div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <a class="btn btn-success" href="<?php echo $url_update_tracking; ?>"
                               target="_blank"><?php echo $text_update_tracking?> <i class="fa fa-external-link"></i></a>
                        </div>
                    </div>

                    <div class="panel-heading"><?php echo $maintenance_heading; ?></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <a class="btn btn-primary" href="//panel.sendcloud.sc/" target="_blank">SendCloud Panel
                                <i class="fa fa-external-link"></i></a>
                            <a class="btn btn-success" href="<?php echo $url_patch; ?>"
                               target="_blank"><?php echo $text_patch?> <i class="fa fa-external-link"></i></a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>