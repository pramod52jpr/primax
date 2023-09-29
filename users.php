<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();

// add User

if(isset($_POST['username']) and isset($_POST['password'])){
    extract($_POST);
    $data=[
        "name"=>$name,
        "username"=>$username,
        "password"=>bin2hex($password),
        "category"=>$category
    ];
    $readData=$conn->read("users","`username`","`username`='$username'");
    if($readData->num_rows>0){
        echo "<script>alert('This User is already Registered')</script>";
    }else{
        $result=$conn->insert("users",$data);
        if($result){
            echo "<script>alert('User Added Successfully')</script>";
        }else{
            echo "<script>alert('User Addition Failed')</script>";
        }
    }
}

// update user

if(isset($_POST['updatedUsername']) and isset($_POST['updatedPassword'])){
    extract($_POST);
    $data=[
        "name"=>$updatedName,
        "username"=>$updatedUsername,
        "password"=>bin2hex($updatedPassword),
        "category"=>$updatedCategory
    ];
    $readData=$conn->read("users","`username`","`username`='$updatedUsername' and (`user_id`!=$updatedId)");
    if($readData->num_rows>0){
        echo "<script>alert('This User is already Registered')</script>";
    }else{
        $result=$conn->update("users",$data,"`user_id`=$updatedId");
        if($result){
            echo "<script>alert('User Updated Successfully')</script>";
        }else{
            
            echo "<script>alert('User Updation Failed')</script>";
        }
    }
}

// delete user

if(isset($_GET['del-id']) and !empty($_GET['del-id']) and intval($_GET['del-id'])!=0){
    $delId=$_GET['del-id'];
    $readData=$conn->read("users","`username`","`user_id`=$delId");
    if($readData->num_rows>0){
        $result=$conn->delete("users","`user_id`=$delId");
        if($result){
            echo "<script>alert('User Deleted Successfully')</script>";
        }else{
            echo "<script>alert('User Deletion Failed')</script>";
        }
    }else{
        echo "<script>alert('No User Exist')</script>";
    }
}

// user active or deactive

if(isset($_GET['id']) and isset($_GET['active'])){
    extract($_GET);
    $data=[
        "active"=>$active
    ];
    if(!empty($id)){
        $readData=$conn->read("users","name","`user_id`=$id");
        if($readData->num_rows>0){
            if($active==0){
                $result=$conn->update("users",$data,"`user_id`=$id");
                if($result){
                    echo "<script>alert('User Deactivated Successfully')</script>";
                }
            }else if($active==1){
                $result=$conn->update("users",$data,"`user_id`=$id");
                if($result){
                    echo "<script>alert('User Activated Successfully')</script>";
                }
            }
        }
    }
}
?>
<?php include "./components/header.php" ?>
<div class="usersPage">
    <h2>Users</h2>
    <div class="crudBtn">
        <a href="add-user.php">Add</a>
        <input type="search" name="search" onkeyup="searchAllUsers()" placeholder="Search" id="searchAllUsers">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>username</th>
                    <th>Category</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $conn=new Conn();
            $result=$conn->read("users","*",null,"join category on users.`category`=category.`cat_id`");
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    ?>
                    <tr class="allUsersData">
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['cat_name'] ?></td>
                        <td>
                            <?php
                            if($row['cat_id']==1){
                                $disabled="style='pointer-events:none;color:grey'";
                            }else{
                                $disabled="";
                            }
                            if($row['active']==1){
                                ?>
                                <a href="users.php?id=<?php echo $row['user_id'] ?>&active=0" <?php echo $disabled ?> style="color: blue;"><i class="fa-solid fa-toggle-on" style="font-size:25px"></i></a>
                                <?php
                            }else{
                                ?>
                                <a href="users.php?id=<?php echo $row['user_id'] ?>&active=1" <?php echo $disabled ?> style="color: blue;"><i class="fa-solid fa-toggle-off" style="font-size:25px"></i></a>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <a href="update-user.php?id=<?php echo $row['user_id'] ?>"><i class="fa-solid fa-pen"></i></a>
                            <a href="?del-id=<?php echo $row['user_id'] ?>" <?php echo $disabled ?>><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr align="center"><td colspan="40">No User Exist</td></tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "./components/footer.php" ?>