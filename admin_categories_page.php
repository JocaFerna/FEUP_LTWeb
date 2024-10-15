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
    <body >
        <script src="javascript/administrate_categories.js"></script>
        <table> 
            <?php $db = new PDO('sqlite:./database/LTW.db');?>
            <caption>Categories</caption>
            <thead>
                <tr>
                <th scope="col">Category</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="category-body">
            <?php 
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
                    id, name
                FROM
                    Category
                ";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $categories = $stmt->fetchAll();
                foreach($categories as $category){
                ?>
                <tr>
                    <td scope="row"><class="row-info"><?php echo($category['name']);?></td>
                    <td id="button-column"><button id="category" onclick="deleteCategoryOnClick(this)" data-id="<?php echo $category['id']; ?>" class="delete-button" title="Delete Category"><i class="ri-prohibited-2-line"></i></button></td>
                    <?php } ?>
                </tr>    
                <tr>
                    <td scope="row" id="create-row"><button id="category" class="add-button" title="Add Category" onclick="addCategory(this)"><i class="ri-add-fill"></i></button><p>Add New Category</p></td>
                    <td></td>  
                </tr>
            </tbody>
        </table>
        <table>
            <caption>Sizes</caption>
            <thead>
                <tr>
                <th scope="col">Size</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="size-body">
                <?php 
                $query = "
                SELECT
                    id, name
                FROM
                    Size
                ";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $sizes = $stmt->fetchAll();
                foreach($sizes as $size){
                ?>
                <tr>
                    <td scope="row"><class="row-info"><?php echo($size['name']);?></td>
                    <td id="button-column"><button id="size" onclick="deleteCategoryOnClick(this)" data-id="<?php echo $size['id'];?>" class="delete-button" title="Delete Size"><i class="ri-prohibited-2-line"></i></button></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td scope="row" id="create-row"><button id="size" class="add-button" title="Add Category" onclick="addCategory(this)"><i class="ri-add-fill"></i></button><p>Add New Size</p></td> 
                    <td></td> 
                </tr>
            </tbody>
        </table>
        <table>
            <caption>Conditions</caption>
            <thead>
                <tr>
                <th scope="col">Category</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="condition-body">
                <?php 
                $query = "
                    SELECT 
                        id, name 
                    From 
                        Condition
                    ";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $conditions = $stmt->fetchAll();
                foreach($conditions as $condition){
                ?>
                <tr>
                    <td scope="row"><class="row-info"><?php echo($condition['name']);?></td>
                    <td id="button-column"><button id="condition" onclick="deleteCategoryOnClick(this)" data-id="<?php echo $condition['id'];?>" class="delete-button" title="Delete Condition"><i class="ri-prohibited-2-line"></i></button></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td scope="row" id="create-row"><button id="condition" class="add-button" title="Add Category" onclick="addCategory(this)"><i class="ri-add-fill"></i></button><p>Add New Condition</p></td>
                    <td></td> 
                </tr>
            </tbody>
        </table>

        <!-- Modals -->
        <div id="modal-category" class="modal">
            <div class="modal-content">
                <span id="closeCategoryModal" class="close" onclick="closeCategoryModal()">&times;</span>
                <h2>Add New Category</h2>
                <input type="text" id="categoryName" placeholder="Enter category name">
                <button id="saveCategoryButton" onclick="saveCategoryButton()">Save</button>
            </div>
        </div>

        <div id="modal-size" class="modal">
            <div class="modal-content">
                <span id="closeSizeModal" class="close" onclick="closeSizeModal()">&times;</span>
                <h2>Add New Size</h2>
                <input type="text" id="sizeName" placeholder="Enter size name">
                <button id="saveSizeButton" onclick="saveSizeButton()">Save</button>
            </div>
        </div>

        <div id="modal-condition" class="modal">
            <div class="modal-content">
                <span id="closeConditionModal" class="close" onclick="closeConditionModal()">&times;</span>
                <h2>Add New Condition</h2>
                <input type="text" id="conditionName" placeholder="Enter condition name">
                <button id="saveConditionButton" onclick="saveConditionButton()">Save</button>
            </div>
        </div>

    </body>
</html>