<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/nav_menus.css">
    <title>Admin Page</title>
</head>
<body>
<script src="javascript/dynamic_load_admin.js"></script>
<script src="javascript/administrate_user.js"></script>
<script src="javascript/administrate_product.js"></script>
<script src="javascript/administrate_categories.js"></script>
<!-- Top bar with navigation links -->
<div class="header">
    <?php include "header.php"; ?>
</div>

<div class="content">
    <div class="table-bar">
        <a href="#" id="users-tab">Users</a>
        <a href="#" id="products-tab">Products</a>
        <a href="#" id="categories-tab">Categories</a>
    </div>
    <div id="content-container"></div>
</div>  