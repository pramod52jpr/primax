<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();
if(isset($_GET['id']) and !empty($_GET['id'])){
    $id=$_GET['id'];
    $result=$conn->read("users","`name`,`username`,`password`,`category`","`user_id`=$id");
    if($result->num_rows>0){
        $dataRow=$result->fetch_assoc();
    }
}
?>
<?php include "./components/header.php" ?>
<form action="users.php" method="post">
    <div class="title">Update User</div>
    <input type="hidden" name="updatedId" value="<?php echo isset($dataRow)?$id:'' ?>">
    <div class="upper">
        <div class="lower">
            <label for="updatedName">Name</label>
            <input type="text" name="updatedName" id="updatedName" value="<?php echo isset($dataRow)?$dataRow['name']:'' ?>" required>
        </div>
        <div class="lower">
            <label for="updatedUsername">Username</label>
            <input type="text" name="updatedUsername" id="updatedUsername" value="<?php echo isset($dataRow)?$dataRow['username']:'' ?>" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedPassword">Password</label>
            <input type="text" name="updatedPassword" id="updatedPassword" value="<?php echo isset($dataRow)?hex2bin($dataRow['password']):'' ?>" required>
        </div>
        <div class="lower">
            <label for="updatedCategory">Category</label>
            <select name="updatedCategory" id="updatedCategory" required>
                <option value="" selected disabled>Select Category</option>
                <?php
                $conn=new Conn();
                $result=$conn->read("category");
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        if(isset($row) and $dataRow['category']==$row['cat_id']){
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                        ?>
                        <option value="<?php echo $row['cat_id'] ?>" <?php echo $selected ?>><?php echo $row['cat_name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Update">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>