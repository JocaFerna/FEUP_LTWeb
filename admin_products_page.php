<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/admin_table_page.css">
      <!-- Include Remixicon-->
      <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
      <title>SELLOS</title>
  </head>
  <body>
    <script src="javascript/administrate_product.js"></script>
    <table>
      <caption>Product List</caption>
      <thead>
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Owner Name</th>
          <th scope="col">Price</th>
          <th scope="col">Status</th>
          <th scope="col">Creation Date</th>
          <th scope="col">Model</th>
          <th scope="col">Brand</th>
          <th scope="col">Size</th>
          <th scope="col">Category</th>
          <th scope="col">Condition</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $db = new PDO('sqlite:./database/LTW.db');
        session_start();
            if(isset($_SESSION['User'])==false){
                header("Location: /index.php");
                exit;
            };
        $queue = $db->prepare("SELECT Users.isAdmin as admin
            FROM Users
            WHERE Users.username=:userr");
            $queue->execute(['userr'=>$username]);
            $id_row = $queue->fetch();
        
            $id = $id_row['admin'];

          if($id==0){
            header("Location: /index.php");
            exit;
          }
        $query = "
        SELECT 
            Product.id AS id,
            Product.title AS title,
            Users.name AS creator,
            Product.price AS price,
            Product.isBought AS status,
            Product.creationDate AS date,
            Product.model AS model,
            Product.brand AS brand,
            Size.name AS size,
            Category.name AS category,
            Condition.name AS condition
        FROM 
            Product
        INNER JOIN 
            Users ON Product.creator_id = Users.id
        INNER JOIN 
            Size ON Product.size_id = Size.id
        INNER JOIN 
            Category ON Product.category_id = Category.id
        INNER JOIN 
            Condition ON Product.condition_id = Condition.id;
        ";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $productsInfo = $stmt->fetchAll();
        foreach($productsInfo as $product){ ?>
          <tr>
            <td scope="row"><p class="row-info row-title"><?php echo $product['title']?></p></td>
            <td><p class="row-info"><?php echo $product['creator']?></p></td>
            <td><p class="row-info row-price"><?php echo $product['price']?></p></td>
            <td><p class="row-info row-status"><?php if($product['status']==0){ echo "Available";}else{echo "Not Available";};?></p></td>
            <td><p class="row-info">
              <?php 
              $prod = $product['date'];
              $prodTrim = explode(" ", $prod);
              echo $prodTrim[0]?>
            </p></td>
            <td><p class="row-info row-model"><?php echo $product['model']?></p></td>
            <td><p class="row-info row-brand"><?php echo $product['brand']?></p></td>
            <td><p class="row-info"><?php echo $product['size']?></p></td>
            <td><p class="row-info"><?php echo $product['category']?></p></td>
            <td><p class="row-info"><?php echo $product['condition']?></p></td>
            <td> 
              <button class="delete-button" onclick="deleteProductOnClick(this)" data-id="<?php echo $product['id']; ?>" title="Delete Product"><i class="ri-prohibited-2-line"></i></button>
              <button class="edit-button" onclick="EditButtonClick(this)" data-id="<?php echo $product['id']; ?>" title="Edit Product"><i class="ri-edit-line"></i></button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <!-- Edit Product Modal -->
    <div id="edit-modal" class="modal">
      <div class="modal-content-edit">
        <span id="closeEditModal" class="close" onclick="CloseModal()">&times;</span>
        <h2>Edit Product</h2>
        <!-- Editing fields for product details -->
        <input type="text" id="editTitle">
        <input type="number" id="editPrice">
        <input type="number" id="editStatus">
        <input type="text" id="editModel">
        <input type="text" id="editBrand">

        <button id="submitEditButton" onclick="SaveChanges()">Save Changes</button>
      </div>
    </div>

  </body>       
</html>