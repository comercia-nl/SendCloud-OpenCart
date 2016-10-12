<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
        <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="sendcloud_api_key">API Public Key:</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" name="sendcloud_api_key" value="<?php echo $sendcloud_api_key; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="sendcloud_api_secret">API Secret Key:</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" name="sendcloud_api_secret" value="<?php echo $sendcloud_api_secret; ?>" />
            </div>
           </div>
           <div class="form-group">
            <label class="col-sm-2 control-label" for="sendcloud_automate"><?php echo $default_status_label; ?></label>
            <div class="col-sm-10">
             <select name="sendcloud_automate" class="form-control">
                <option value=""><?php echo $default_status; ?></option>
                <?php
                foreach ($statuses as $status) {
                ?>
                <option <?php if ($sendcloud_automate == $status['order_status_id']) { ?>SELECTED<?php } ?> value="<?php echo $status['order_status_id']; ?>"><?php echo $status['name']; ?></option>
                <?php
                }
                ?>
              </select>
             </div>
            </div>
            <div class="form-group">
             <label class="col-sm-2 control-label" for="sendcloud_address2_as_housenumber"><?php echo $sendcloud_address2_as_housenumber_label; ?></label>
             <div class="col-sm-10">
             <select name="sendcloud_address2_as_housenumber" class="form-control">
                <option value="">
                  <?php echo $text_disabled; ?>
                </option>
                <option <?php if($sendcloud_address2_as_housenumber){?> selected <?php }?> value = "true">
                  <?php echo $text_enabled; ?>
                </option>
             </select>
             </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="sendcloud_address2_as_housenumber"></label>
            <div class="col-sm-10">
             <a class="btn btn-primary" href="http://panel.sendcloud.nl/" target="_blank">SendCloud Panel <i class="fa fa-external-link"></i></a>
            </div>
           </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
