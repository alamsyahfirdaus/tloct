<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= TITLE .' | '. $breadcrumb ?><?php if (@$title) echo ' - ' . $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  $this->load->view('section/css');
  $this->load->view('section/js');
  $user = $this->library->session();
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a type="button" class="nav-link" onclick="logout()"><i class="fas fa-sign-out-alt" title="Keluar"></i></a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="javascript:void(0)" onclick="home()" class="brand-link">
      <i class="fas fa-map ml-3 mr-2"></i>
      <span class="brand-text font-weight-bold text-white" style="font-family: sans-serif;"><?= TITLE ?></span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url(IMAGE . $this->library->image($user['profile_pic'])) ?>" class="img-circle elevation-1" alt="User Image">
        </div>
        <div class="info">
          <a type="button" onclick="profile()" class="d-block" title="Profile"><?= ucwords($user['full_name']) ?></a>
        </div>
      </div>
      <?php $this->load->view('section/sidebar');  ?>
    </div>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= @$title ? $title : $breadcrumb  ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <a href=""><?= @$breadcrumb ?></a>
                </li>
                <?php if (@$title): ?>
                  <li class="breadcrumb-item active"><?= $title ?></li>
                <?php endif ?>
                <?php if (@$subtitle): ?>
                  <li class="breadcrumb-item active"><?= $subtitle ?></li>
                <?php endif ?>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <?= $content ?>
  </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?= date('Y') ?><a  class="text-muted" href=""> <?= FOOTER ?></a>.</strong>
  </footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<?php $this->load->view('section/scripts'); ?>
</body>
</html>