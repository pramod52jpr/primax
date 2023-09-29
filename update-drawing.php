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
    $result=$conn->read("drawings","*","`draw_id`=$id");
    if($result->num_rows>0){
        $dataRow=$result->fetch_assoc();
    }
}
?>
<?php include "./components/header.php" ?>
<form action="drawings.php?proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $_GET['docId'] ?>" method="post" enctype="multipart/form-data">
    <div class="title">Update Drawing</div>
    <input type="hidden" name="updateDrawId" value="<?php echo isset($dataRow)?$id:'' ?>">
    <div class="upper">
        <div class="lower">
            <label for="updateDrawNumber">Number</label>
            <input type="text" name="updateDrawNumber" id="updateDrawNumber" value="<?php echo isset($dataRow)?$dataRow['draw_number']:'' ?>" required>
        </div>
        <div class="lower">
            <label for="updateDrawTitle">Title</label>
            <input type="text" name="updateDrawTitle" id="updateDrawTitle" value="<?php echo isset($dataRow)?$dataRow['draw_title']:'' ?>" required>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Update">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>