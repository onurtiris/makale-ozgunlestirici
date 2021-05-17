<?php

include_once "settings.php";
$sql = "SELECT * FROM words";
$result = mysqli_query($connection, $sql);
$datas = array();

if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $word[] = " " . $row['word'] . " ";
        $synonym[] = " " . $row['synonym'] . " ";
    }
}

if(isset($_POST['convert'])) {
    $article=$_POST['before'];
    session_start();
    if (isset($_POST['security'])) {
        if ($_POST['security'] == $_SESSION['code']) {
            $newarticle = str_ireplace($word, $synonym, $article);
          	mysqli_fetch_assoc(mysqli_query($connection,"UPDATE statistics SET counter=counter+1"));
        }
        else {
            echo '<script>alert("Güvenlik kodu yanlış ya da eksik girildi.")</script>';
        }
    }
}
    
?>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>
$(function(){
    var character_counter = 600; 
    $('textarea').bind('keydown keyup keypress change',function(){
        var thisValueLength = $(this).val().length;
        var saymin = (character_counter)-(thisValueLength); 
        $('.character_counter').html(saymin);
 
        if(saymin < 30){ 
            $('.character_counter').css({color:'#ff0000',fontWeight:'bold'});
        } else { 
            $('.character_counter').css({color:'#000000',fontWeight:'bold'});
        }
    });
    $(window).load(function(){
        $('.character_counter').html(character_counter); 
    });
});
</script>

<script type="text/javascript">
function checkChar()
{
 var allowedChar=600;
 var content= document.getElementById("before");
 var contLength=content.value.length;
    
 if(contLength > allowedChar){
  content.value=content.value.substring(0,allowedChar);
 }  
}
</script>


<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Makale özgünleştirme Aracı">
    <meta name="author" content="Onur Tiriş">
    <title>Makale Özgünleştirme Aracı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/spinner.css" rel="stylesheet">
  </head>

  <body class="text-center">
    
    <main class="form-spinner">
      <form method="POST">

        <h1 class="h2 fw-normal fw-bold mb-2">Makale Özgünleştir</h1>
        <p class="fw-500 mb-4">Kelime bazlı Türkçe spinner içerik çeviri aracı ile özgün makaleler üretmenizi sağlayan ücretsiz içerik özgünleştirme aracıdır.</p>
      

        <div class="information-text">&nbspkarakter</div>
        <div class="character_counter fw-bold" style="float:right;">600</div>
        <div class="information-text">En fazla&nbsp</div>
      
        <div class="form-floating">
          <textarea onkeyup="checkChar()" onkeydown="checkChar()" id="before" name="before" class="article-input" placeholder="Makaleyi girin"><?php echo $article; ?></textarea>
        </div>

        <table width="100%;">
        <tr>
          <th width:50%><div class="captcha-background"><img src="captcha.php" style="margin-top:12px;" /></div></th>
          <th width:50%><input type="text" class="security-input" placeholder="Güvenlik" name="security" /></th>
        </tr>
        </table>

        <button class="w-50 mb-1 mt-3 submit-spinner" type="submit" name="convert">ÇEVİR</button>

        <div class="form-floating">
          <textarea name="after" class="article-input" placeholder="Çevrilmiş içerik burada görüntülenecek" readOnly><?php echo $newarticle; ?></textarea>
        </div>

        <p class="mt-3 mb-3 text-muted"><a href="https://github.com/onurtiris" class="mt-2 mb-3 text-muted">Developed by Onur Tiriş</a></p>
      </form>
    </main>
    
  </body>
</html>
