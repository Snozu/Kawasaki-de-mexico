<!-- Container -->
<div class="asl-p-cont asl-new-bg">
<div class="hide">
  <svg xmlns="http://www.w3.org/2000/svg">
    <symbol id="i-plus" viewBox="0 0 32 32" width="13" height="13" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <title>Add</title>
        <path d="M16 2 L16 30 M2 16 L30 16" />
    </symbol>
    <symbol id="i-trash" viewBox="0 0 32 32" width="13" height="13" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <title>Trash</title>
        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
    </symbol>
    <symbol id="i-edit" viewBox="0 0 32 32" width="13" height="13" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <title>Edit</title>
        <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
    </symbol>
    <symbol id="i-info" viewBox="0 0 32 32" width="13" height="13" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <path d="M16 14 L16 23 M16 8 L16 10" />
        <circle cx="16" cy="16" r="14" />
    </symbol>
  </svg>
</div>
  <div class="container">
    <div class="row asl-inner-cont">
      <div class="col-md-12 asl-lock-box">
        <div class="card p-0 mb-4">
          <h3 class="card-title"><?php echo esc_attr__('Manage Markers','asl_locator') ?></h3>
          <div class="card-body">
          <?php if(!is_writable(ASL_PLUGIN_PATH.'public/icon')): ?>
            <h6  class="alert alert-danger" style="font-size: 14px"><?php echo ASL_PLUGIN_PATH.'public/icon' ?> <= <?php echo esc_attr__('Directory is not writable, Marker Image Upload will Fail, Make directory writable.','asl_locator') ?></h6>
          <?php endif; ?>
            <div class="row mb-4">
              <div class="col-md-12 ralign">
                <a target="_blank" href="https://agilestorelocator.com/marker-generator-tool/" class="btn disabled btn-primary mrg-r-10"><?php echo esc_attr__('Generate Tool','asl_locator') ?></a>
                <button type="button" id="btn-asl-delete-all" class="btn disabled btn-danger mrg-r-10"><i><svg width="13" height="13"><use xlink:href="#i-trash"></use></svg></i><?php echo esc_attr__('Delete Selected','asl_locator') ?></button>
                <button type="button" id="btn-asl-new-c" class="btn disabled btn-success mrg-r-10"><i><svg width="13" height="13"><use xlink:href="#i-plus"></use></svg></i><?php echo esc_attr__('New Marker','asl_locator') ?></button>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="table-responsive">
              	<table id="tbl_markers" class="display table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th align="center"><input type="text" class="form-control sml" data-id="id"  disabled="disabled" style="opacity: 0"/></th>
                        <th align="center"><input class="form-control" type="text" data-id="id"  placeholder="<?php echo esc_attr__('Search ID','asl_locator') ?>"  /></th>
                        <th align="center"><input class="form-control" type="text" data-id="marker_name"  placeholder="<?php echo esc_attr__('Search Name','asl_locator') ?>"  /></th>
                        <th align="center">&nbsp;</th>
                        <th align="center">&nbsp;</th>
                      </tr>
                      <tr>
                        <th align="center"><a class="select-all"><?php echo esc_attr__('Select All','asl_locator') ?></a></th>
                        <th align="center"><?php echo esc_attr__('Marker ID','asl_locator') ?></th>
                        <th align="center"><?php echo esc_attr__('Name','asl_locator') ?></th>
                        <th align="center"><?php echo esc_attr__('Icon','asl_locator') ?></th>
                        <th align="center"><?php echo esc_attr__('Action','asl_locator') ?>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>
            </div>
          	<div class="dump-message asl-dumper"></div>
          </div>
          
        </div>
          <div class="asl-lock-inner">
                <svg width="70" height="100" viewBox="0 0 90 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M82.5 52.5H75V30C75 13.5 61.5 0 45 0C28.5 0 15 13.5 15 30V52.5H7.5C3.75 52.5 0 56.25 0 60V112.5C0 116.25 3.75 120 7.5 120H82.5C86.25 120 90 116.25 90 112.5V60C90 56.25 86.25 52.5 82.5 52.5ZM52.5 105H37.5L40.5 88.5C36.75 87 33.75 82.5 33.75 78.75C33.75 72.75 39 67.5 45 67.5C51 67.5 56.25 72.75 56.25 78.75C56.25 83.25 54 87 49.5 88.5L52.5 105ZM60 52.5H30V30C30 21.75 36.75 15 45 15C53.25 15 60 21.75 60 30V52.5Z" fill="white"/></svg>
                <h6><?php echo esc_attr__('Upgrade Plugin To Get Markers Manager','asl_locator') ?></h6>
                <a href="https://codecanyon.net/item/agile-store-locator-google-maps-for-wordpress/16973546"><?php echo esc_attr__('Lifetime License - $59','asl_locator') ?></a>
              </div>
      </div>
    </div>
  </div>

