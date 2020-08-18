<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-8">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $title ?></h3>
				<div class="card-tools">
				  <button type="button" onclick="add_fakultas()" class="btn btn-tool" title="Tambah <?= $title ?>">
				    <i class="fas fa-plus"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="fakultas" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
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
	  <form action="<?= site_url('setting/faculty/save_fakultas') ?>" id="form" method="post">
	    <div class="modal-body">
	      <div class="form-group">
	        <label for="faculty_name">Fakultas</label>
	    	<input type="hidden" name="faculty_id" value="">
	        <input type="text" name="faculty_name" id="faculty_name" class="form-control" placeholder="Fakultas" autocomplete="off">
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
var tb = "#fakultas";
var url = index + "setting/faculty/show_datatables";
var form = "#form";
var btn = "#btnsave";

$(document).ready(function() {
	datatable(tb, url);
	form_serialize(form, btn);
});

function add_fakultas() {
	reset_form(form);
	$('#modal_form').modal('show');
	$('.modal-title').text('Tambah Fakultas');
}

function edit_fakultas(id) {
  reset_form(form);
    $.ajax({
        url : index + "setting/faculty/get_fakultas/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="faculty_id"]').val(data.faculty_id);
            $('[name="faculty_name"]').val(data.faculty_name);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Fakultas');
        }
    });
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
}

function delete_fakultas(id) {
  var text = "Akan menghapus Fakultas";
  var url = index + "setting/faculty/delete_fakultas/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>