<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-8">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h5 class="card-title">Daftar <?= $breadcrumb ?></h5>
			</div>
		  <div class="card-body table-responsive">
			<table id="pengaturan" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%" class="text-center">No</th>
				  <th>Nama Pengaturan</th>
				  <th>Pengaturan</th>
				  <th>Keterangan</th>
				  <th width="10%" class="text-center">Aksi</th>
				</tr>
			  </thead>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</section>

<script type="text/javascript">
var tb = "#pengaturan";
var url = index + "setting/other/show_datatables";
var form = "#form";
var btn = "#btnsave";

$(document).ready(function() {
  datatable(tb, url);
});

function edit_setting(id) {
	window.location.href = index + "setting/other/edit/" + id;
}

function edit_lat_lng() {
	window.location.href = index + "setting/other/latlng";
}
</script>