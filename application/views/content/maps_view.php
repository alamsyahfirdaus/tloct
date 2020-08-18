<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title><?= TITLE ?></title>
    <?php 
    $this->load->view('section/css');
    $this->load->view('section/js');
    ?>
    <style>
    /*html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    }*/
    .controls {
    margin-top: 10px;
    border: 1px solid transparent;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    height: 32px;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    #pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 300px;
    }
    #pac-input:focus {
    border-color: #4d90fe;
    }
    /* .pac-container {
    font-family: Roboto;
    }*/
    #type-selector {
    color: #fff;
    background-color: #4d90fe;
    padding: 5px 11px 0px 11px;
    }
    #type-selector label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
    }
    #target {
    width: 345px;
    }
    
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARYys9g6MWSN2rZh4LhbgNlyh3633KmdI&libraries=places&callback=initAutocomplete"
    async defer></script>
    <script>
    var title = "<?= @$address ? 'Double Click' : 'Click' ?>";

    function initAutocomplete() {
    <?php
    if (@$lat&&@$lng)
    {
    ?>
    var myLatlng = new google.maps.LatLng(<?php print $lat?>,<?php print $lng?>);
    <?php
    }else
    {
    ?>
    var myLatlng = new google.maps.LatLng(-7.370333700000001, 108.2311839);
    <?php
    }
    ?>
    var map = new google.maps.Map(document.getElementById('map'), {
    center: myLatlng,
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var geocoder = new google.maps.Geocoder;
    var address = '';
    //default marker
    var def_marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    draggable:true,
    title: title
    });
    google.maps.event.addListener(def_marker, "click", function (event) {
    var latitude = event.latLng.lat();
    var longitude = event.latLng.lng();
    var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
    geocoder.geocode({'location': latlng}, (results, status)=>{
    if (status == 'OK') {
      address = results[0].formatted_address;
    }else{
      address = results[0].formatted_address;
    }
    })
    document.getElementById('lat').value=latitude;
    document.getElementById('lng').value=longitude;
    document.getElementById('address').value=address;
    }); //end addListener
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
    });
    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();
    if (places.length == 0) {
    return;
    }
    // Clear out the old markers.
    markers.forEach(function(marker) {
    marker.setMap(null);
    });
    markers = [];
    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
    var _marker = new google.maps.Marker({
    position: place.geometry.location,
    map: map,
    draggable: true,
    title: title
    });
    google.maps.event.addListener(_marker, "click", function (event) {
    var latitude = event.latLng.lat();
    var longitude = event.latLng.lng();
    var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
    geocoder.geocode({'location': latlng}, (results, status)=>{
    if (status == 'OK') {
      address = results[0].formatted_address;
    }else{
      address = results[0].formatted_address;
    }
    })
    document.getElementById('lat').value = latitude;
    document.getElementById('lng').value = longitude;
    document.getElementById('address').value = address;
    }); //end addListener
    markers.push(_marker);
    if (place.geometry.viewport) {
    // Only geocodes have viewport.
    bounds.union(place.geometry.viewport);
    } else {
    bounds.extend(place.geometry.location);
    }
    });
    map.fitBounds(bounds);
    });
    }
    </script>
    <script>
    function CloseMySelf()
    {
    try {
    var lat=document.getElementById('lat').value;
    var lng=document.getElementById('lng').value;
    var address=document.getElementById('address').value;
    window.opener.HandlePopupResult({
    lat: lat,
    lng: lng,
    address: address,
    });
    }
    catch (err) {}
    window.close();
    return false;
    }
    </script>
  </head>
  <body>
    <br>
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="form-group">
                    <input type="text" id="pac-input" class="controls" placeholder="Search">
                    <div id="map" style="height:450px;"></div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="lat" name="lat" value="<?= @$lat ?>" placeholder="Latitude" readonly="" disabled="">
                    </div>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="lng" name="lng" value="<?= @$lng ?>" placeholder="Longitude" readonly="" disabled="">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary btn-block float-right" onclick="return CloseMySelf()"><i class="fas">Select</i></button>
                    </div>
                </div>
                <?php if (@$address): ?>
                    <div class="form-group">
                        <textarea class="form-control" name="address" id="address" placeholder="Address" readonly=""><?= $address ?></textarea>
                    </div>
                <?php endif ?>
            </div>
        </div>
      </div>
    </section>
  </body>
</html>