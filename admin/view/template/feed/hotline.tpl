<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-hotline" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1 class="panel-title"> <?php echo $heading_title; ?></h1>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $edit_heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-hotline" class="form-horizontal">        
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-firm-id"><?php echo $entry_hotline_firm_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="hotline_firm_id" id="input-firm-id" class="form-control" value="<?php echo $hotline_firm_id ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-guarantee"><?php echo $entry_hotline_guarantee; ?></label>
            <div class="col-sm-10">
              <input type="text" name="hotline_guarantee" id="input-guarantee" class="form-control" value="<?php echo $hotline_guarantee ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_hotline_category; ?></label>
            <div class="col-sm-10">
              <select name="hotline_categories[]" id="input-category" class="form-control" multiple="multiple" size = "10">
                <?php foreach ($categories as $category) { ?>
                  <option value="<?php echo $category['category_id'] ?>" <?php echo $category['selected'] ? "selected = 'selected'" : "" ?>><?php echo $category['name'] ?></option>
                <?php } ?>
              </select>
              <?php echo $note_category; ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="hotline_status" id="input-status" class="form-control">
                <?php if ($hotline_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-data-feed"><?php echo $entry_data_feed; ?></label>
            <div class="col-sm-10">
              <textarea rows="5" readonly="readonly" id="input-data-feed" class="form-control"><?php echo $data_feed; ?></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
