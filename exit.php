<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['ad']);
unset($_SESSION['soyad']);
unset($_SESSION['tel']);
unset($_SESSION['email']);
unset($_SESSION['parol']);

echo'<meta http-equiv="refresh" content="0; URL=index.php">';
?>