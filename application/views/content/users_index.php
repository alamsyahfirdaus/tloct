<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Daftar <?= $title ?></h3>
            <div class="card-tools">
              <button type="button" onclick="add_user()" class="btn btn-tool" title="Tambah <?= $title ?>">
                <i class="fas fa-user-plus"></i></button>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table id="master" class="table table-bordered" style="width:100%">
              <input type="hidden" name="user_type_id" value="<?= @$user_type_id ?>">
              <input type="hidden" name="uti" value="<?= md5(@$user_type_id) ?>">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>No. Induk</th>
                  <th>Nama Lengkap</th>
                  <th>Username</th>
                  <th>No. Handphone</th>
                  <th width="5%" class="text-center" >Aksi</th>
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
var tb  = "#master";
var url = index + "users/show_datatables?id=" + $('[name="user_type_id"]').val();

$(document).ready(function() {
  datatable(tb, url);
});

function add_user() {
  window.location.href = index + "users/insert/" + $('[name="uti"]').val();
}

function detail_user(id) {
  window.location.href = index + "users/show/" + id;
}

function edit_user(id) {
  window.location.href = index + "users/edit/" + id;
}

function delete_user(id, name) {
  var text = "Akan menghapus " + name;
  var url = index + "users/delete/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>