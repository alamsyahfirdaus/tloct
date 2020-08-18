<section class="content">
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Daftar <?= $title ?></h3>
        <div class="card-tools">
          <button type="button" onclick="add_ruangan()" class="btn btn-tool" title="Tambah <?= $title ?>">
            <i class="fas fa-plus"></i></button>
        </div>
      </div>
      <div class="card-body table-responsive">
      <table id="ruangan" class="table table-bordered" style="width:100%">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Ruangan</th>
          <th>Lantai</th>
          <th>Bangunan</th>
          <th width="5%" class="text-center">Aksi</th>
        </tr>
        </thead>
      </table>
      </div>
    </div>
    </div>
  </div>
  </div>
</section>

<div class="modal fade" id="modal_form">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">#</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <form action="<?= site_url('setting/room/save_ruangan') ?>" id="form" method="post">
      <div class="modal-body">
        <input type="hidden" name="room_id" value="">
        <div class="form-group">
        <label for="room_name">Ruangan</label>
          <input type="text" name="room_name" id="room_name" class="form-control" placeholder="Ruangan" autocomplete="off">
            <small class="help-block text-danger"></small>
        </div>
        <div class="form-group">
        <label for="lantai">Lantai</label>
          <input type="number" min="0" name="lantai" id="lantai" class="form-control" placeholder="Lantai" autocomplete="off">
            <small class="help-block text-danger"></small>
        </div>
        <div class="form-group">
          <label for="building_id">Bangunan</label>
          <select name="building_id" class="form-control select2" style="width: 100%!important" id="building_id">
            <option value="">Pilih Bangunan</option>
          </select>
          <small class="help-block text-danger"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="reload_table()" class="btn btn-secondary" data-dismiss="modal"><i class="fas"> Batal</i></button>
        <button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
      </div>
    </form>
  </div>
  </div>
</div>

<script type="text/javascript">
var tb    = "#ruangan";
var url   = index + "setting/room/show_datatables";
var form  = "#form";
var btn   = "btnsave";

$(document).ready(function() {
  datatable(tb, url);
  form_serialize(form, btn);
  get_bangunan();
});

function add_ruangan() {
  reset_form(form);
  $('#modal_form').modal('show');
  $('.modal-title').text('Tambah Ruangan');
}

function get_bangunan() {
  $('#building_id').find('option').not(':first').remove();
  $.getJSON(index + "setting/room/get_bangunan", function (data) {
      var option = [];
      for (let i = 0; i < data.length; i++) {
          option.push({
              id: data[i].building_id,
              text: data[i].building_name
          });
      }
      $('#building_id').select2({
          data: option
      })
  });
}

function edit_ruangan(id) {
  reset_form(form);
  $.ajax({
      url : index + "setting/room/get_ruangan/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
          $('[name="room_id"]').val(data.room_id);
          $('[name="room_name"]').val(data.room_name);
          $('[name="lantai"]').val(data.lantai);
          $('[name="building_id"]').val(data.building_id).select2();
          $('#modal_form').modal('show');
          $('.modal-title').text('Edit Ruangan');
      }
  });
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
}

function delete_ruangan(id) {
  var text = "Akan menghapus Ruangan";
  var url = index + "setting/room/delete_ruangan/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>