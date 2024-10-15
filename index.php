<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/drcustoms.css">
    <link rel="stylesheet" type="text/css" href="css/main_page.css">
    <link rel="stylesheet" type="text/css" href="css/nav_menus.css">
    <script src="javascript/index.js"></script>
    <title>S. O. S.</title>
  </head>
  <body>
    <div class="header">
      <?php include "header.php"; ?>
    </div>
    <div class="sidebar">
      <?php include "nav_menu.php"; ?>
    </div>    
    <section class="items">
      <?php
              $db = new PDO('sqlite:./database/LTW.db');
              $stmt = $db->prepare('SELECT Product.id as product_id, Product.*, Users.*
              FROM Product LEFT JOIN
                   Users ON Product.creator_id = Users.id');
              $stmt->execute();
              $articles = $stmt->fetchAll();
              foreach( $articles as $article) {
                ?><a onclick="send(<?php echo $article['product_id'];?>)">
                <article class ="section">
                <header>
                <h1><?php echo $article['title']; ?></h1>
                <hr>
              </header>
              
                <img class= "image" src= <?php echo $article['image'] ?> alt="image">
                <hr>
                <?php
                $textdivided = explode('/n', $article['description']);
                foreach ($textdivided as $text){
                  ?> <p> <?php echo $text; ?> </p> <?php
                }
                ?> <hr> <?php
                echo '<footer>';
                echo '<span class="price">'. $article['price'] .'$ </span>';
                ?>
                </footer>
                </article>
                </a>
                <?php
                }
      ?>
    </section>
  </body>
</html>