<?php

//unvai elde edirik. Meselen, images/hasan.jpg
$unvan = 'images/'.basename($_FILES['foto']['name']);
//faylin tipini elde edirik
$tip = strtolower(pathinfo($unvan,PATHINFO_EXTENSION));

if($tip!='jpg' && $tip!='jpeg' && $tip!='png' && $tip!='gif')
{
    $error = 1;
    echo'<div class="alert alert-warning" role="alert">Foto yalnız <b>jpg, jpeg, png, gif</b> formatlarında ola bilər </div>';
}

if($_FILES['foto']['size']>10485760)
{
    $error = 1;
    echo'<div class="alert alert-warning" role="alert">Faylın həcmi <b>10 Mb</b>-dan çox ola bilməz</div>';
}


if(!isset($error))
{
    $unvan = 'images/'.time().'.'.$tip;
    move_uploaded_file($_FILES['foto']['tmp_name'],$unvan);
    $upload = 1;
}

?>