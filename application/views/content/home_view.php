<section class="content">
	<div class="container-fluid">
		<div class="row">
		  <div class="col-lg-3 col-6">
		    <div class="small-box bg-success">
		      <div class="inner">
		        <h3><?= $users ?></h3>
		        <p>Semua Pengguna</p>
		      </div>
		      <div class="icon">
		        <i class="fas fa-users"></i>
		      </div>
		      <a type="button" onclick="users()" class="small-box-footer" title="Lihat Detail"><i class="fas fa-eye"></i></a>
		    </div>
		  </div>
		  <div class="col-lg-3 col-6">
		    <div class="small-box bg-info">
		      <div class="inner">
		        <h3><?= $administration ?></h3>
		        <p>Administrator</p>
		      </div>
		      <div class="icon">
		        <i class="fas fa-user-cog"></i>
		      </div>
		      <a type="button" onclick="administration()" class="small-box-footer" title="Lihat Detail"><i class="fas fa-eye"></i></a>
		    </div>
		  </div>
		  <div class="col-lg-3 col-6">
		    <div class="small-box bg-secondary">
		      <div class="inner">
		        <h3><?= $teacher ?></h3>
		        <p>Dosen</p>
		      </div>
		      <div class="icon">
		        <i class="fas fa-chalkboard-teacher"></i>
		      </div>
		      <a type="button" onclick="teacher()" class="small-box-footer" title="Lihat Detail"><i class="fas fa-eye"></i></a>
		    </div>
		  </div>
		  <div class="col-lg-3 col-6">
		    <div class="small-box bg-danger">
		      <div class="inner">
		        <h3><?= $student ?></h3>
		        <p>Mahasiswa</p>
		      </div>
		      <div class="icon">
		        <i class="fas fa-user-graduate"></i>
		      </div>
		      <a type="button" onclick="student()" class="small-box-footer" title="Lihat Detail"><i class="fas fa-eye"></i></a>
		    </div>
		  </div>
		</div>
	</div>
</section>