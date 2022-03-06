<?php
include"header.php";
?>


<div class="container">
    <div class="alert alert-dark" role="alert">
        <h3 class="text-right">Brend</h3>
    </div>
    <?php
    $sec = mysqli_query($con,"SELECT * FROM brands");
    $say = mysqli_num_rows($sec);
    $ad_yoxla = mysqli_query($con,"SELECT brands.ad FROM brands,users WHERE brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id']);

    $add = true;

    if(isset($_POST['add'])){  
        $ad = trim($_POST['ad']);
        $ad = strip_tags($ad);
        $ad = htmlspecialchars($ad);
        $ad = mysqli_real_escape_string($con,$ad);

        include"upload.php";
        if($_SESSION['token']==$_POST['token']){
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
    }

    if(isset($_POST['delete'])){
        $add = false;  
        $brandsec = mysqli_query($con,"SELECT ad FROM brands WHERE id='".$_POST['id']."'");
        $i = 0;
        while($brand_sil = mysqli_fetch_array($brandsec)){
            $i++;  
            $silinen_brand = $brand_sil['ad'];
        }
        echo '
        <div class="alert alert-dark" role="alert">
        Siz <b>"'.$silinen_brand.'"</b> adlı brendi silməyə əminsiniz?<br><br>
        <form method="post">
        <button type="submit" class="btn btn-primary btn-sm" name="yes" >Bəli</button> / <button type="submit" class="btn btn-danger btn-sm"  name="no" ">Xeyr</button>
        <input type="hidden" name="silinen_id" value="'.$_POST['id'].'">
        </form>
        </div>
        ';   
    }
    if (isset($_POST['yes'])) {
        $add= true;
        $sil = mysqli_query($con,"DELETE FROM brands WHERE id='".$_POST['silinen_id']."'");
        if($sil==true){
            echo'<div class="alert alert-success" role="alert">Brend uğurla silindi.</div>';
        }else{
            echo'<div class="alert alert-danger" role="alert">Brendi silmek mümkün olmadı.</div>';
        }
    }
    if (isset($_POST['no'])) {
        $add= true;
        echo '<div class="alert alert-warning" role="alert">Brendi silməyə imtina etdiniz.</div> ';
    }



    if(isset($_POST['edit'])){
        $add= false;
        $edit_sec = mysqli_query($con,"SELECT * FROM brands WHERE id='".$_POST['id']."'");
        $edit_info = mysqli_fetch_array($edit_sec);

        ?>
    <div class="alert alert-dark" role="alert">
        <form method="post"  enctype="multipart/form-data">
            Brendin yeni adı:<br>
            <input type="text" class="form-control" autocomplete="off" name="ad"
                value="<?php echo $edit_info['ad']?>"><br>
            Loqo:<br> 
            <div class="form-group">           
                <input type="file" class="form-control-file" name="foto" value="<?php echo $edit_info['foto']?>" >
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
        $ad = trim($_POST['ad']);
        $ad = strip_tags($ad);
        $ad = htmlspecialchars($ad);
        $ad = mysqli_real_escape_string($con,$ad);
        $add = true;
        $brand_yoxla = mysqli_query($con,"SELECT ad FROM brands WHERE ad='".$ad."' AND id!='".$_POST['id']."'");

        include"upload.php";
        if ($ad<>"" && $upload){
                
            if(mysqli_num_rows($brand_yoxla)==0){         
                    $yenile = mysqli_query($con,"UPDATE brands SET 
                    ad='".$ad."', foto = '".$unvan."'
                    WHERE id='".$_POST['id']."'");

                    if($yenile==true)
                    {echo'<div class="alert alert-success" role="alert">Brend uğurla yeniləndi.</div>';}
                    else
                    {echo'<div class="alert alert-danger" role="alert">Brendi yeniləmək mümkün olmadı.</div>';}
                }
            else{
                echo'<div class="alert alert-danger" role="alert">Bu brend artıq mövcuddur.</div>';
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
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#brandadd" title="Brend əlavə et">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
        <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
        </svg>
        </button>
    <a class="btn btn-dark ml-3" title="Excel" href="excel/Examples/anbar_brands.php">Excel faylını yüklə</a>
  
    <button type="submit" class="btn btn-success float-right mx-2" name="taxtar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
  </svg>
  </button>
  
    <input type="date" class="float-right" name="t1" value="'.$_POST['t1'].'">
    <input type="date" class="float-right" name="t2" value="'.$_POST['t2'].'">
    </form>
    </div>
    <div class="modal fade" id="brandadd"  data-backdrop="static" data-keyboard="false"  tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Yeni Brend</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="" method="post"  enctype="multipart/form-data">
                Brendın adı:<br>
                <input type="text" class="form-control" name="ad" autocomplete="off"><br>
                Loqo:<br>                  
                <div class="form-group">           
                    <input type="file" class="form-control-file" name="foto">
                </div>
                <input type="hidden" name="token" value="'.$_SESSION['token'].'">
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
    //FILTER START
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

    if(!isset($_GET['f1']) AND !isset($_GET['f2']))
    {$order = " ORDER BY brands.id DESC ";}
    //FILTER END

    if(isset($_POST['axtar']) && !empty($_POST['sorgu']))
    {   $sorgu = trim($_POST['sorgu']);
        $sorgu = strip_tags($sorgu);
        $sorgu = htmlspecialchars($sorgu);
        $sorgu = mysqli_real_escape_string($con,$sorgu);
        $axtar = " AND (brands.ad LIKE '%".$sorgu."%') ";}

    if(isset($_POST['taxtar']) && !empty($_POST['t1']) && !empty($_POST['t2']))
    {
        $t1 = date('Y-m-d', strtotime("+1 day", strtotime($_POST['t1'])));
        $t2 = $_POST['t2'];
        $taxtar = " AND brands.tarix BETWEEN '".$t2."' AND '".$t1."' ";
    }

    //SEHIFELEME START

    $setir_sayi = 4;
    $sehife_sec = mysqli_query($con,"SELECT brands.ad FROM brands,users WHERE brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id']);
    $toplam_brend = mysqli_num_rows($sehife_sec);

    $toplam_sehife = intval(($toplam_brend-1)/ $setir_sayi) + 1;
    $page = intval($_GET['page']);

    if(empty($page) or $page<0){$page = 1;}
    if($page>$toplam_sehife){$page = $toplam_sehife;}
    $start = $page * $setir_sayi - $setir_sayi;

    //SEHIFELEME END

    $sec = mysqli_query($con,"SELECT brands.id,brands.ad,
    brands.tarix, brands.foto
    FROM brands,users WHERE brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id'].$axtar.$taxtar.$order." LIMIT ".$start.",".$setir_sayi);
    $brend_sayi= mysqli_num_rows($sec);

    //++++++ UMUMI BREND SAYI
    $umumi_baza = mysqli_query($con,"SELECT brands.id,brands.ad,
    brands.tarix, brands.foto
    FROM brands,users WHERE brands.user_id = users.id AND brands.user_id = ".$_SESSION['user_id']);
    $umumi_baza_brend= mysqli_num_rows($umumi_baza);
    //------- UMUMI BREND SAYI

    if ($brend_sayi>0) { 
    ?> 
    <div class="alert alert-info" role="alert">Bazada <b><?=$umumi_baza_brend ?></b> brend var</div>
   
     
   
    <table class="table table-striped table-dark">
        <thead>
            <th>#</th>
            <th>Loqo</th>
            <th>Brend <?=$filter1 ?></th>
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
                echo'<td><img style="width:110px; height:90px" src="'.$info['foto'].'"></td>';
                echo'<td>'.$info['ad'].'</td>';
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
    /*
    if ($page != 1) {$pervpage = '<a  class="page-link"  href="?page=1"><<</a>
    <a  class="page-link"  href="?page='. ($page - 1) .'"><</a> ';}
    if ($page != $toplam_sehife) {$nextpage = ' <a  class="page-link"  href="?page='. ($page + 1) .'">></a>
            <a  class="page-link"  href="?page=' .$toplam_sehife. '">>></a>';}

    if($page - 2 > 0) {$page2left = ' <a  class="page-link"  href="?page='. ($page - 2) .'">'. ($page - 2) .'</a> | ';}
    if($page - 1 > 0) {$page1left = '<a  class="page-link"  href="?page='. ($page - 1) .'">'. ($page - 1) .'</a> | ';}
    if($page + 2 <= $toplam_sehife) {$page2right = ' | <a  class="page-link"  href="?page='. ($page + 2) .'">'. ($page + 2) .'</a>';}
    if($page + 1 <= $toplam_sehife) {$page1right = ' | <a   class="page-link" href="?page='. ($page + 1) .'">'. ($page + 1) .'</a>';}


    //echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
    */




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