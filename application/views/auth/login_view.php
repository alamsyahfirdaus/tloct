<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?= TITLE ?> | Login</title>
  <?php $this->load->view('section/css'); ?>
  <?php $this->load->view('section/js'); ?>
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-8 mt-5">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4 text-primary" style="font-weight: bold; font-family: serif; font-size: 32px;"><?= TITLE ?></h1>
                  </div>
                  <form class="user" action="" method="post" id="form">
                    <div class="input-group mb-4">
                      <input type="username" class="form-control" placeholder="Username" name="username" value="<?= set_value('username') ?>">
                    </div>
                    <div class="input-group mb-4">
                      <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block"><i class="fas"> Login</i></button>
                  </form>
                  <br><hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="<?= base_url(JS . 'auth_script.js') ?>"></script>
<?php $this->load->view('section/scripts'); ?>
</body>
</html>