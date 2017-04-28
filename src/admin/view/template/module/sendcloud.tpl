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
                            <input class="form-control" type="text" name="sendcloud_api_key"
                                   value="<?php echo $sendcloud_api_key; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sendcloud_api_secret">API Secret Key:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="sendcloud_api_secret"
                                   value="<?php echo $sendcloud_api_secret; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="sendcloud_automate"><?php echo $default_status_label; ?></label>
                        <div class="col-sm-10">
                            <select name="sendcloud_automate" class="form-control">
                                <option value=""><?php echo $default_status; ?></option>
                                <?php
                foreach ($statuses as $status) {
                ?>
                                <option
                                <?php if ($sendcloud_automate == $status['order_status_id']) { ?>SELECTED<?php } ?>
                                value="<?php echo $status['order_status_id']; ?>
                                "><?php echo $status['name']; ?></option>
                                <?php
                }
                ?>
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
                                <?php if($sendcloud_address2_as_housenumber){ ?> selected <?php }?> value = "true">
                                <?php echo $text_enabled; ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-heading">
                        <?php echo $checkout_header_label; ?>
                    </div>
                    <div id="checkout-method">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_method_label; ?>
                            </label>
                            <div class="col-sm-8">
                                <input type="button" class="btn btn-success checkout-picker-button" id=""
                                       value="<?php echo $checkout_method_picker_label; ?>">
                                <input type="button" class="btn btn-warning checkout-advanced-button"
                                       value="<?php echo $checkout_method_advanced_label; ?>">
                            </div>
                        </div>
                    </div>

                    <div id="checkout-disable">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_method_label; ?>
                            </label>
                            <div class="col-sm-8">
                                <input type="button" class="btn btn-danger checkout-disable-button" id=""
                                       value="<?php echo $checkout_disable_label; ?>">
                            </div>
                        </div>
                    </div>

                    <div id="checkout-picker">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_presets_label; ?>
                            </label>
                            <div class="col-sm-8">
                                <?php
                                $selected = !empty($sendcloud_checkout_preset) ? $sendcloud_checkout_preset : "";
                    echo comercia\util::html()->
                                selectbox("checkout_preset_options",$selected,$checkout_presets,"form-control");
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" class="form-control btn btn-success" id="checkout_preset_apply"
                                       value="<?php echo $checkout_apply_label; ?>">
                            </div>
                        </div>
                    </div>
                    <div id="checkout-advanced">
                        <input type="hidden" name="sendcloud_checkout_preset" value="<?php echo $sendcloud_checkout_preset?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_picker_route_label; ?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_route"
                                       value="<?php echo $sendcloud_checkout_route; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo $checkout_picker_selector_label; ?></label>
                            <div class="col-sm-2">
                                <?php
                    echo comercia\util::html()->
                                selectbox("sendcloud_checkout_picker_position",$sendcloud_checkout_picker_position,$checkout_picker_position_options,"form-control");
                                ?>
                            </div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="sendcloud_checkout_picker_selector"
                                       value="<?php echo $sendcloud_checkout_picker_selector; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_address_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_address"
                                       value="<?php echo $sendcloud_checkout_selector_address; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_address2_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_address2"
                                       value="<?php echo $sendcloud_checkout_selector_address2; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_city_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_city"
                                       value="<?php echo $sendcloud_checkout_selector_city; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_postcode_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_postcode"
                                       value="<?php echo $sendcloud_checkout_selector_postcode; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_country_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_country"
                                       value="<?php echo $sendcloud_checkout_selector_country; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_zone_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_zone"
                                       value="<?php echo $sendcloud_checkout_selector_zone; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_fake_click_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_fake_click"
                                       value="<?php echo $sendcloud_checkout_selector_fake_click; ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?php echo $checkout_selector_button_css_label ;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sendcloud_checkout_selector_button_css"
                                       value="<?php echo $sendcloud_checkout_selector_button_css; ?>"/>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sendcloud_address2_as_housenumber"></label>
                        <div class="col-sm-10">
                            <a class="btn btn-primary" href="//panel.sendcloud.sc/" target="_blank">SendCloud Panel
                                <i class="fa fa-external-link"></i></a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>