<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/drcustoms.css">
    <link rel="stylesheet" type="text/css" href="css/search.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/nav_menus.css">
    <script src="javascript/search_page.js"></script>
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
    $json_result = urldecode($_GET['data']);

    // Decode the JSON data back into an array
    $articles = json_decode($json_result, true);
    ?>
    <h1 class="top"> Found <?php echo count($articles); ?> products! </h1>

<?php
        foreach( $articles as $article) {
          ?><a onclick="send(<?php echo $article['id'];?>)">
          <article class ="section">
            <div class="img_box">
                <img class= "image" src=" <?php echo $article['image']; ?>" alt="image">
            </div>
            <div class="content">
                <h1 class="title"><?php echo $article['title']; ?></h1>
        
                <?php
                $textdivided = explode('/n', $article['description']);
                foreach ($textdivided as $text){
                    ?> <p class = "description"> "<?php echo $text; ?>" </p> <?php
                }
          ?>  <?php
          echo '<footer>';
          echo '<span class="price">'. $article['price'] .'$ </span>';
          ?>
          <span class="price"> - <?php echo $article['creationDate']; ?> </span>
          </footer>
            </div>
          </article>
            </a>
          <?php
          }
?>
</section>


</body>
</html>