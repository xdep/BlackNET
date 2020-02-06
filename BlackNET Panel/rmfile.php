<?php
include_once 'session.php';
try {
	if ($_SESSION['csrf'] == $utils->sanitize($_GET['csrf'])) {
		@unlink(realpath("upload/" . trim($_GET['vicid']) . "/" . trim($_GET['fname'], "./")));
		$utils->redirect("viewuploads.php?vicid=" . $utils->sanitize($_GET['vicid']) . "&msg=yes");
	} else {
		$utils->redirect("viewuploads.php?vicid=" . $utils->sanitize($_GET['vicid']) . "&msg=csrf");
	}
} catch (Exception $e) {
}
