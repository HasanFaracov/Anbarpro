<?php
session_start();
$con = mysqli_connect('localhost','username','password','database_name');
mysqli_set_charset($con, "utf8mb4");
$tarix = date('Y-m-d H:i:s');

if(!isset($_SESSION['email']) or !isset($_SESSION['parol']))
{echo'<meta http-equiv="refresh" content="0; URL=index.php">'; exit;}

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
<link rel="stylesheet" href="profile.css" >
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
            <?php
            if($_SESSION['user_id']==1){
                echo '
                <li class="nav-item active">
                <a class="nav-link" href="superadmin.php">İstifadəçilər</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="superadmin.php">Səlahiyyətlər</a>
            </li>
                ';
            }
            ?>

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

            <?php
            if($_SESSION['user_id']==1){
                echo '<li class="nav-item active">
                <a class="nav-link" href="superadmin.php"> <b>'.$_SESSION['ad'].' '.$_SESSION['soyad'].'</b></a> 
                </li> ';
            }else{
            ?>
            <li class="nav-item active">
            <a class="nav-link" href="profile.php"> <b> <?php
                echo
                $_SESSION['ad'].' '.$_SESSION['soyad'];
                ?></b>
                </a> 
            </li>
            <?php }?>
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


<br><br><br><br>