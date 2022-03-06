<?php
include"header.php";
?>


<div class="container">
    <div class="alert alert-dark" role="alert">
        <h3 class="text-right">Məhsul</h3>
    </div>
    <?php
    $sec = mysqli_query($con,"SELECT * FROM products");
    $say = mysqli_num_rows($sec);

    $add = true;

    if(isset($_POST['add'])){  
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
        if($_SESSION['token']==$_POST['token']){ 
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
    }

    if(isset($_POST['delete'])){
        $add = false;  
        $mehsulsec = mysqli_query($con,"SELECT ad FROM products WHERE id='".$_POST['id']."'");
        $i = 0;
        while($mehsul_sil = mysqli_fetch_array($mehsulsec)){
            $i++;  
            $silinen_mehsul = $mehsul_sil['ad'];
        }
        echo '
        <div class="alert alert-dark" role="alert">
        Siz <b>"'.$silinen_mehsul.'"</b> adlı məhsulu silməyə əminsiniz?<br><br>
        <form method="post">
        <button type="submit" class="btn btn-primary btn-sm" name="yes" >Bəli</button> / <button type="submit" class="btn btn-danger btn-sm"  name="no" ">Xeyr</button>
        <input type="hidden" name="silinen_id" value="'.$_POST['id'].'">
        </form>
        </div>
        ';   
    }
    if (isset($_POST['yes'])) {
        $add= true;
        $sil = mysqli_query($con,"DELETE FROM products WHERE id='".$_POST['silinen_id']."'");
        if($sil==true){
            echo'<div class="alert alert-success" role="alert">Məhsul uğurla silindi.</div>';
        }else{
            echo'<div class="alert alert-danger" role="alert">Məhsulu silmek mümkün olmadı.</div>';
        }
    }
    if (isset($_POST['no'])) {
        $add= true;
        echo '<div class="alert alert-warning" role="alert">Məhsulu silməyə imtina etdiniz.</div> ';
    }



    if(isset($_POST['edit'])){
        $add= false;
        $edit_mehsul_sec = mysqli_query($con,"SELECT * FROM products WHERE id='".$_POST['id']."'");        
        $edit_info = mysqli_fetch_array($edit_mehsul_sec);
        $edit_brend_sec = mysqli_query($con,"SELECT * FROM brands WHERE id='".$edit_info['brand_id']."'");
        $edit_brend_info = mysqli_fetch_array($edit_brend_sec);

        ?>
    <div class="alert alert-dark" role="alert">
        <form method="post" enctype="multipart/form-data">
            <?php
            echo '
            Brend:<br>
            <select name="brand_id" class="form-control">';
    
            echo'<option value="'.$edit_brend_info['id'].'" selected="selected">'.$edit_brend_info['ad'].'</option>';
                $sec = mysqli_query($con,"SELECT brands.id, brands.ad FROM brands,users WHERE brands.id !=".$edit_info['brand_id']." AND brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id']." ORDER BY brands.ad ASC");

                while($info=mysqli_fetch_array($sec)){
                    echo'<option value="'.$info['id'].'">'.$info['ad'].'</option>';
                }        
    
            echo'
            </select><br> ';
            ?>
            Məhsul adı:<br>
            <input type="text" class="form-control" autocomplete="off" name="ad"
                value="<?php echo $edit_info['ad']?>"><br>
            Alış qiyməti:<br>
            <input type="text" class="form-control" autocomplete="off" name="alis"
                value="<?php echo $edit_info['alis']?>"><br>
            Satış qiyməti:<br>
            <input type="text" class="form-control" autocomplete="off" name="satis"
                value="<?php echo $edit_info['satis']?>"><br>
            Miqdar:<br>
            <input type="text" class="form-control" autocomplete="off" name="miqdar"
                value="<?php echo $edit_info['miqdar']?>"><br>
            Məhsulun şəkli:<br>
            <div class="form-group">
                <img src="<?=$edit_info['foto']?>" style="width:110px; height:90px"><br><br>
                <?php
                /*
                $sekiledit = '<a href="?sekli_deyis=true" class="btn btn-secondary btn-lg active"
                 role="button" aria-pressed="true">Şəkli dəyiş</a>';
                
                if ($_GET['sekli_deyis']==true) {
                    echo '<input type="file" class="form-control-file" name="foto"><br>
                    <a href="?sekli_deyis=true" class="btn btn-secondary btn-lg active"
                 role="button" aria-pressed="true">Şəkli dəyiş</a> ';
                }else{
                    echo $sekiledit;
                }
                */
                ?>
                <input type="file" class="form-control-file" name="foto" value="<?php echo $edit_info['foto']?>">
            </div>
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
        if ($ad<>"" && !empty($_POST['brand_id']) && $alis<>"" && $satis<>"" && $miqdar<>"" && $upload){                             
            $yenile = mysqli_query($con,"UPDATE products SET 
            ad ='".$ad."',
            alis='".$alis."',
            satis='".$satis."',
            miqdar='".$miqdar."',
            brand_id='".$_POST['brand_id']."',
            foto='".$unvan."'
            WHERE id='".$_POST['id']."'");
            if($yenile==true){
                echo'<div class="alert alert-success" role="alert">Məhsul uğurla yeniləndi.</div>';
            }else{
                echo'<div class="alert alert-danger" role="alert">Məhsulu yeniləmək mümkün olmadı.</div>';
            }
            
        }else{
            echo '<div class="alert alert-warning" role="alert">Məlumatları tam doldurun</div>';
        }   
    }

    ?>
    <?php
    $_SESSION['token'] = md5(rand());
    if($add){
        echo '
    <div class="alert alert-dark" role="alert">
    <form method="post">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productadd" title="Məhsul əlavə et">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
        </svg>
    </button>
    <a class="btn btn-dark ml-3" title="Excel" href="excel/Examples/anbar_products.php">Excel faylını yüklə</a>
    
    <button type="submit" class="btn btn-success float-right mx-2" name="taxtar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
  </svg>
  </button>
    <input type="date" class="float-right" name="t1" value="'.$_POST['t1'].'">
    <input type="date" class="float-right" name="t2" value="'.$_POST['t2'].'">
    </form>
    </div>
    <div class="modal fade" id="productadd"  data-backdrop="static" data-keyboard="false"  tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Yeni Məhsul</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="" method="post"  enctype="multipart/form-data">
                Brend:<br>
                <select name="brand_id" class="form-control">
        
                    <option value="">Brendi seçin</option>';
        
        
                    $sec = mysqli_query($con,"SELECT  brands.id,brands.ad FROM brands,users  WHERE brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id']." ORDER BY brands.ad ASC");
        
                    while($info=mysqli_fetch_array($sec))
                    {echo'<option value="'.$info['id'].'">'.$info['ad'].'</option>';}
        
        
            echo'
                </select><br>
                Məhsul adı:<br>
                <input type="text" class="form-control" name="ad" autocomplete="off"><br>
                Alış qiyməti:<br>
                <input type="text" class="form-control" name="alis" autocomplete="off"><br>
                Satış qiyməti:<br>
                <input type="text" class="form-control" name="satis" autocomplete="off"><br>
                Miqdar:<br>
                <input type="text" class="form-control" name="miqdar" autocomplete="off"><br>
                Məhsulun şəkli:<br>                  
                <div class="form-group">           
                    <input type="file" class="form-control-file" name="foto">
                </div>
                <input type="hidden" name="token" value="'.$_SESSION['token'].'">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                <button type="submit" name="add" class="btn btn-primary" >Əlavə et</button>
            </div>
            </form>
            </div>
        </div>
    </div>
    
    ';   
    }


    //FILTER START
    //Brend
    if($_GET['f1']=='ASC')
    {
        $order = " ORDER BY brands.ad ASC ";
        $filter1 = '<a href="?f2=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f2']=='DESC')
    {   $order = " ORDER BY brands.ad DESC ";
        $filter1 = '<a href="?f1=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter1 = '<a href="?f1=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Mehsul
    if($_GET['f3']=='ASC')
    {
        $order = " ORDER BY products.ad ASC ";
        $filter2 = '<a href="?f4=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f4']=='DESC')
    {   $order = " ORDER BY products.ad DESC ";
        $filter2 = '<a href="?f3=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter2 = '<a href="?f3=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Alis
    if($_GET['f5']=='ASC')
    {
        $order = " ORDER BY products.alis ASC ";
        $filter3 = '<a href="?f6=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f6']=='DESC')
    {   $order = " ORDER BY products.alis DESC ";
        $filter3 = '<a href="?f5=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter3 = '<a href="?f5=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Satis
    if($_GET['f7']=='ASC')
    {
        $order = " ORDER BY products.satis ASC ";
        $filter4 = '<a href="?f8=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f8']=='DESC')
    {   $order = " ORDER BY products.satis DESC ";
        $filter4 = '<a href="?f7=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter4 = '<a href="?f7=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    //Miqdar
    if($_GET['f9']=='ASC')
    {
        $order = " ORDER BY products.miqdar ASC ";
        $filter5 = '<a href="?f10=DESC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down-alt" viewBox="0 0 16 16">
        <path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/>
        <path fill-rule="evenodd" d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/>
        <path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
        </svg>
        </a>';
    }
    else if($_GET['f10']=='DESC')
    {   $order = " ORDER BY products.miqdar DESC ";
        $filter5 = '<a href="?f9=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }else{
        $filter5 = '<a href="?f9=ASC">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
    </svg>
        </a>';
    }
    if(!isset($_GET['f1']) AND !isset($_GET['f2']) AND !isset($_GET['f3']) AND
     !isset($_GET['f4']) AND !isset($_GET['f5']) AND !isset($_GET['f6'])
     AND !isset($_GET['f7']) AND !isset($_GET['f8']) AND !isset($_GET['f9']) AND !isset($_GET['f10']))
    {$order = " ORDER BY products.id DESC ";}
    //FILTER END














    if(isset($_POST['axtar']) && !empty($_POST['sorgu']))
    {   $sorgu = trim($_POST['sorgu']);
        $sorgu = strip_tags($sorgu);
        $sorgu = htmlspecialchars($sorgu);
        $sorgu = mysqli_real_escape_string($con,$sorgu);
        $axtar = "AND( (products.ad LIKE '%".$sorgu."%') OR (brands.ad LIKE '%".$sorgu."%') )";}
       
    if(isset($_POST['taxtar']) && !empty($_POST['t1']) && !empty($_POST['t2']))
    {
        $t1 = date('Y-m-d', strtotime("+1 day", strtotime($_POST['t1'])));
        $t2 = $_POST['t2'];
        $taxtar = " AND( products.tarix BETWEEN '".$t2."' AND '".$t1."' )";
    }


//SEHIFELEME START

$setir_sayi = 4;
$sehife_sec = mysqli_query($con,"SELECT products.id
FROM products, brands, users 
WHERE (products.brand_id=brands.id) AND (products.user_id = users.id) AND (products.user_id = ".$_SESSION['user_id'].")");
$toplam_brend = mysqli_num_rows($sehife_sec);

$toplam_sehife = intval(($toplam_brend-1)/ $setir_sayi) + 1;
$page = intval($_GET['page']);

if(empty($page) or $page<0){$page = 1;}
if($page>$toplam_sehife){$page = $toplam_sehife;}
$start = $page * $setir_sayi - $setir_sayi;

//SEHIFELEME END


    $sec = mysqli_query($con,"SELECT 
    products.id,
    products.ad AS mehsul,
    products.alis,
    products.satis,
    products.miqdar,
    products.tarix,
    products.foto,
    brands.ad AS brend
    FROM products, brands, users 
    WHERE (products.brand_id=brands.id) AND (products.user_id = users.id) AND (products.user_id = ".$_SESSION['user_id'].")"
    .$axtar.$taxtar.$order." LIMIT ".$start.",".$setir_sayi);
    $mehsul_sayi= mysqli_num_rows($sec);

    //++++++ UMUMI mehsul SAYI
    $umumi_baza =mysqli_query($con,"SELECT 
    products.id,
    products.ad AS mehsul,
    products.alis,
    products.satis,
    products.miqdar,
    products.tarix,
    products.foto,
    brands.ad AS brend
    FROM products, brands, users 
    WHERE (products.brand_id=brands.id) AND (products.user_id = users.id) AND (products.user_id = ".$_SESSION['user_id'].")");
    $umumi_baza_mehsul_sayi= mysqli_num_rows($umumi_baza);
    //------- UMUMI mehsul SAYI
 


    if ($mehsul_sayi>=1) { 
    ?>
    <div class="alert alert-info" role="alert">Bazada <b><?=$umumi_baza_mehsul_sayi ?></b> məhsul var</div>



    <table class="table table-striped table-dark">
        <thead>
            <th>#</th>
            <th>Brend  <?=$filter1 ?></th>
            <th>Səkil</th>
            <th>Məhsul  <?=$filter2 ?></th>
            <th>Alış  <?=$filter3 ?></th>
            <th>Satış  <?=$filter4 ?></th>
            <th>Miqdar  <?=$filter5 ?></th>
            <th>Qazanc</th>
            <th>Tarix</th>
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
                echo'<td>'.$info['brend'].'</td>';
                echo'<td><img style="width:110px; height:90px" src="'.$info['foto'].'"></td>';
                echo'<td>'.$info['mehsul'].'</td>';
                echo'<td>'.$info['alis'].'</td>';
                echo'<td>'.$info['satis'].'</td>';
                echo'<td>'.$info['miqdar'].'</td>';
                echo'<td>'.($info['satis']-$info['alis'])*$info['miqdar'].'</td>';
                echo'<td>'.$info['tarix'].'</td>';
                echo'<td>
                <form method="post">
                <input type="hidden" name="id" value="'.$info['id'].'">
                <button type="submit" class="btn btn-danger btn-sm" name="delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
                </button>
                <button type="submit" class="btn btn-primary btn-sm" name="edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
</svg>
                </button>
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
         echo '<div class="alert alert-warning" role="alert">Məlumat tapılmadı.</div>';
    } ?>
</div>