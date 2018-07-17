<?php 
include_once './common_lib/createLink_db.php';
include_once './message/source/create_message.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 가자~</title>
   <link rel="stylesheet" href="./common_css/index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 1200%;
      height : 600px;
      margin: auto;
  }
  </style>
</head>

<body>
<header>
<?php include_once './common_lib/top_login1.php';?>
</header>
<nav id="top">
<?php include_once './common_lib/main_menu1.php';?>
</nav>
  <section>
 <div class="container">

  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="./common_img/index1.jpg" width="460" height="345">
        <div class="carousel-caption">
          <h2>Asia</h2>
          <p>Feel Oriental beauty and beautiful natural scenery.</p>
        </div>
      </div>

      <div class="item">
        <img src="./common_img/index2.png" width="460" height="345">
        <div class="carousel-caption">
          <h3>Europe</h3>
          <p>Take a look at some of Europe's unique landscapes.</p>
        </div>
      </div>
    
      <div class="item">
        <img src="./common_img/index3.jpg" width="460" height="345">
        <div class="carousel-caption">
          <h3>America</h3>
          <p>Experience the vast landscapes of America.</p>
        </div>
      </div>

      <div class="item">
        <img src="./common_img/index4.jpg" width="460" height="345">
        <div class="carousel-caption">
          <h3>Afreeca</h3>
          <p>Beautiful nature that can only be felt in Africa</p>
        </div>
      </div>
  
      <div class="item">
        <img src="./common_img/index5.jpg" width="460" height="345">
        <div class="carousel-caption">
          <h3>Oceania</h3>
          <p>Oceania is a beautiful and beautiful place.</p>
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
 
  </section>
  
  <footer>
  <?php include_once './common_lib/footer1.php';?>
  </footer>

</body>

</html>