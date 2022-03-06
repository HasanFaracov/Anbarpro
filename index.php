<?php
session_start();
$con = mysqli_connect('localhost','username','password','database_name');
$tarix = date('Y-m-d H:i:s');

if(isset($_SESSION['email']) && isset($_SESSION['parol']))
{echo'<meta http-equiv="refresh" content="0; URL=orders.php">'; exit;}

?>
<title>Anbar</title>
<!-- Fav icon  start-->
<link rel="apple-touch-icon" sizes="57x57" href="anbarfavicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="anbarfavicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="anbarfavicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="anbarfavicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="anbarfavicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="anbarfavicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="anbarfavicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="anbarfavicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="anbarfavicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="anbarfavicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="anbarfavicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="anbarfavicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="anbarfavicon/favicon-16x16.png">
<link rel="manifest" href="anbarfavicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="anbarfavicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!-- Fav icon end -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Anbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <a class="nav-link" href="#">Haqqımızda</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="#">Əlaqə</a>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0" method="post">
            <input class="form-control mr-sm-2" type="text" name="email" placeholder="Email" required autocomplete="off"
                aria-label="Search">
            <input class="form-control mr-sm-2" type="password" name="parol" placeholder="Parol" required autocomplete="off"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" name="daxilol" type="submit">Daxil ol</button>
        </form>
    </div>
</nav>
<br><br>
<div class="container">
<div class="alert alert-warning" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
</svg> Anbar proqramından istifadə etmək üçün ya qeydiyyatdan keçin, ya da email və parolunuzu daxil edərək anbara giriş edin </div>






<?php

if(isset($_POST['daxilol']) && !empty($_POST['email']) && !empty($_POST['parol']))
{
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    $email = mysqli_real_escape_string($con,$email);

    $parol = trim($_POST['parol']);
    $parol = strip_tags($parol);
    $parol = htmlspecialchars($parol);
    $parol = mysqli_real_escape_string($con,$parol);
    $aparol= $parol;
    $parol = md5($parol);

    $yoxla = mysqli_query($con,"SELECT * FROM users WHERE email='".$email."' AND parol='".$parol."'");


    if(mysqli_num_rows($yoxla)>0)
    {
        
        $info = mysqli_fetch_array($yoxla);
        if ($info['blok']==0) {
            $_SESSION['user_id'] = $info['id'];
            $_SESSION['ad'] = $info['ad'];
            $_SESSION['soyad'] = $info['soyad'];
            $_SESSION['email'] = $info['email'];
            $_SESSION['tel'] = $info['tel'];
            $_SESSION['parol'] = $info['parol'];
            if ($email =="superadmin@gmail.com" && $aparol=="admin2002") {
                echo'<meta http-equiv="refresh" content="0; URL=superadmin.php">';
            }else{
                echo'<meta http-equiv="refresh" content="0; URL=orders.php">';
            }
        }else{
            echo'
            <div class="alert alert-warning" role="alert">Siz blok olunmusunuz.Xaiş olunur müdriyyətlə əlaqə saxlayasınız </div>';
        }
        
       
    }
}




$email_yoxla = mysqli_query($con,"SELECT email FROM users");
if(isset($_POST['qeydiyyat'])){
    $ad = trim($_POST['ad']);
    $ad = strip_tags($ad);
    $ad = htmlspecialchars($ad);
    $ad = mysqli_real_escape_string($con,$ad);

    $soyad = trim($_POST['soyad']);
    $soyad = strip_tags($soyad);
    $soyad = htmlspecialchars($soyad);
    $soyad = mysqli_real_escape_string($con,$soyad);

    $tel = trim($_POST['tel']);
    $tel = strip_tags($tel);
    $tel = htmlspecialchars($tel);
    $tel = mysqli_real_escape_string($con,$tel);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    $email = mysqli_real_escape_string($con,$email);

    $parol = trim($_POST['parol']);
    $parol = strip_tags($parol);
    $parol = htmlspecialchars($parol);
    $parol = mysqli_real_escape_string($con,$parol);
    $tparol = trim($_POST['tparol']);
    $tparol = strip_tags($tparol);
    $tparol = htmlspecialchars($tparol);
    $tparol = mysqli_real_escape_string($con,$tparol);

    if($_SESSION['token']==$_POST['token']){
    if (!empty($ad) && !empty($soyad) && !empty($tel) && !empty($email) && !empty($parol) && !empty($tparol)) {



        if ($parol == $tparol) {
            $icaze = true;
            $i = 0;
            while($email_info = mysqli_fetch_array($email_yoxla)){
                $i++;  
                if ($email_info['email']==$email) {
                  $icaze= false;
                  echo '<div class="alert alert-warning" role="alert">Bu mail ilə qeydiyyat mümkün olmadı.</div>';
                }                
            }
            if ($icaze) {
                $parol = md5($parol);
                $qeydiyyat = mysqli_query($con,"INSERT INTO users(ad,soyad,tel,email,parol,tarix)
            VALUES('".$ad."','".$soyad."','".$tel."','".$email."','".$parol."','".$tarix."')"); 
            if ($qeydiyyat = true) {
                echo'<div class="alert alert-success" role="alert">Qeydiyyat uğurla başa çatdı</div>';
            }else{
                echo'<div class="alert alert-danger" role="alert">Qeydiyyata alınmadı</div>';
            }
            }
            

        }else{
            echo '<div class="alert alert-warning" role="alert">Xaiş olunur eyni parolu daxil edəsiniz</div>';
        }
      
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
    }
}

    
}
$_SESSION['token'] = md5(rand());
?>
<div class="alert alert-dark" role="alert">
    <form action="" method="post">
    Adınız:<br>
    <input type="text" name="ad" class="form-control"></br>
    Soyadınız:<br>
    <input type="text" name="soyad" class="form-control"></br>
    Telefon:<br>
    <input type="text" name="tel" class="form-control"></br>
    Email:<br>
    <input type="email" name="email" class="form-control"></br>
    Parol:<br>
    <input type="password" name="parol" class="form-control"></br>
    Təkrar Parol:<br>
    <input type="password" name="tparol" class="form-control"></br>
    <input type="hidden" name="token" value="<?=$_SESSION['token'] ?>">
    <button type="submit" class="btn btn-success" name="qeydiyyat"> Qeydiyyatdan Keçin</button>
    </form>
</div>
</div>