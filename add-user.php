<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();
?>
<?php include "./components/header.php" ?>
<form action="users.php" method="post">
    <div class="title">Add User</div>
    <div class="upper">
        <div class="lower">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="lower">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="password">Password</label>
            <input type="text" name="password" id="password" required>
        </div>
        <div class="lower">
            <label for="category">Category</label>
            <select name="category" id="category" required>
                <option value="" selected disabled>Select Category</option>
                <?php
                $conn=new Conn();
                $result=$conn->read("category");
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Add">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>