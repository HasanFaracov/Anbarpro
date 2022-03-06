<?php
//ADD BREND
if(isset($_POST['add_brend'])){
    $sec = mysqli_query($con,"SELECT * FROM brands");
    $say = mysqli_num_rows($sec);
    $ad_yoxla = mysqli_query($con,"SELECT ad FROM brands");
 
        $ad = trim($_POST['ad']);
        $ad = strip_tags($ad);
        $ad = htmlspecialchars($ad);
        $ad = mysqli_real_escape_string($con,$ad);

        include"upload.php";
        if ($ad<>""  && $upload){
            
                $icaze = true;
                $i = 0;
                while($info = mysqli_fetch_array($ad_yoxla)){
                    $i++;  
                    if ($info['ad']==$_POST['ad']) {
                    $icaze= false;
                    echo '<div class="alert alert-warning" role="alert">Bu brend artıq bazada mövcuddur.</div>';
                    }                
                }
                
                if ($icaze) {           
                    $daxilet = mysqli_query($con,"INSERT INTO brands(ad,foto,tarix,user_id)
                    VALUES('".$ad."','".$unvan."','".$tarix."','".$_SESSION['user_id']."')");        
                    if($daxilet==true){
                        echo'<div class="alert alert-success" role="alert">Brend bazaya əlavə edildi</div>';
                    }else{
                        echo'<div class="alert alert-danger" role="alert">Brendi bazaya əlavə etmək mümkün olmadı.</div>';
                    }
                }
        }else{
            echo '<div class="alert alert-warning" role="alert">Məlumatı tam doldurun</div>';
        } 
    }



    
//ADD CLIENT

if(isset($_POST['add_client'])){
    $sec = mysqli_query($con,"SELECT * FROM clients");
    $say = mysqli_num_rows($sec);
    $tel_yoxla = mysqli_query($con,"SELECT tel FROM clients"); 
    
    
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

    $shirket = trim($_POST['shirket']);
    $shirket = strip_tags($shirket);
    $shirket = htmlspecialchars($shirket);
    $shirket = mysqli_real_escape_string($con,$shirket);


    include"upload.php";
    if (!empty($ad) && $soyad<>"" && $tel<>"" && $email<>"" && $shirket<>"" && $upload){       
            $icaze = true;
            $i = 0;
            while($tel_info = mysqli_fetch_array($tel_yoxla)){
                $i++;  
                if ($tel_info['tel']==$tel) {
                  $icaze= false;
                  echo '<div class="alert alert-warning" role="alert">Bu Client artıq bazada mövcuddur.</div>';
                }                
            }
            
            if ($icaze) {           
                $daxilet = mysqli_query($con,"INSERT INTO clients(ad,soyad,tel,email,shirket,foto,tarix,user_id)
                VALUES('".$ad."','".$soyad."','".$tel."','".$email."','".$shirket."','".$unvan."','".$tarix."','".$_SESSION['user_id']."')");     
                if($daxilet==true){
                    echo'<div class="alert alert-success" role="alert">Client bazaya əlavə edildi</div>';
                }else{
                    echo'<div class="alert alert-danger" role="alert">Clienti bazaya əlavə etmək mümkün olmadı.</div>';
                }
            }
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatı tam doldurun</div>';
    } 
}
//ADD PRODUCT
    if(isset($_POST['add_product'])){  
        $sec = mysqli_query($con,"SELECT * FROM products");
        $say = mysqli_num_rows($sec);

        $ad = trim($_POST['ad']);
        $ad = strip_tags($ad);
        $ad = htmlspecialchars($ad);
        $ad = mysqli_real_escape_string($con,$ad);

        $alis = trim($_POST['alis']);
        $alis = strip_tags($alis);
        $alis = htmlspecialchars($alis);
        $alis = mysqli_real_escape_string($con,$alis);

        $satis = trim($_POST['satis']);
        $satis = strip_tags($satis);
        $satis = htmlspecialchars($satis);
        $satis = mysqli_real_escape_string($con,$satis);

        $miqdar = trim($_POST['miqdar']);
        $miqdar = strip_tags($miqdar);
        $miqdar = htmlspecialchars($miqdar);
        $miqdar = mysqli_real_escape_string($con,$miqdar);

        include"upload.php";
        if ( $ad<>"" && !empty($_POST['brand_id']) && $alis<>"" && $satis<>"" && $miqdar<>"" && $upload){                         
            $daxilet = mysqli_query($con,"INSERT INTO products(brand_id,ad,alis,satis,miqdar,foto,tarix,user_id)
            VALUES('".$_POST['brand_id']."','".$ad."','".$alis."','".$satis."','".floor($miqdar)."','".$unvan."','".$tarix."','".$_SESSION['user_id']."')");        
            if($daxilet==true){
                echo'<div class="alert alert-success" role="alert">Məhsul bazaya əlavə edildi</div>';
            }else{
                echo'<div class="alert alert-danger" role="alert">Məhsulu bazaya əlavə etmək mümkün olmadı.</div>';
            }
                
        }else{
            echo '<div class="alert alert-warning" role="alert">Məlumatı tam doldurun</div>';
        } 
    }







?>