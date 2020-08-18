<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Edit Pengaturan</h3>
          </div>
          <form action="<?= site_url('setting/other/save_setting/'. $setting_id) ?>" method="post" id="form">
            <div class="card-body">
              <div class="form-group">
                <label for="setting_name">Nama Pengaturan</label>
                <input type="text" name="setting_name" class="form-control" id="setting_name" readonly="" disabled="" value=" <?= $setting_name ?>">
                  <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="setting_value">Pengaturan</label>
                <input type="number" min="1" name="setting_value" class="form-control" id="setting_value" value="<?= $setting_value ?>" autocomplete="off" placeholder="Pengaturan">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea name="description" id="description" class="form-control" placeholder="Keterangan"><?= $description ?></textarea>
                  <small class="help-block text-danger"></small>
              </div>
            </div>
            <div class="card-footer">
              <div class="float-right">
                <button type="button" id="back" onclick="other()" class="btn btn-secondary mr-2"><i class="fas"> Batal</i></button>
                <button type="submit" id="btnsave" class="btn btn-primary float-right"><i class="fas"> Simpan</i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
var form  = "#form";
var btn   = "#btnsave";

$(document).ready(function() {
  form_serialize(form, btn);
});

function action_success() {
  $("#back").click();
}
</script>