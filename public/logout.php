<?php
session_start();
session_unset();
session_destroy();

header("Location: ../views/view_login.php");
exit();