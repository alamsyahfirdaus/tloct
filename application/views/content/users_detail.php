<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Detail <?= $title ?></h3>
          </div>
          <div class="card-body table-responsive">
            <table class="table" width="100%">
              <tbody>
                <tr>
                  <th class="text-left">No. Induk</th>
                  <td>:</td>
                  <td><?= @$user->no_induk ?></td>
                </tr>
                <tr>
                  <th class="text-left">Nama Lengkap</th>
                  <td>:</td>
                  <td><?= @$user->full_name ?></td>
                </tr>
                <tr>
                  <th class="text-left">Username</th>
                  <td>:</td>
                  <td><?= @$user->username ?></td>
                </tr>
                <tr>
                  <th class="text-left">No. Handphone</th>
                  <td>:</td>
                  <td><?= @$user->phone ?></td>
                </tr>
                <tr>
                  <th class="text-left">Tanggal Lahir</th>
                  <td>:</td>
                  <td><?= date('d F Y', strtotime(@$user->birth_day)) ?></td>
                </tr>
                <tr>
                  <th class="text-left">Program Studi</th>
                  <td>:</td>
                  <td><?= @$user->prodi_name ?></td>
                </tr>
                <tr>
                  <th>Foto Profile</th>
                  <td>:</td>
                  <td>
                      <img src="<?= base_url(IMAGE . $this->library->image(@$user->profile_pic)) ?>" class="profile-user-img img-thumbnail" alt="User profile picture">
                  </td>
                </tr>
              </tbody>
            </table>   
          </div>
        </div>
      </div>

      <?php if (@$user->user_type_id == 2): ?>

        <div class="col-md-6">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Lokasi Dosen</h3>
            </div>
            <div class="card-body">
              <div id="map" id="map" style="width: 100%; height: 325px;"></div>
            </div>
          </div>
          <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUPnLg3M1AcW-2aQxGqHaGR8qOFJGkS9Q&callback=initMap">
          </script>
          <script type="text/javascript">
              function initMap() {
                var latitude    = parseFloat("<?= @$latitude ?>");
                var longitude   = parseFloat("<?= @$longitude ?>");
                var coordinate  = {lat: latitude, lng: longitude};
                    var map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 17,
                      center: coordinate
                    });
                var marker = new google.maps.Marker({
                      position: coordinate,
                      map: map,
                      title: "<?= @$room_name ?>",
                });
              }
          </script>
        </div>

      <?php endif ?>

    </div>
  </div>
</section>