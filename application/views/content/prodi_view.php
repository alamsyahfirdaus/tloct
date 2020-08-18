<section class="content">
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Daftar <?= $title ?></h3>
        <div class="card-tools">
          <button type="button" onclick="add_prodi()" class="btn btn-tool" title="Tambah <?= $title ?>">
            <i class="fas fa-plus"></i></button>
        </div>
      </div>
      <div class="card-body table-responsive">
      <table id="prodi" class="table table-bordered" style="width:100%">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Program Studi</th>
          <th>Fakultas</th>
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
    <form action="<?= site_url('setting/prodi/save_prodi') ?>" id="form" method="post">
      <div class="modal-body">
        <div class="form-group">
        <label for="prodi_name">Program Studi</label>
        <input type="hidden" name="prodi_id" value="">
          <input type="text" name="prodi_name" id="prodi_name" class="form-control" placeholder="Program Studi" autocomplete="off">
            <small class="help-block text-danger"></small>
        </div>
        <div class="form-group">
          <label for="faculty_id">Fakultas</label>
          <select name="faculty_id" class="form-control select2" style="width: 100%!important" id="faculty_id">
            <option value="">Pilih Fakultas</option>
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
var tb    = "#prodi";
var url   = index + "setting/prodi/show_datatables";
var form  = "#form";
var btn   = "btnsave";

$(document).ready(function() {
  datatable(tb, url);
  form_serialize(form, btn);
  get_fakultas();
});

function add_prodi() {
  reset_form(form);
  $('#modal_form').modal('show');
  $('.modal-title').text('Tambah Program Studi');
}

function get_fakultas() {
  $('#faculty_id ').find('option').not(':first').remove();
  $.getJSON(index + "setting/prodi/get_fakultas", function (data) {
      var option = [];
      for (let i = 0; i < data.length; i++) {
          option.push({
              id: data[i].faculty_id,
              text: data[i].faculty_name
          });
      }
      $('#faculty_id ').select2({
          data: option
      })
  });
}

function edit_prodi(id) {
  reset_form(form);
  $.ajax({
      url : index + "setting/prodi/get_prodi/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
          $('[name="prodi_id"]').val(data.prodi_id);
          $('[name="prodi_name"]').val(data.prodi_name);
          $('[name="faculty_id"]').val(data.faculty_id ).select2();
          $('#modal_form').modal('show');
          $('.modal-title').text('Edit Program Studi');
      }
  });
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
}

function delete_prodi(id) {
  var text = "Akan menghapus Program Studi";
  var url = index + "setting/prodi/delete_prodi/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>