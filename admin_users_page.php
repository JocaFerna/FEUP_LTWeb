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
        
        <?/*
            session_start();
            if(isset($_SESSION['User'])==false){
                header("Location: /index.php");
                exit;
            }; */
        ?>
        <script src="javascript/administrate_user.js"></script>
        <table>
            <caption>User List</caption>
            <thead>
              <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
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
                    $stmt = $db->prepare('SELECT username, email, isAdmin, isBanned FROM Users
                    ');
                    $stmt->execute();
                    $userinfos = $stmt->fetchAll();
                    foreach($userinfos as $info){
                        ?>
                        <tr>
                            <td scope="row"><p class="row-info"><?php echo $info['username']?></p></td>
                            <td><p class="row-info"><?php echo $info['email']?></p></td>
                            <td class="status"><p class="row-info"><?php 
                            if($info['isBanned']){
                                echo 'Banned';
                            }
                            else{
                                if($info['isAdmin']){
                                    echo 'Admin';
                                } 
                                else{
                                    echo 'User';
                                }
                            }
                            ?></p></td>
                            <td class="buttons"> 
                            <?php
                                if(!$info['isBanned']){ ?>
                                    <button class="ban-button" onclick="banUserOnClick(this)" title="Ban User"><i class="ri-prohibited-2-line"></i></button> 
                                <?php
                                    if($info['isAdmin']){
                                    ?><button class="demote-button admin-button" onclick="administrateUserOnClick(this)" title="Demote User"><i class="ri-arrow-down-circle-line"></i></button> <?php
                                    }
                                    else{?>
                                    <button class="promote-button admin-button" onclick="administrateUserOnClick(this)" title="Promote User"><i class="ri-arrow-up-circle-line"></i></button> 
                                <?php }
                                    } ?>
                            </td>
                        </tr>
                        <?php
                    }
               ?> 
            </tbody>
        </table>
    </body>
</html>