<!-- Edit Alert -->
<div class="smodal fade" id="asl-update-modal" role="dialog">
  <div class="smodal-dialog" role="document">
    <div class="smodal-content">
      <form id="frm-updatemarker" name="frm-updatemarker">
      <div class="smodal-header">
        <h5 class="smodal-title"><?php echo esc_attr__('Update Marker','asl_locator') ?></h5>
        <button type="button" class="close" data-dismiss="smodal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="smodal-body">
        <div class="row">
          <div class="col-md-12 form-group mb-3">
            <label class="control-label">Marker ID</label>
            <input type="text" class="form-control" readonly="readonly"  name="data[marker_id]" id="update_marker_id_input">
          </div>
          <div class="col-md-12 form-group mb-3">
            <label for="txt_name"  class="control-label"><?php echo esc_attr__('Name','asl_locator') ?></label>
            <input type="text" class="form-control validate[required]" name="data[marker_name]" id="update_marker_name">
          </div>
          <div class="col-md-12 form-group mb-3" id="updatemarker_image">
             <img  src="" id="update_marker_icon" alt="" data-id="same" style="max-width: 80px;max-height: 80px"/>
             <button type="button" class="btn disabled btn-default" id="change_image"><?php echo esc_attr__('Change','asl_locator') ?></button>
          </div>

          <div class="col-md-12 form-group mb-3" style="display:none" id="updatemarker_editimage">                  
            <div class="input-group" id="drop-zone">
              <div class="input-group-prepend">
                <span class="input-group-text"><?php echo esc_attr__('Icon','asl_locator') ?></span>
              </div>
              <div class="custom-file">
                <input type="file" accept=".jpg,.png,.jpeg,.gif,.JPG,.svg" class="btn disabled btn-default" name="files" id="file-logo-1" />
                <label  class="custom-file-label" for="file-logo-1"><?php echo esc_attr__('File Path...','asl_locator') ?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="progress hideelement" style="display:none" id="progress_bar_">
                  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                      <span style="position:relative" class="sr-only">0% Complete</span>
                  </div>
              </div>
            </div>
            <ul></ul>
          </div>
          <p id="message_update"></p>
        </div>
        <div class="smodal-footer">
          <button class="btn disabled btn-primary btn-start mrg-r-15" id="btn-asl-update-markers"   type="button" data-loading-text="<?php echo esc_attr__('Submitting ...','asl_locator') ?>"><?php echo esc_attr__('Update Marker','asl_locator') ?></button>
          <button type="button" class="btn disabled btn-default" data-dismiss="smodal"><?php echo esc_attr__('Cancel','asl_locator') ?></button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="smodal fade" id="asl-add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="smodal-dialog" role="document">
    <div class="smodal-content">
      <form id="frm-addmarker" name="frm-upload-marker">
      <div class="smodal-header">
        <h5 class="smodal-title"><?php echo esc_attr__('Upload Marker','asl_locator') ?></h5>
        <button type="button" class="close" data-dismiss="smodal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="smodal-body">
        <div class="row">
          <div class="col-md-12 form-group mb-3">
              <label for="txt_marker-name"><?php echo esc_attr__('Marker Name','asl_locator') ?></label>
              <input type="text" id="txt_marker-name" name="data[marker_name]" class="form-control">
          </div>
          <div class="col-md-12 form-group mb-3" id="drop-zone-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><?php echo esc_attr__('Icon','asl_locator') ?></span>
              </div>
              <div class="custom-file">
                <input name="files" type="file" class="custom-file-input" accept=".jpg,.png,.jpeg,.gif,.JPG,.svg" id="file-logo-2">
                <label  class="custom-file-label" for="file-logo-2"><?php echo esc_attr__('File Path...','asl_locator') ?></label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="progress hideelement progress_bar_" style="display:none">
              <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                <span style="position:relative" class="sr-only">0% Complete</span>
              </div>
            </div>
          </div>
          <ul></ul>
          <div class="col-12"><p id="message_upload_1" class="alert alert-warning hide"></p></div>
        </div>
      </div>
      <div class="smodal-footer">
        <button type="button" data-loading-text="<?php echo esc_attr__('Submitting ...','asl_locator') ?>" class="btn disabled btn-start btn-primary"><?php echo esc_attr__('Upload','asl_locator') ?></button>
        <button type="button" class="btn disabled btn-default" data-dismiss="smodal"><?php echo esc_attr__('Close','asl_locator') ?></button>
      </div>
      </form>
    </div>
  </div>
</div>

</div>
<!-- asl-cont end-->