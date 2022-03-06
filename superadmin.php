<?php 
session_start();
$con = mysqli_connect('localhost','username','password','database_name');
$tarix = date('Y-m-d H:i:s');

if(!isset($_SESSION['email']) or !isset($_SESSION['parol']))
{echo'<meta http-equiv="refresh" content="0; URL=index.php">'; exit;}

?>
<title>Admin</title>
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


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Anbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <a class="nav-link" href="superadmin.php">İstifadəçilər</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="superadmin.php">Səlahiyyətlər</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="brands.php">Brend</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="clients.php">Müştəri</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="xerc.php">Xərc</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="products.php">Məhsul</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="orders.php">Sifariş</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="credits.php">Kredit</a>
            </li>
            
            <li class="nav-item active">
                <button type="button" class="nav-link btn btn-success" data-toggle="modal" data-target="#exit" title="Çıxış">
                Çıxış
                </button>
            </li>

            <li class="nav-item active">
            <a class="nav-link" href="superadmin.php"> <b> <?php
                echo $_SESSION['ad'].' '.$_SESSION['soyad'];
                ?></b>
                </a> 
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post">
            <input class="form-control mr-sm-2" type="text" name="sorgu" placeholder="Axtar" autocomplete="off"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" name="axtar" type="submit">Axtar</button> &nbsp;
            <button class="btn btn-outline-success my-2 my-sm-0" name="all" type="submit">Hamısı</button>
        </form>
    </div>
</nav>
<div class="modal fade" id="exit"  data-backdrop="static" data-keyboard="false"  tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered"">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Təsdiq</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <b style="font-size:24px">Çıxış edilsin?</b>
            </div>
            <div class="modal-footer">
                <form action="exit.php">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Xeyr</button>
                <button type="submit" class="btn btn-primary">Bəli</button>
                </form>
            </div>
           
            </div>
        </div>
    </div>


<br><br><br>
<div class="container">
    <div class="alert alert-dark" role="alert">
        <h3 class="text-right">Admin</h3>
    </div>
        
    <?php
$sec = mysqli_query($con,"SELECT * FROM users");
$say = mysqli_num_rows($sec);


$add = true;


