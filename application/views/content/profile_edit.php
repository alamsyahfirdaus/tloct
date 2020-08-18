<section class="content">
  <div class="container-fluid">
  	<div class="row">
  		<div class="col-md-6">
		  	<form action="<?= site_url('home/save_editprofile/' . md5(@$user['user_id'])) ?>" id="form" method="post" enctype="multipart/form-data">
	  	    <div class="card">
	  	    	<div class="card-header card-primary card-outline">
	  	    	  <h3 class="card-title">Edit Profile</h3>
	  	    	</div>
	  	      <div class="card-body">
	  	      	<div class="form-group">
		  	        <label for="no_induk">No. Induk</label>
		  	        <input type="number" min="0" name="no_induk" class="form-control" id="no_induk" placeholder="No. Induk" value="<?= (@$user['no_induk']) ? $user['no_induk'] : set_value('no_induk') ?>" autocomplete="off">
		            <small class="help-block text-danger"></small>
		  	      </div>
		  	      <div class="form-group">
	  		        <label for="full_name">Nama Lengkap</label>
	  		        <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Nama Lengkap" value="<?= (@$user['full_name']) ? $user['full_name'] : set_value('full_name') ?>">
	  	            <small class="help-block text-danger"></small>
	  		      </div>
	  		      <div class="form-group">
	  		        <label for="username">Username</label>
	  		        <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?= (@$user['username']) ? $user['username'] : set_value('username') ?>" autocomplete="off">
	  	            <small class="help-block text-danger"></small>
	  		      </div>
		  	      <div class="form-group">
		  	        <label for="phone">No. Handphone</label>
		  	        <input type="number" min="0" name="phone" class="form-control" id="phone" placeholder="No. Handphone" value="<?= (@$user['phone']) ? $user['phone'] : set_value('phone') ?>" autocomplete="off">
		            <small class="help-block text-danger"></small>
		  	      </div>
		  	      <div class="form-group">
		  	        <label for="birth_day">Tanggal Lahir</label>
		  	        <?php $date = date('m/d/Y', strtotime(@$user['birth_day'])); ?>
		  	        <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask name="birth_day" id="birth_day" value="<?php if(@$user['user_id']) echo $date ?>" placeholder="Tanggal Lahir">
		  	        <small class="help-block text-danger"></small>
		  	      </div>
		  	      <div class="form-group">
		  	        <label for="profile_pic">Foto Profile</label>
		  	        <div class="input-group">
		  	          <div class="custom-file">
		  	            <input type="file" class="custom-file-input" id="profile_pic" name="profile_pic">
		  	            <label class="custom-file-label" for="profile_pic"><?= (@$user['profile_pic']) ? $user['profile_pic'] : set_value('profile_pic')  ?></label>
		  	          </div>
		  	          <div class="input-group-append">
		  	          	<input type="hidden" name="user_id" value="<?= md5(@$user['user_id']) ?>">
		  	            <button type="button" <?= (@$user['profile_pic']) ? 'title="Hapus"' : "disabled"; ?> class="btn btn-default" onclick="delete_img();"><i class="fas fa-trash"></i></button>
		  	          </div>
		  	        </div>
		  	      </div>
	  	      </div>
		      <div class="card-footer">
		      	<div class="float-right">
	  	      	<button type="button" onclick="profile()" class="btn btn-secondary mr-2"><i class="fas"> Batal</i></button>
	  	      	<button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
		      	</div>
		      </div>
	  	    </div>
		  	</form>
  		</div>
  	</div>
  </div>
</section>

<script type="text/javascript">
var form = "#form";
var btn  = "#btnsave";
$(document).ready(function () {
	form_multipart(form, btn);
});

function action_success() {
  profile();
}

function delete_img() {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Akan menghapus Foto Profile",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'OK',
    cancelButtonText: 'Batal',
    reverseButtons: true,
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url : index + "users/delete_img",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
          success: function(response) {
            flashdata(response.message);
            setTimeout(function() { 
              profile();
            }, 1800);
          }
      });
    }
  })
}

</script>