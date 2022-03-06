<?php  
include"header.php";
?>
<div class="container">
    <div class="alert alert-dark" role="alert">
        <h3 class="text-right">Kredit</h3>
    </div>



    <?php
$sec = mysqli_query($con,"SELECT * FROM orders");
$say = mysqli_num_rows($sec);

$add = true;

// Tesdiq START
if (isset($_POST['tesdiq'])) {

    if($_POST['credit_miqdar']<=$_POST['mehsul_miqdar']){
        $edit_miqdar = mysqli_query($con,"UPDATE products SET 
        miqdar=miqdar-".$_POST['credit_miqdar']."
        WHERE id='".$_POST['product_id']."'");
         
        if($edit_miqdar == true){
            $edit_tesdiq = mysqli_query($con,"UPDATE credits SET 
            tesdiq='1'
            WHERE id='".$_POST['id']."'");
            if($edit_tesdiq ==true){
                echo '<div class="alert alert-success" role="alert">Kredit uğurla təsdiq olundu</div>';
            }
        }else{
            echo '<div class="alert alert-danger" role="alert">Krediti təsdiq etmək mümkün olmadı</div> ';

            $edit_miqdar = mysqli_query($con,"UPDATE products SET 
            miqdar=miqdar+".$_POST['credit_miqdar']."
            WHERE id='".$_POST['product_id']."'");
        }
    }else{
        echo '<div class="alert alert-warning" role="alert"> Krediti təsdiq etmək üçün anbarda kifayət qədər məhsul yoxdur</div>';

    }
}


if (isset($_POST['legv'])) {

    $edit_miqdar = mysqli_query($con,"UPDATE products SET 
    miqdar=miqdar+".$_POST['credit_miqdar']."
    WHERE id='".$_POST['product_id']."'");


     
    if($edit_miqdar == true){
        $edit_tesdiq = mysqli_query($con,"UPDATE credits SET 
        tesdiq='0'
        WHERE id='".$_POST['id']."'");
        if($edit_tesdiq ==true){
            echo '<div class="alert alert-success" role="alert">Kredit uğurla ləğv olundu</div>';
        }
    }else{
        echo '<div class="alert alert-danger" role="alert">Krediti ləğv etmək mümkün olmadı</div> ';

        $edit_miqdar = mysqli_query($con,"UPDATE products SET 
        miqdar=miqdar-".$_POST['credit_miqdar']."
        WHERE id='".$_POST['product_id']."'");
    }
}
// Tesdiq END


// ODEMEK START
if ($_POST['tesdiq_status']=='1') {
    
    if (isset($_POST['ode'])) {
        if ($_POST['odenilib']<$_POST['muddet']) {
        $add = false;
        echo '<div class="alert alert-dark" role="alert">
        <form method="post">
        Məbləğ:<br>
        <input type="text" class="form-control" name="mebleg" autocomplete="off">
        (Depozit mümkündür)<br><br>
        <input type="hidden" name="id" value="'.$_POST['id'].'">
        <input type="hidden" name="ayliq_odenis" value="'.$_POST['ayliq_odenis'].'">
        <input type="hidden" name="qaliq_borc" value="'.$_POST['qaliq_borc'].'">
        <button type="submit" name="odemek" class="btn btn-success">Əlavə et</button>
        </form>
        </div>';                 
        }else{
           echo ' <div class="alert alert-warning" role="alert">Artıq borcunuz qalmayıb</div>';
        }
    } 
    
    
    
}
if (isset($_POST['odemek'])) {
    $mebleg = trim($_POST['mebleg']);
    $mebleg = strip_tags($mebleg);
    $mebleg = htmlspecialchars($mebleg);
    $mebleg = mysqli_real_escape_string($con,$mebleg);
   $mebleg = round ($mebleg, 3);
    $add = true;
    if ($mebleg<>"") {
        if ($mebleg>=1) {
            if ($mebleg<=$_POST['qaliq_borc']) {
                if ($mebleg >= $_POST['ayliq_odenis']) {
                $depozit = $mebleg - $_POST['ayliq_odenis'];
                $ode = mysqli_query($con,"UPDATE credits SET odenilib = (odenilib+1),depozit = ".$depozit." WHERE id = '".$_POST['id']."'");
                    if ($ode) {
                        echo' <div class="alert alert-success" role="alert">Borc ödənildi</div> ';
                    }else{
                        echo' <div class="alert alert-danger" role="alert">Borcu ödəmək mümkün olmadı</div> ';
                    }
                }else{
                    $depozit = $mebleg;
                    $ode = mysqli_query($con,"UPDATE credits SET depozit = ".$depozit." WHERE id = '".$_POST['id']."'");
                    if ($ode) {
                        echo' <div class="alert alert-success" role="alert">Məbləğ aylıq ödənişdən az olduğu üçün depozitə əlavə olundu</div> ';
                    }else{
                        echo' <div class="alert alert-danger" role="alert">Əməliyyat uğursuz oldu</div> ';
                    }
                }
            }else{
            echo' <div class="alert alert-warning" role="alert">Borc miqdarını keçdiniz</div> ';
            }
    }else{
        echo' <div class="alert alert-warning" role="alert">Məbləğ ən azı 1 olmalıdır</div> ';
    }
    }else{
        echo' <div class="alert alert-warning" role="alert">Boş məlumat daxil olunmur</div> ';
    }

}


//ODEMEK END


//ADD CREDIT
if(isset($_POST['add'])){  
    $miqdar = trim($_POST['miqdar']);
    $miqdar = strip_tags($miqdar);
    $miqdar = htmlspecialchars($miqdar);
    $miqdar = mysqli_real_escape_string($con,$miqdar);
    $miqdar = floor($miqdar);

    $muddet = trim($_POST['muddet']);
    $muddet = strip_tags($muddet);
    $muddet = htmlspecialchars($muddet);
    $muddet = mysqli_real_escape_string($con,$muddet);
    $muddet = floor($muddet);

    $faiz = trim($_POST['faiz']);
    $faiz = strip_tags($faiz);
    $faiz = htmlspecialchars($faiz);
    $faiz = mysqli_real_escape_string($con,$faiz);
    $faiz = floor($faiz);

    $ilk = trim($_POST['ilk']);
    $ilk = strip_tags($ilk);
    $ilk = htmlspecialchars($ilk);
    $ilk = mysqli_real_escape_string($con,$ilk);
    $ilk = floor($ilk);
    if($_SESSION['token']==$_POST['token']){
    if ( $miqdar<>"" && $muddet<>""  &&$faiz<>"" && $ilk<>"" && !empty($_POST['client_id']) && !empty($_POST['product_id'])){
        if ($miqdar>=1) {                            
        $daxilet = mysqli_query($con,"INSERT INTO credits(product_id,client_id,miqdar,muddet,faiz,ilk,tarix,user_id)
        VALUES('".$_POST['product_id']."','".$_POST['client_id']."','".$miqdar."','".$muddet."','".$faiz."','".$ilk."','".$tarix."','".$_SESSION['user_id']."')");        
        if($daxilet==true){
            echo'<div class="alert alert-success" role="alert">Kredit bazaya əlavə edildi</div>';
        }else{
            echo'<div class="alert alert-danger" role="alert">Krediti bazaya əlavə etmək mümkün olmadı.</div>';
        }
        }else{
        echo '<div class="alert alert-warning" role="alert">Xaiş olunur yüksək miqdar daxil edəsiniz.</div>';
        }  
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun.</div>'; 
    }
}
}


if(isset($_POST['delete'])){
    $add = false;  
    $sec = mysqli_query($con,"SELECT ad,soyad FROM clients WHERE  id='".$_POST['client_id']."'");
    $i = 0;
    while($kredit_sil = mysqli_fetch_array($sec)){
        $i++;  
        $silinen_ad = $kredit_sil['ad'];
        $silinen_soyad = $kredit_sil['soyad'];
    }
    echo '
    <div class="alert alert-dark" role="alert">
    Siz <b>"'.$silinen_ad.' '.$silinen_soyad.'"</b> adlı krediti silməyə əminsiniz?<br><br>
    <form method="post">
    <button type="submit" class="btn btn-primary btn-sm" name="yes" >Bəli</button> / <button type="submit" class="btn btn-danger btn-sm"  name="no" ">Xeyr</button>
    <input type="hidden" name="silinen_id" value="'.$_POST['id'].'">
    </form>
    </div>
    ';   
}
if (isset($_POST['yes'])) {
    $add= true;
    $sil = mysqli_query($con,"DELETE FROM credits WHERE id='".$_POST['silinen_id']."'");
    if($sil==true){
        echo'<div class="alert alert-success" role="alert">Kredit uğurla silindi.</div>';
    }else{
        echo'<div class="alert alert-danger" role="alert">Krediti silmek mümkün olmadı.</div>';
    }
}
if (isset($_POST['no'])) {
    $add= true;
    echo '<div class="alert alert-warning" role="alert">Krediti silməyə imtina etdiniz.</div> ';
}




if(isset($_POST['edit'])){
    $add= false;
    $edit_mehsul_sec = mysqli_query($con,"SELECT * FROM credits WHERE id='".$_POST['id']."'");        
    $edit_info = mysqli_fetch_array($edit_mehsul_sec);
    $edit_client_sec = mysqli_query($con,"SELECT * FROM clients WHERE id='".$edit_info['client_id']."'");
    $edit_client_info = mysqli_fetch_array($edit_client_sec);

    $edit_product_sec = mysqli_query($con,"SELECT products.id,
                products.ad AS mehsul,
                products.miqdar,
                brands.ad AS brend FROM products,brands WHERE (products.brand_id=brands.id) AND (products.id=".$edit_info['product_id'].") ORDER BY brands.ad ASC");
    $edit_product_info = mysqli_fetch_array($edit_product_sec);

    ?>
    <div class="alert alert-dark" role="alert">
        <form method="post">
            <?php
        echo '           
        Müştəri:<br>
        <select name="client_id" class="form-control">

            <option value="'.$edit_client_info['id'].'" selected="selected">'.$edit_client_info['ad'].' '.$edit_client_info['soyad'].'</option>';
            $sec = mysqli_query($con,"SELECT clients.id, clients.ad, clients.soyad FROM clients,users WHERE (clients.id!=".$edit_info['client_id'].") AND (clients.user_id = users.id) AND (clients.user_id = ".$_SESSION['user_id'].") ORDER BY clients.ad ASC");
            while($info=mysqli_fetch_array($sec))
            {echo'<option value="'.$info['id'].'">'.$info['ad'].' '.$info['soyad'].' </option>';}


        echo'
            </select><br>
            Məhsul:<br>
            <select name="product_id" class="form-control">
                
                <option value="'.$edit_product_info['id'].'">'.$edit_product_info['brend'].' - '.$edit_product_info['mehsul'].' ('.$edit_product_info['miqdar'].') </option>';
                

                $sec = mysqli_query($con,"SELECT products.id,
                products.ad AS mehsul,
                products.miqdar,
                brands.ad AS brend FROM products,brands,users WHERE (products.brand_id=brands.id) AND (products.user_id = users.id) AND (products.user_id = ".$_SESSION['user_id'].") AND products.id!=".$edit_info['product_id']." ORDER BY brands.ad ASC");
                while($info=mysqli_fetch_array($sec) )
                {echo'<option value="'.$info['id'].'">'.$info['brend'].' - '.$info['mehsul'].' ('.$info['miqdar'].') </option>';}


        echo'
            </select><br>';    
        ?>
            Miqdar:<br>
            <input type="text" class="form-control" name="miqdar" autocomplete="off"
                value="<?php echo $edit_info['miqdar']?>"><br>
            Kredit ayı:<br>
            <input type="text" class="form-control" name="muddet" autocomplete="off"
                value="<?php echo $edit_info['muddet']?>"><br>
            Faiz:<br>
            <input type="text" class="form-control" name="faiz" autocomplete="off"
                value="<?php echo $edit_info['faiz']?>"><br>
            İlkin ödəniş:<br>
            <input type="text" class="form-control" name="ilk" autocomplete="off"
                value="<?php echo $edit_info['ilk']?>"><br>
            <input type="hidden" name="id" value="<?php echo $edit_info['id']?>">
            <button type="submit" class="btn btn-success" name="update">Yenilə</button>
            <button type="submit" class="btn btn-danger" name="cancel">Ləğv et</button>
        </form>
    </div>
    <?php
}
if (isset($_POST['cancel'])) {
    $add = true;
}
if(isset($_POST['update'])){
    $add = true;

    $miqdar = trim($_POST['miqdar']);
    $miqdar = strip_tags($miqdar);
    $miqdar = htmlspecialchars($miqdar);
    $miqdar = mysqli_real_escape_string($con,$miqdar);

    $muddet = trim($_POST['muddet']);
    $muddet = strip_tags($muddet);
    $muddet = htmlspecialchars($muddet);
    $muddet = mysqli_real_escape_string($con,$muddet);

    $faiz = trim($_POST['faiz']);
    $faiz = strip_tags($faiz);
    $faiz = htmlspecialchars($faiz);
    $faiz = mysqli_real_escape_string($con,$faiz);

    $ilk = trim($_POST['ilk']);
    $ilk = strip_tags($ilk);
    $ilk = htmlspecialchars($ilk);
    $ilk = mysqli_real_escape_string($con,$ilk);

    
    if ($miqdar<>""  && $muddet<>"" && $faiz<>"" && $ilk<>"" && $miqdar>=1 && !empty($_POST['client_id']) && !empty($_POST['product_id'])){                             
        $yenile = mysqli_query($con,"UPDATE credits SET 
        miqdar='".$miqdar."',
        muddet='".$muddet."',
        faiz='".$faiz."',
        ilk='".$ilk."',
        product_id='".$_POST['product_id']."',
        client_id='".$_POST['client_id']."'
        WHERE id='".$_POST['id']."'");
        if($yenile==true){
            echo'<div class="alert alert-success" role="alert">Kredit uğurla yeniləndi.</div>';
        }else{
            echo'<div class="alert alert-danger" role="alert">Krediti yeniləmək mümkün olmadı.</div>';
        }
        
    }else{
        echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
    }   
}

$_SESSION['token'] = md5(rand());
    if($add){
        echo '
        <div class="alert alert-dark" role="alert">
        <form method="post">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#creditadd" title="Kredit əlavə et">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
        </svg>
        </button>


        
        <a class="btn btn-dark ml-3" title="Excel" href="excel/Examples/anbar_credits.php">Excel faylını yüklə</a>
        
        <button type="submit" class="btn btn-success float-right mx-2" name="taxtar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
        </button>
        <input type="date" class="float-right" name="t1" value="'.$_POST['t1'].'">
        <input type="date" class="float-right" name="t2" value="'.$_POST['t2'].'">
        </form>
        </div>
        <div class="modal fade" id="creditadd"  data-backdrop="static" data-keyboard="false"  tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Yeni Kredit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post">            
            Müştəri:<br>
                <select name="client_id" class="form-control">
        
                    <option value="">Clienti seçin</option>';
        
        
                    $sec = mysqli_query($con,"SELECT clients.id,clients.ad,clients.soyad FROM clients,users WHERE clients.user_id = users.id AND clients.user_id = ".$_SESSION['user_id']." ORDER BY clients.ad ASC");
                    while($info=mysqli_fetch_array($sec))
                    {echo'<option value="'.$info['id'].'">'.$info['ad'].' '.$info['soyad'].' </option>';}
        
        
            echo'
                </select><br>
                Məhsul:<br>
                <select name="product_id" class="form-control">
                    <option value="">Məhsulu seçin</option>';
        
                    $sec = mysqli_query($con,"SELECT products.id,
                    products.ad AS mehsul,
                    products.miqdar,
                    brands.ad AS brend FROM products,brands,users WHERE products.brand_id=brands.id AND products.user_id = users.id AND products.user_id = ".$_SESSION['user_id']." ORDER BY brands.ad ASC");
                    while($info=mysqli_fetch_array($sec) )
                    {echo'<option value="'.$info['id'].'">'.$info['brend'].' - '.$info['mehsul'].' ('.$info['miqdar'].') </option>';}
        
        
            echo'
                </select><br>
                Miqdar:<br>
                <input type="text" class="form-control" name="miqdar" autocomplete="off"><br>
                Kredit ayı:<br>
                <input type="text" class="form-control" name="muddet" autocomplete="off"><br>
                Faiz:<br>
                <input type="text" class="form-control" name="faiz" autocomplete="off"><br>
                İlkin ödəniş:<br>
                <input type="text" class="form-control" name="ilk" autocomplete="off"><br>
            
                <input type="hidden" name="token" value="'.$_SESSION['token'].'">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                <button type="submit" name="add" class="btn btn-primary">Əlavə et</button>
            </div>
            </form>
            </div>
        </div>
    </div>';
        
    }

    ?>
</div>

<?php
//FILTER START
    //Brend
    if($_GET['f1']=='ASC')
    {
        $order = " ORDER BY products.ad ASC ";
        $filter1 = '<a href="?f2=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f2']=='DESC')
    {   $order = " ORDER BY products.ad DESC ";
        $filter1 = '<a href="?f1=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter1 = '<a href="?f1=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Mehsul
    if($_GET['f3']=='ASC')
    {
        $order = " ORDER BY credits.faiz ASC ";
        $filter2 = '<a href="?f4=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f4']=='DESC')
    {   $order = " ORDER BY credits.faiz DESC ";
        $filter2 = '<a href="?f3=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter2 = '<a href="?f3=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Alis
    if($_GET['f5']=='ASC')
    {
        $order = " ORDER BY credits.muddet ASC ";
        $filter3 = '<a href="?f6=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f6']=='DESC')
    {   $order = " ORDER BY credits.muddet DESC ";
        $filter3 = '<a href="?f5=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter3 = '<a href="?f5=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Satis
    if($_GET['f7']=='ASC')
    {
        $order = " ORDER BY credits.ilk ASC ";
        $filter4 = '<a href="?f8=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f8']=='DESC')
    {   $order = " ORDER BY credits.ilk DESC ";
        $filter4 = '<a href="?f7=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter4 = '<a href="?f7=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Miqdar
    if($_GET['f9']=='ASC')
    {
        $order = " ORDER BY credits.ilk ASC ";
        $filter5 = '<a href="?f10=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f10']=='DESC')
    {   $order = " ORDER BY products.miqdar DESC ";
        $filter5 = '<a href="?f9=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter5 = '<a href="?f9=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //sifaris miqdari
    if($_GET['f11']=='ASC')
    {
        $order = " ORDER BY credits.miqdar ASC ";
        $filter6 = '<a href="?f12=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f12']=='DESC')
    {   $order = " ORDER BY credits.miqdar DESC ";
        $filter6 = '<a href="?f11=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter6 = '<a href="?f11=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //AD
    if($_GET['f13']=='ASC')
    {
        $order = " ORDER BY clients.ad ASC ";
        $filter7 = '<a href="?f14=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f14']=='DESC')
    {   $order = " ORDER BY clients.ad DESC ";
        $filter7 = '<a href="?f13=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter7 = '<a href="?f13=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    if(!isset($_GET['f1']) AND !isset($_GET['f2']) AND !isset($_GET['f3']) AND
     !isset($_GET['f4']) AND !isset($_GET['f5']) AND !isset($_GET['f6'])
     AND !isset($_GET['f7']) AND !isset($_GET['f8']) AND !isset($_GET['f9']) AND !isset($_GET['f10'])
     AND !isset($_GET['f11']) AND !isset($_GET['f12']) AND !isset($_GET['f13']) AND !isset($_GET['f14']))
    {$order = " ORDER BY credits.id DESC";}
    //FILTER END














    if(isset($_POST['axtar']) && !empty($_POST['sorgu']))
    {   $sorgu = trim($_POST['sorgu']);
        $sorgu = strip_tags($sorgu);
        $sorgu = htmlspecialchars($sorgu);
        $sorgu = mysqli_real_escape_string($con,$sorgu);

        $axtar = "AND( (products.ad LIKE '%".$sorgu."%') OR (brands.ad LIKE '%".$sorgu."%') 
         OR (clients.ad LIKE '%".$sorgu."%')
         OR (clients.soyad LIKE '%".$sorgu."%') )";}
        
    if(isset($_POST['taxtar']) && !empty($_POST['t1']) && !empty($_POST['t2']))
    {
        $t1 = date('Y-m-d', strtotime("+1 day", strtotime($_POST['t1'])));
        $t2 = $_POST['t2'];
        $taxtar = " AND( credits.tarix BETWEEN '".$t2."' AND '".$t1."' )";
    }

    //SEHIFELEME START

    $setir_sayi = 4;
    $sehife_sec = mysqli_query($con,"SELECT credits.id
    FROM credits, products, brands, clients, users 
    WHERE (credits.product_id=products.id) 
    AND (credits.client_id=clients.id) AND (products.brand_id=brands.id)
    AND (credits.user_id = users.id) AND (credits.user_id = ".$_SESSION['user_id'].") 
    ");
    $toplam_brend = mysqli_num_rows($sehife_sec);

    $toplam_sehife = intval(($toplam_brend-1)/ $setir_sayi) + 1;
    $page = intval($_GET['page']);

    if(empty($page) or $page<0){$page = 1;}
    if($page>$toplam_sehife){$page = $toplam_sehife;}
    $start = $page * $setir_sayi - $setir_sayi;

    //SEHIFELEME END



    $sec = mysqli_query($con,"SELECT 
    credits.id,
    credits.client_id,
    credits.product_id,
    credits.muddet,
    credits.faiz,
    credits.ilk,
    credits.tesdiq,
    credits.odenilib,
    credits.depozit,
    products.ad AS mehsul,
    clients.ad AS client,
    clients.soyad,
    products.alis,
    products.satis,
    products.miqdar AS mehsul_miqdar,
    credits.miqdar AS credit_miqdar,
    credits.tarix,
    brands.ad AS brend
    FROM credits, products, brands, clients, users 
    WHERE (credits.product_id=products.id) 
    AND (credits.client_id=clients.id) AND (products.brand_id=brands.id)
    AND (credits.user_id = users.id) AND (credits.user_id = ".$_SESSION['user_id'].") 
    ".$axtar.$taxtar.$order." LIMIT ".$start.",".$setir_sayi);
    $kredit_sayi= mysqli_num_rows($sec);
        
    if ($kredit_sayi>=1) { 
    ?>
<div class="container" style="overflow-x:auto;">
    <table class="table table-striped table-dark">
        <thead>
            <th>#</th>
            <th>Müştəri <?=$filter7?></th>
            <th>Məhsul <?=$filter1?></th>
            <th>Miqdar <?=$filter6?></th>
            <th>Faiz <?=$filter2?></th>
            <th>Kredit müddəti <?=$filter3?></th>
            <th>İlkin ödəniş <?=$filter4?></th>
            <th>Qiymət</th>
            <th>Borc</th>
            <th>Aylıq ödəniş</th>
            <th>Qalan müddət</th>
            <th>Ödənilən</th>
            <th>Depozit</th>
            <th>Qazanc</th>
            <th>Tarix</th>
            <th></th>
        </thead>

        <tbody>
            <?php
            $i = 0;
            while($info = mysqli_fetch_array($sec))
            {   
                
                $bugun= date("Y-m-d H:i:s");
                $kredit_tarixi = $info['tarix'];
                $kredit_bitme_tarixi =  date('Y-m-d', strtotime("+".$info['muddet']." months", strtotime($kredit_tarixi)));
                $kredit_qalan_san = strtotime($kredit_bitme_tarixi);
                $bugun_san = strtotime($bugun);
                $kredit_qalan_gun = round(($kredit_qalan_san-$bugun_san)/(60*60*24)) ;
                $i++;
                echo'<tr>';
                echo'<td>'.$i.'</td>';
                echo'<td>'.$info['client'].' '.$info['soyad'].'</td>';
                echo'<td>'.$info['mehsul'].' ( '.$info['brend'].' )</td>';
                echo'<td>'.$info['credit_miqdar'].'</td>';
                echo'<td>'.$info['faiz'].'%</td>';
                echo'<td>'.$info['muddet'].' ay</td>';
                echo'<td>'.$info['ilk'].'</td>';
                echo'<td>'.round(($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100), 3).'</td>';
                echo'<td>'.(round((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'], 3)-($info['odenilib']*round(((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'])/$info['muddet'], 3))).'</td>';
                echo'<td>'.round(((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'])/$info['muddet'], 3).'</td>';
                echo'<td>'.$kredit_qalan_gun.' gün</td>';
                echo'<td>'.$info['odenilib'].'/'.$info['muddet'].' ay</td>';
                echo'<td>'.$info['depozit'].'</td>';
                echo'<td>'.$info['odenilib']*round(((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'])/$info['muddet'], 3).'</td>';
                echo'<td>'.$info['tarix'].'</td>';
                echo'<td>
                <form method="post">
                <input type="hidden" name="id" value="'.$info['id'].'">
                <input type="hidden" name="client_id" value="'.$info['client_id'].'">
                <input type="hidden" name="product_id" value="'.$info['product_id'].'">
                <input type="hidden" name="mehsul_miqdar" value="'.$info['mehsul_miqdar'].'">
                <input type="hidden" name="credit_miqdar" value="'.$info['credit_miqdar'].'">
                <input type="hidden" name="odenilib" value="'.$info['odenilib'].'"> 
                <input type="hidden" name="tesdiq_status" value="'.$info['tesdiq'].'">
                <input type="hidden" name="muddet" value="'.$info['muddet'].'">
                <input type="hidden" name="depozit" value="'.$info['depozit'].'">
                <input type="hidden" name="ayliq_odenis" value="'.round(((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'])/$info['muddet'], 3).'">
                <input type="hidden" name="qaliq_borc" value="'.(round((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'], 3)-($info['odenilib']*round(((($info['satis']*$info['credit_miqdar'])*(1+$info['faiz']/100))-$info['ilk'])/$info['muddet'], 3))).'">';
                

               if ($info['tesdiq']=='0') {
                echo '          
                <button type="submit" class="btn btn-danger btn-sm" name="delete" title="Sil">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
                </button>
                <button type="submit" class="btn btn-primary btn-sm" name="edit" title="Redaktə et">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                </svg>
                </button>
        
        
                <button type="submit" class="btn btn-success btn-sm" name="tesdiq" title="Təsdiq et">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                </svg>
                </button>';
                }
                if ($info['tesdiq']=='1') {
                echo'
                <button type="submit" class="btn btn-primary btn-sm " name="ode" title="Ödə">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                </svg>
                </button>
                <button type="submit" class="btn btn-danger btn-sm " name="legv" title="Ləğv et">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16">
                <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
                </button>
                ';
                
                
                }
                
                


                echo '
                </form>
                </td>';
                echo'</tr>';
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
         echo '<div class="container" style="overflow-x:auto;"><div class="alert alert-warning" role="alert">Məlumat tapılmadı.</div>';
    } ?>
</div>