<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Edit Pengaturan</h3>
            <div class="card-tools">
              <button type="button" onclick="maps()" class="btn btn-tool" title="Map"><i class="fas fa-map-marker-alt"></i></button>
            </div>
          </div>
          <form action="<?= site_url('setting/other/save_latlng') ?>" method="post" id="form">
            <div class="card-body">
              <div class="form-group">
                <label for="setting_name">Nama Pengaturan</label>
                <input type="text" name="setting_name" class="form-control" id="setting_name" readonly="" disabled="" value=" <?= $setting_name ?>">
                  <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="lat">Latitude</label>
                <input type="text" name="lat" class="form-control" id="lat" value="<?= $latitude ?>" readonly="">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="lng">Longitude</label>
                <input type="text" name="lng" class="form-control" id="lng" value="<?= $longitude ?>" readonly="">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="description">Keterangan</label>
                <textarea name="description" id="description" class="form-control" placeholder="Keterangan Latitude & Longitude"><?= $description ?></textarea>
                  <small class="help-block text-danger"></small>
              </div>
            </div>
            <div class="card-footer">
              <input type="hidden" name="address" value="<?= $address ?>">
              <button type="submit" id="btnsave" style="display: none;"></button>
              <div class="float-right">
                <button type="button" id="back" onclick="other()" class="btn btn-secondary mr-2"><i class="fas"> Batal</i></button>
                <button type="button" onclick="check_des()" class="btn btn-primary float-right"><i class="fas"> Simpan</i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">

function check_des() {
  var description  = $('[name=description]').val();
  if (description) {
    $( "#btnsave" ).click();
  } else {
    var message = 'Keterangan harus diisi';
    $('[name="description"]').addClass('is-invalid');
    $('[name="description"]').next('.help-block').text(message);
  }
}
</script>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBYY-wMcvr6cGuSynbDsfyABKsGzOlz9X0&callback=initMap"></script>

<script type="text/javascript">
var lat  = $('[name=lat]').val();
var lng  = $('[name=lng]').val();
var url  = index + 'setting/other/map';

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
  $('[name="address"]').val("" + data.address);
}
</script>