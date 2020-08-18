<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a type="button" onclick="home()" class="nav-link <?php if ($this->uri->segment(1) == 'home') echo 'active' ?>">
        <i class="nav-icon fas fa-home"></i>
        <p>Halaman Utama</p>
      </a>
    </li>
    <li class="nav-item has-treeview <?php if ($this->uri->segment(1) == 'users') echo 'menu-open' ?>">
      <a type="button" class="nav-link <?php if ($this->uri->segment(1) == 'users') echo 'active' ?>">
        <i class="nav-icon fas fa-table"></i>
        <p>
          Master
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a type="button" onclick="users()" class="nav-link <?php if (@$title == 'Pengguna') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Semua Pengguna</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="administration()" class="nav-link <?php if (@$title == 'Administrator') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Administrator</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="teacher()" class="nav-link <?php if (@$title == 'Dosen') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Dosen</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="student()" class="nav-link <?php if (@$title == 'Mahasiswa') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Mahasiswa</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item has-treeview <?php if ($this->uri->segment(1) == 'setting') echo 'menu-open' ?>">
      <a type="button" class="nav-link <?php if ($this->uri->segment(1) == 'setting') echo 'active' ?>">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Pengaturan<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a type="button" onclick="faculty()" class="nav-link <?php if ($this->uri->segment(2) == 'faculty') echo 'active' ?>"><i class="far fa-circle nav-icon"></i>
            <p>Fakultas</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="prodi()" class="nav-link <?php if ($this->uri->segment(2) == 'prodi') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Program Studi</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="building()" class="nav-link <?php if ($this->uri->segment(2) == 'building') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Gedung</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="room()" class="nav-link <?php if ($this->uri->segment(2) == 'room') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Ruangan</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="imageslider()" class="nav-link <?php if ($this->uri->segment(2) == 'imageslider') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Image Slider</p>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" onclick="other()" class="nav-link <?php if ($this->uri->segment(2) == 'other') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Lainnya</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a type="button" onclick="logout()" class="nav-link" >
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Keluar</p>
      </a>
    </li>
  </ul>
</nav>
<script src="<?= base_url(JS . 'sidebar.js') ?>"></script>