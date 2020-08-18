<section class="content">
  <div class="container-fluid">
    <form action="<?= site_url('users/save') ?>" method="post" id="form">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle . ' ' . $title ?></h3>
              <?php if (@$user->user_type_id == 2): ?>
                <div class="card-tools">
                  <button type="button" onclick="window.history.back()" class="btn btn-tool" title="Kembali">
                    <i class="fas fa-arrow-circle-left"></i></button>
                </div>
              <?php endif ?>
            </div>
            <input type="hidden" name="user_id" value="<?= md5(@$user->user_id) ?>">
            <div class="card-body">
              <div class="form-group">
                <label for="no_induk">No. Induk</label>
                <input type="number" min="0" class="form-control" id="no_induk" name="no_induk" value="<?= @$user->no_induk ?>" placeholder="No. Induk" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= @$user->full_name ?>" placeholder="Nama Lengkap">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"value="<?= @$user->username ?>" placeholder="Username" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="phone">No. Handphone</label>
                <input type="number" min="0" class="form-control" id="phone" name="phone" value="<?= @$user->phone ?>" placeholder="No. Handphone" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="birth_day">Tanggal Lahir</label>
                <?php $date = date('m/d/Y', strtotime(@$user->birth_day)); ?>
                <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask name="birth_day" id="birth_day" value="<?php if(@$user->user_id) echo $date ?>" placeholder="Tanggal Lahir">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="user_type_id">Jenis Pengguna</label>
                <select class="form-control" name="user_type_id" id="user_type_id">
                  <option value="">Pilih Jenis Pengguna</option>
                  <?php foreach ($user_type as $row) : ?>
                    <?php if (@$user->user_type_id): ?>
                      <option value="<?= $row->user_type_id ?>" <?php if($user->user_type_id == $row->user_type_id) echo 'selected'; ?>><?= $row->type_name ?></option>
                    <?php else: ?>
                      <option value="<?= $row->user_type_id ?>" <?php if($user_type_id == $row->user_type_id) echo "selected"; ?>><?= $row->type_name ?></option>
                    <?php endif ?>
                  <?php endforeach ?>
                </select>
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="prodi_id">Program Studi</label>
                <select class="form-control select2" name="prodi_id" id="prodi_id">
                  <option value="">Pilih Program Studi</option>
                  <?php foreach ($prodi as $row) : ?>
                     <option value="<?= $row->prodi_id ?>" <?php if(@$user->prodi_id == $row->prodi_id) echo 'selected'; ?>><?= $row->prodi_name ?></option>
                  <?php endforeach ?>
                </select>
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="profile_pic">Foto Profile</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_pic" name="profile_pic">
                    <label class="custom-file-label" for="profile_pic"><?= (@$user->profile_pic) ? $user->profile_pic : set_value('profile_pic')  ?></label>
                  </div>
                  <div class="input-group-append">
                    <button type="button" <?php if(!@$user->user_id || !@$user->profile_pic) echo "disabled"; ?> class="btn btn-default" data-toggle="modal" data-target="#modal_form"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="password1">Password</label>
                <input type="password" class="form-control" id="password1" name="password1" placeholder="Password <?php if(@$user->user_id) echo '(biarkan kosong jika tidak akan mengganti)' ?>">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="password2">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="password2" name="password2" placeholder="Konfirmasi Password">
                  <small class="help-block text-danger"></small>
              </div>
            </div>
            <div class="card-footer">
              <div class="float-right">
                <button type="button" id="back" onclick="window.history.back()" class="btn btn-secondary mr-2"><i class="fas"> Batal</i></button>
                <button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
              </div>
            </div>
          </div>
        </div>

        <?php if (@$user->user_type_id == 2): ?>

          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Detail Dosen</h3>
                <div class="card-tools">
                  <button type="button" onclick="maps()" class="btn btn-tool" title="Map">
                    <i class="fas fa-map-marker-alt"></i></button>
                </div>
              </div>
              <input type="hidden" name="detail_dosen_id" value="<?= @$user->user_id ?>">
              <div class="card-body">
                <div class="form-group">
                  <label for="lat">Latitude</label>
                  <input type="text" class="form-control" id="lat" name="lat" value="<?= @$latitude ?>" placeholder="Latitude" readonly="">
                  <small class="help-block text-danger"></small>
                </div>
                <div class="form-group">
                  <label for="lng">Longitude</label>
                  <input type="text" class="form-control" id="lng" name="lng" value="<?= @$longitude ?>" placeholder="Longitude" readonly="">
                  <small class="help-block text-danger"></small>
                </div>
                <div class="form-group">
                  <label for="room_id">Ruangan</label>
                  <select class="form-control select2" name="room_id" id="room_id">
                    <option value="">Pilih Ruangan</option>
                    <?php foreach ($room as $row) : ?>
                       <option value="<?= $row->room_id ?>" <?php if(@$room_id == $row->room_id) echo 'selected'; ?>><?= $row->room_name ?></option>
                    <?php endforeach ?>
                  </select>
                  <small class="help-block text-danger"></small>
                </div>
              </div>
            </div>
          </div>

          <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBYY-wMcvr6cGuSynbDsfyABKsGzOlz9X0&callback=initMap"></script>
          <script type="text/javascript">
          var lat  = $('[name=lat]').val();
          var lng  = $('[name=lng]').val();
          var url  = index + 'home/map/?lat=' + lat + '&&lng=' + lng;

          function initialize() {

          var propertiPeta = {
              center:new google.maps.LatLng(lat, lng),
              zoom:10,
              mapTypeId:google.maps.MapTypeId.ROADMAP
          };

          var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
          var marker=new google.maps.Marker({
              position: new google.maps.LatLng(lat, lng),
              map: peta,
              animation: google.maps.Animation.BOUNCE
            });
          }

          google.maps.event.addDomListener(window, 'load', initialize);

          var maps = () => {
            window.open(url, 'popupwindow', 'scrollbars=yes, width=740,height=540');
            return false
          }

          function HandlePopupResult(data) {
            $('[name="lat"]').val("" + data.lat);
            $('[name="lng"]').val("" + data.lng);
            // $('[name="address"]').val("" + data.address);
          }
          </script>

        <?php endif ?>

      </div>
    </form>
  </div>
</section>

<div class="modal fade" id="modal_form">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Foto Profile</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <form action="" method="post" id="form_img">
      <input type="hidden" name="user_id" value="<?= md5(@$user->user_id) ?>">
      <div class="modal-body">
        <img src="<?= site_url(IMAGE . @$user->profile_pic) ?>" class="img-fluid" alt="Photo">
      </div>
      <div class="modal-footer">
        <button type="button" onclick="delete_img()" class="btn btn-danger btn-sm">Hapus</button>
      </div>
    </form>
  </div>
  </div>
</div>

<script type="text/javascript"> 
var form  = "#form";
var btn   = "#btnsave";

$(document).ready(function() {
  form_multipart(form, btn);
});

function action_success(id) {
  if (id) {
    window.location.href = index + "users/edit/" + id;
  } else {
    window.location.href = index + "users";
  }
}

function delete_img()
{
  $.ajax({
      url : index + "users/delete_img",
      type: "POST",
      data: $('#form_img').serialize(),
      dataType: "JSON",
      success: function(data) {
      if(data.status) {
        $('#modal_form').modal('hide');
        flashdata(data.message);
        setTimeout(function() { 
           $("#back").click();
        }, 1800);
      }
    }
  });
}
</script>