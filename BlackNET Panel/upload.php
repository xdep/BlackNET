<?php
include_once 'classes/Utils.php';
include_once 'classes/blackupload/Upload.php';

$utils = new Utils;

$id = $utils->sanitize(base64_decode($_GET['id']));

$upload = new Upload($_FILES['file'], realpath("upload/" . $id));

$upload->enableProtection();

try {
  if (
    $upload->checkForbidden() &&
    $upload->checkExtension() &&
    $upload->checkMime()
  ) {
    $upload->upload();
  }
} catch (Throwable $th) {
}