// Blok START
if (isset($_POST['blok'])) {      
            $user_blok = mysqli_query($con,"UPDATE users SET 
            blok='1'
            WHERE id='".$_POST['id']."'");
            if($user_blok ==true){
                echo '<div class="alert alert-success" role="alert">İstifadəçi uğurla blok edildi</div>';
            }
            else{
            echo '<div class="alert alert-danger" role="alert">İstifadəçini blok etmək mümkün olmadı</div> ';
            }
}
if (isset($_POST['legv'])) {
        $user_blok = mysqli_query($con,"UPDATE users SET 
        blok='0'
        WHERE id='".$_POST['id']."'");
        if($user_blok ==true){
            echo '<div class="alert alert-success" role="alert">Blok ləğv olundu</div>';
        }
        else{
            echo '<div class="alert alert-danger" role="alert">Bloku ləğv etmək mümkün olmadı</div> ';        
        }
}
if (isset($_POST['adminblok'])) {

    echo '<div class="alert alert-warning" role="alert">Admini blok etmek mümkün deyil</div>';

 }

// Blok END

if(isset($_POST['add'])){  
    $email_yoxla = mysqli_query($con,"SELECT email FROM users");

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
                $qeydiyyat = mysqli_query($con,"INSERT INTO users(ad,soyad,tel,email,parol,tarix)
            VALUES('".$ad."','".$soyad."','".$tel."','".$email."','".$parol."','".$tarix."')"); 
            if ($qeydiyyat = true) {
                echo'<div class="alert alert-success" role="alert">Qeydiyyat uğurla başa çatdı</div>';
            }else{
                echo'<div class="alert alert-danger" role="alert">Qeydiyyata alınmadı</div>';
            }
            }
        }else{
            echo '<div class="alert alert-warning" role="alert">Xaiş olunur parol ilə təkrar parolu eyni daxil edəsiniz</div>';
        }
      
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
    }

    
}
?>
<?php
 if(isset($_POST['delete'])){
    $user_sec = mysqli_query($con,"SELECT ad,soyad FROM users WHERE id='".$_POST['id']."'");
    $user_sil = mysqli_fetch_array($user_sec);
    $silinen_ad = $user_sil['ad'];
    $silinen_soyad = $user_sil['soyad'];
         
        echo'
        <div class="alert alert-dark" role="alert">
        Siz <b>"'.$silinen_soyad.' '.$silinen_ad.'"</b> adlı istifadəçini silməyə əminsiniz?<br><br>
        <form method="post">
        <button type="submit" class="btn btn-primary btn-sm" name="yes" >Bəli</button> / <button type="submit" class="btn btn-danger btn-sm"  name="no" ">Xeyr</button>
        <input type="hidden" name="silinen_id" value="'.$_POST['id'].'">
        </form>
        </div>
           
     ';
}
if (isset($_POST['yes'])) {
    $sil = mysqli_query($con,"DELETE FROM users WHERE id='".$_POST['silinen_id']."'");
    if($sil==true){
        echo'<div class="alert alert-success" role="alert">İstifadəçi uğurla silindi.</div>';
    }else{
        echo'<div class="alert alert-danger" role="alert">İstifadəçini silmek mümkün olmadı.</div>';
    }
}
if (isset($_POST['no'])) {
    $add= true;
    echo '<div class="alert alert-warning" role="alert">İstifadəçini silməyə imtina etdiniz</div> ';
}
if(isset($_POST['edit'])){
    $editi_sec = mysqli_query($con,"SELECT * FROM users WHERE id='".$_POST['id']."'");
    $editi_info = mysqli_fetch_array($editi_sec);
    ?>
    <div class="alert alert-dark" role="alert">
        <form method="post">
            İstifadəçinin adı:<br>
            <input type="text" name="ad" class="form-control" autocomplete="off"
                value="<?php echo $editi_info['ad']?>"><br>
            İstifadəçinin soyadı:<br>
            <input type="text" name="soyad" class="form-control" autocomplete="off"
                value="<?php echo $editi_info['soyad']?>"><br>
            Telefon nömrəsi:<br>
            <input type="text" name="tel" class="form-control" autocomplete="off"
                value="<?php echo $editi_info['tel']?>"><br>
            E-mail adresi:<br>
            <input type="email" name="email" class="form-control" autocomplete="off"
                value="<?php echo $editi_info['email']?>"><br>
            Parol:<br>
            <input type="text" name="parol" class="form-control" autocomplete="off"
                value="<?php echo $editi_info['parol']?>"><br>
            <input type="hidden" name="id" value="<?php echo $editi_info['id']?>">
            <button type="submit" class="btn btn-success" name="update">Yenilə</button>
        </form>
    </div>
    <?php
}
if(isset($_POST['update'])){
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

    

    $user_yoxla = mysqli_query($con,"SELECT email FROM users WHERE email='".$email."' AND id!='".$_POST['id']."'");

    
    if ($ad<>"" && $soyad<>"" && $tel<>"" && $email<>"" && $parol<>""){
            
        if(mysqli_num_rows($user_yoxla)==0){         
                $yenile = mysqli_query($con,"UPDATE users SET 
                ad='".$ad."',
                soyad='".$soyad."',
                tel='".$tel."',
                email='".$email."',
                parol='".$parol."'
                WHERE id='".$_POST['id']."'");
                if($yenile==true)
                {echo'<div class="alert alert-success" role="alert">İstifadəçi uğurla yeniləndi</div>';}
                else
                {echo'<div class="alert alert-danger" role="alert">İstifadəçini yeniləmək mümkün olmadı</div>';}
            }
        else{
            echo'<div class="alert alert-danger" role="alert">Bu mail qeydiyyatda var</div>';
        }
        
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
    }   
}

?>
    <?php
if($add){
    echo '
    <div class="alert alert-dark" role="alert">
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#useradd">
        İstifadəçi əlavə et
        </button>
    </div>

    <div class="modal fade" id="useradd"  data-backdrop="static" data-keyboard="false"  tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">İstifadəçi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="" method="post">
                    Ad:<br>
                    <input type="text" name="ad" class="form-control"></br>
                    Soyad:<br>
                    <input type="text" name="soyad" class="form-control"></br>
                    Telefon:<br>
                    <input type="text" name="tel" class="form-control"></br>
                    Email:<br>
                    <input type="email" name="email" required class="form-control"></br>
                    Parol:<br>
                    <input type="password" name="parol" required class="form-control"></br>
                    Təkrar Parol:<br>
                    <input type="password" name="tparol" required class="form-control"></br>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                <button type="submit" name="add" class="btn btn-primary">Əlavə et</button>
            </div>
            </form>
            </div>
        </div>
    </div>
';
}
?>
<?php
if(isset($_POST['axtar']) && !empty($_POST['sorgu']))
    {   $sorgu = trim($_POST['sorgu']);
        $sorgu = strip_tags($sorgu);
        $sorgu = htmlspecialchars($sorgu);
        $sorgu = mysqli_real_escape_string($con,$sorgu);
        $axtar = " WHERE (ad LIKE '%".$sorgu."%') OR (soyad LIKE '%".$sorgu."%') OR (tel LIKE '%".$sorgu."%') OR (email LIKE '%".$sorgu."%')";}



//SEHIFELEME START

$setir_sayi = 4;
$sehife_sec = mysqli_query($con,"SELECT * FROM users ");
$toplam_brend = mysqli_num_rows($sehife_sec);

$toplam_sehife = intval(($toplam_brend-1)/ $setir_sayi) + 1;
$page = intval($_GET['page']);

if(empty($page) or $page<0){$page = 1;}
if($page>$toplam_sehife){$page = $toplam_sehife;}
$start = $page * $setir_sayi - $setir_sayi;

//SEHIFELEME END

$sec = mysqli_query($con,"SELECT * FROM users ".$axtar." ORDER BY id DESC LIMIT ".$start.",".$setir_sayi );
$user_sayi= mysqli_num_rows($sec);
//++++++ UMUMI BREND SAYI
$umumi_baza = mysqli_query($con,"SELECT * FROM users ");
$umumi_baza_user_sayi= mysqli_num_rows($umumi_baza);
//------- UMUMI BREND SAYI
    if ($user_sayi>0) { 
?>
    <div class="alert alert-info" role="alert">Bazada <b><?=$umumi_baza_user_sayi?></b> i̇stifadəçi var</div>
    <table class="table table-striped table-dark">
        <thead>
            <th>#</th>
            <th>Ad</th>
            <th>Soyad </th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Parol</th>
            <th>Tarix</th>
            <th>BLOK</th>
            <th></th>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while($info = mysqli_fetch_array($sec))
            {
                $i++;
                echo'<tr>';
                echo'<td>'.$i.'</td>';
                echo'<td>'.$info['ad'].'</td>';
                echo'<td>'.$info['soyad'].'</td>';
                echo'<td>'.$info['tel'].'</td>';
                echo'<td>'.$info['email'].'</td>';
                echo'<td>'.$info['parol'].'</td>';
                echo'<td>'.$info['tarix'].'</td>';
                echo'<td><form method="post">';
                if ($info['id']!=1) {
                if ($info['blok']=='0') {
                    echo '
                    
                    <button type="submit" class="btn btn-primary btn-sm " name="blok" title="Blok et">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock" viewBox="0 0 16 16">
                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"/>
                    </svg>
                    </button>
                    ';
                    }
                    if ($info['blok']=='1') {
                    echo'
                    <button type="submit" class="btn btn-danger btn-sm" name="legv" title="Ləğv et">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                    </svg>
                    </button>
                    ';                   
                    }
                }else{
                    echo'
                    <button type="submit" class="btn btn-info btn-sm " name="adminblok" title="Mümkün deyil" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                    </svg>
                    </button>';
                }
                echo '
                </td>';
                echo'<td>
                
                <input type="hidden" name="id" value="'.$info['id'].'">';
                if ($info['id']!=1) {
                    echo '
                <button type="submit" class="btn btn-danger btn-sm" name="delete" title="Sil">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
                </button>
                ';
                }
                echo'
                <button type="submit" class="btn btn-primary btn-sm" name="edit" title="Redakte et">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                </svg>
                </button>
                </form>
                
                </td>';
            }           
            ?>
        </tbody>
    </table>
    <?php
    
    if ($page != 1) {$pervpage = '<li class="page-item"><a  class="page-link"  href="?page=1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="19" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
      </svg></a></li>
      <li class="page-item"><a  class="page-link"  href="?page='. ($page - 1) .'"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="19" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  </svg></a> </li>';}
    if ($page != $toplam_sehife) {$nextpage = '<li class="page-item"> <a  class="page-link"  href="?page='. ($page + 1) .'"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="19" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
      </svg></a></li>
      <li class="page-item"> <a  class="page-link"  href="?page=' .$toplam_sehife. '"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="19" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg></a></li>';}

    if($page - 2 > 0) {$page2left = ' <a  class="page-link"  href="?page='. ($page - 2) .'">'. ($page - 2) .'</a>  ';}
    if($page - 1 > 0) {$page1left = '<a  class="page-link"  href="?page='. ($page - 1) .'">'. ($page - 1) .'</a>  ';}
    if($page + 2 <= $toplam_sehife) {$page2right = '  <a  class="page-link"  href="?page='. ($page + 2) .'">'. ($page + 2) .'</a>';}
    if($page + 1 <= $toplam_sehife) {$page1right = '  <a   class="page-link" href="?page='. ($page + 1) .'">'. ($page + 1) .'</a>';}

    
        echo '
    <nav aria-label="Page navigation example">
    <ul class="pagination">
       '.$pervpage.'
      <li class="page-item">
      '.$page2left.'
      </li>
      <li class="page-item">'.$page1left.'</li>
      <li class="page-item"> <a  class="page-link" >'.$page.'</a></li>
      <li class="page-item">'.$page1right.'</li>
      <li class="page-item">
      '.$page2right.'
      </li>
      '.$nextpage.'
    
    </ul>
  </nav>
';







}else{
         echo '
         <div class="alert alert-warning" role="alert">Məlumat tapılmadı.</div>';
    }
    ?>
</div>

