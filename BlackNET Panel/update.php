<?php
include_once 'classes/Database.php';
include_once 'classes/Update.php';
include_once 'classes/Utils.php';

$utils = new Utils;

$current_version = "v3.0.0.1";

$update = new Update;

if (isset($_POST['start_update'])) {
  $sql = [
    $update->drop_column("settings", "c_password")
  ];

  foreach ($sql as $query) {
    $msg = $update->execute($query);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once 'components/meta.php'; ?>

  <title>BlackNET - Update Panel</title>

  <?php include_once 'components/css.php'; ?>
</head>

<body class="bg-dark">
  <div class="container pt-3">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Update System</div>
      <div class="card-body">
        <form method="POST">
          <?php if (isset($msg)) : ?>
            <?php if ($msg == true) : ?>
              <div class="alert alert-success"><span class="fas fa-check-circle"></span> Panel has been updated.</div>
            <?php else : ?>
              <div class="alert alert-danger"><span class="fas fa-times-circle"></span> Panel is up to date.</div>
            <?php endif; ?>
          <?php endif; ?>
          <div class="alert alert-primary text-center border-primary pb-0">
            <p class="lead h2">
              <b>this page is going to update BlackNET current settings</b>
              <p>Version: <?php echo $current_version; ?></p>
              <a href="https://github.com/BlackHacker511/BlackNET#whats-new" class="alert-link">Change Log</a>
            </p>
          </div>
          <button type="submit" name="start_update" class="btn btn-primary btn-block">Start Update</button>
        </form>
      </div>
    </div>
  </div>

  <?php include_once 'components/js.php'; ?>

</body>

</html>