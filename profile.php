<?php
include"header.php";
echo '<div class="container">';




$editi_sec = mysqli_query($con,"SELECT * FROM users WHERE id='".$_SESSION['user_id']."'");
$editi_info = mysqli_fetch_array($editi_sec);
$allow = true;
$edit = false;

if (isset($_POST['change_pass'])) {
    $allow =true;
    $parol = trim($_POST['parol']);
    $parol = strip_tags($parol);
    $parol = htmlspecialchars($parol);
    $parol = mysqli_real_escape_string($con,$parol);

    $tparol = trim($_POST['tparol']);
    $tparol = strip_tags($tparol);
    $tparol = htmlspecialchars($tparol);
    $tparol = mysqli_real_escape_string($con,$tparol);

    if (!empty($parol) && !empty($tparol)) {

        if ($parol == $tparol) {
        $parol = md5($parol);
                $changepass = mysqli_query($con,"UPDATE users SET 
                parol='".$parol."'
                WHERE id='".$_POST['id']."'"); 
            if ($changepass = true) {
                $_SESSION['parol'] = $parol;
                echo'<div class="alert alert-success" role="alert">Əməliyyat uğurla başa çatdı</div>';
            }else{
                echo'<div class="alert alert-danger" role="alert">Əməliyyat alınmadı</div>';
            }

        }else{
            $allow =false;
            $edit = true;
            echo '<div class="alert alert-warning" role="alert">Xaiş olunur eyni parolu daxil edəsiniz</div>';
        }    
    }else{
        $allow =false;
        $edit = true;
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
    }
}

if (isset($_POST['edit']) OR $edit) {
    $allow = false;
    
    ?>
<div class="alert alert-dark" role="alert">
    <form method="post" enctype="multipart/form-data">
        Ad:<br>
        <input type="text" name="ad" class="form-control" autocomplete="off" value="<?php echo $editi_info['ad']?>"><br>
        Soyad:<br>
        <input type="text" name="soyad" class="form-control" autocomplete="off"
            value="<?php echo $editi_info['soyad']?>"><br>
        Telefon nömrəsi:<br>
        <input type="text" name="tel" class="form-control" autocomplete="off"
            value="<?php echo $editi_info['tel']?>"><br>
        E-mail adresi:<br>
        <input type="email" name="email" class="form-control" autocomplete="off"
            value="<?php echo $editi_info['email']?>"><br>
        <input type="hidden" name="id" value="<?php echo $editi_info['id']?>">
        <button type="submit" class="btn btn-success" name="update">Yenilə</button>
        <button type="submit" class="btn btn-danger" name="cancel">Ləğv et</button><br><br>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#changepass"
            title="Müştəri əlavə et">Parolu dəyiş
        </button>

    </form>
</div>

<?php
}
if(isset($_POST['update'])){
    $allow =true;
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


    $user_yoxla = mysqli_query($con,"SELECT email FROM users WHERE email='".$email."' AND id!='".$_POST['id']."'");

    if ($ad<>"" && $soyad<>"" && $tel<>"" && $email<>""){
            
        if(mysqli_num_rows($user_yoxla)==0){         
                $yenile = mysqli_query($con,"UPDATE users SET 
                ad='".$ad."',
                soyad='".$soyad."',
                tel='".$tel."',
                email='".$email."'
                WHERE id='".$_POST['id']."'");
                if($yenile==true)
                {$_SESSION['ad'] = $ad;
                $_SESSION['soyad'] = $soyad;
                $_SESSION['email'] = $email;
                $_SESSION['tel'] = $tel;
                    
                    echo'<div class="alert alert-success" role="alert">Profiliniz uğurla yeniləndi</div>';}
                else
                {echo'<div class="alert alert-danger" role="alert">Profili yeniləmək mümkün olmadı</div>';}
            }
        else{
            echo'<div class="alert alert-danger" role="alert">Bu email artıq istifadə olunub </div>';
        }
        
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
    }  

    
}
if (isset($_POST['cancel'])) {
    $allow = true;
}




?>
</div>
<?php if($allow){  ?>
<div class="container mx-auto">
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row container d-flex justify-content-center">
                <div class="col-xl-6 col-md-12">
                    <div class="card user-card-full">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png"
                                            class="img-radius" alt="User-Profile-Image"> </div>
                                    <h6 class="f-w-600"><?php echo $_SESSION['ad'].' '.$_SESSION['soyad']; ?></h6>
                                    <p>Anbar sahibi</p>
                                    <form method="post">
                                        <button type="submit" class="btn btn-success btn-sm" name="edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Profil məlumatları</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Email</p>
                                            <h6 class="text-muted f-w-400"><?=$_SESSION['email']?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Telefon</p>
                                            <h6 class="text-muted f-w-400"><?=$_SESSION['tel']?></h6>
                                        </div>
                                    </div>
                                    <?php
                                $umumi_baza_b = mysqli_query($con,"SELECT brands.id FROM brands,users WHERE brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id']);
                                $umumi_baza_brend= mysqli_num_rows($umumi_baza_b);

                                $umumi_baza_c = mysqli_query($con,"SELECT clients.id FROM clients,users WHERE clients.user_id = users.id AND clients.user_id = ".$_SESSION['user_id']);
                                $umumi_baza_client_sayi= mysqli_num_rows($umumi_baza_c);

                                $umumi_baza_p =mysqli_query($con,"SELECT products.id FROM products, brands, users 
                                WHERE (products.brand_id=brands.id) AND (products.user_id = users.id) AND (products.user_id = ".$_SESSION['user_id'].")");
                                $umumi_baza_mehsul_sayi= mysqli_num_rows($umumi_baza_p);

                                $umumi_baza_s =mysqli_query($con,"SELECT orders.id FROM products, brands, clients, orders, users 
                                WHERE (orders.product_id=products.id) 
                                AND (orders.client_id=clients.id) AND (products.brand_id=brands.id)
                                AND (orders.user_id = users.id) AND (orders.user_id = ".$_SESSION['user_id'].")");
                                $umumi_baza_sifaris_sayi= mysqli_num_rows($umumi_baza_s);
                                ?>
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Anbarınız</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Brend sayı</p>
                                            <h6 class="text-muted f-w-400"><?=$umumi_baza_brend?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Müştəri sayı</p>
                                            <h6 class="text-muted f-w-400"><?=$umumi_baza_client_sayi?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Məhsul sayı</p>
                                            <h6 class="text-muted f-w-400"><?=$umumi_baza_mehsul_sayi?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Sifariş sayı</p>
                                            <h6 class="text-muted f-w-400"><?=$umumi_baza_sifaris_sayi?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }  ?>

<div class="modal fade" id="changepass" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Yeni parol təyini </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="" method="post">
                    Yeni parol:<br>
                    <input type="password" class="form-control" autocomplete="off" required name="parol"><br>
                    Yeni parol təkrarı:<br>
                    <input type="password" class="form-control" autocomplete="off" required name="tparol"><br>
                    <input type="hidden" name="id" value="<?php echo $editi_info['id']?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                <button type="submit" name="change_pass" class="btn btn-primary">Dəyiş</button>
            </div>
            </form>
        </div>
    </div>
</div>