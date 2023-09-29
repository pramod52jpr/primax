<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
$userId=$_SESSION['user_id'];
$result=$conn->read("users","*","`user_id`='$userId'");
if($result->num_rows>0){
    $row=$result->fetch_assoc();
}
session_abort();
?>
<?php include "./components/header.php" ?>
<form action="dashboard.php" method="post">
    <div class="title">My Profile</div>
    <div class="upper">
        <div class="lower">
            <label for="profileName">Name</label>
            <input type="text" name="profileName" id="profileName" value="<?php echo $row['name'] ?>" required>
        </div>
        <div class="lower">
            <label for="profileUsername">Username</label>
            <input type="text" name="profileUsername" id="profileUsername" value="<?php echo $row['username'] ?>" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="profilePassword">Password</label>
            <input type="text" name="profilePassword" id="profilePassword" value="<?php echo hex2bin($row['password']) ?>" required>
        </div>
        <div class="lower">
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Add">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>