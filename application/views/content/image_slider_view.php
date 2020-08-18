<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-8">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<div class="card-title">Daftar <?= $title ?></div>
				<div class="card-tools">
				  <button type="button" onclick="add_slider()" class="btn btn-tool" title="Tambah <?= $title ?>">
				    <i class="fas fa-plus"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="slider" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>Keterangan</th>
				  <th class="text-center">Gambar</th>
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
	  <form action="<?= site_url('setting/imageslider/save_slider') ?>" id="form" method="post" enctype="multipart/form-data">
	    <div class="modal-body">
    	<input type="hidden" name="id_image_slider" value="">
	      <div class="form-group">
	        <label for="description">Keterangan</label>
	        <textarea name="description" id="description" class="form-control"></textarea>
            <small class="help-block text-danger"></small>
	      </div>
	      <div class="form-group">
	        <label for="image">Gambar</label>
	        <div class="input-group">
	          <div class="custom-file">
	            <input type="file" class="custom-file-input" id="image" name="image">
	            <label class="custom-file-label" for="image" id="label-img"></label>
	          </div>
	        </div>
	      </div>
	      <div class="form-group" id="preview"></div>
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
var tb = "#slider";
var url = index + "setting/imageslider/show_datatables";
var form = "#form";
var btn = "#btnsave";

$(document).ready(function() {
	datatable(tb, url);
	form_multipart(form, btn);
});

function add_slider() {
	reset_form(form);
	$('#modal_form').modal('show');
	$('.modal-title').text('Tambah Image Slider');
	$('#preview').hide();
	$('#label-img').text('');
}

function edit_slider(id) {
  reset_form(form);
    $.ajax({
        url : index + "setting/imageslider/get_slider/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_image_slider"]').val(data.id_image_slider);
            $('[name="description"]').val(data.description);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Image Slider');

            if (data.image) {
            	$('#label-img').text(data.image);
	            $('#preview').show();
	            $('#preview').html('<img src="'+ data.url_image +'" class="img-thumbnail" alt="Photo">');
	            $('#preview').append('<input type="checkbox" name="remove_image" value="'+ data.image +'"> Hapus Gambar');
            } else {
            	$('#preview').hide();
            	$('#label-img').text('');
            }
        }
    });
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
}

function delete_slider(id) {
  var text = "Akan menghapus Image Slider";
  var url = index + "setting/imageslider/delete_slider/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>