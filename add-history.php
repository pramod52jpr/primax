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
<form action="history.php?drawId=<?php echo $_GET['drawId'] ?>&proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $_GET['docId'] ?>" method="post" enctype="multipart/form-data">
    <div class="title">Add Drawing File</div>
    <div class="upper">
        <div class="lower">
            <label for="addDrawFile">File</label>
            <input type="file" style="width: 100%;" name="addDrawFile" id="addDrawFile" accept=".xlsx,.xls,.pdf,.zip" required>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Add">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>