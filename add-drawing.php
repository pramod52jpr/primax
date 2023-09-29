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
<form action="drawings.php?proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $_GET['docId'] ?>" method="post" enctype="multipart/form-data">
    <div class="title">Add Drawing</div>
    <div class="upper">
        <div class="lower">
            <label for="drawNumber">Number</label>
            <input type="text" name="drawNumber" id="drawNumber" required>
        </div>
        <div class="lower">
            <label for="drawTitle">Title</label>
            <input type="text" name="drawTitle" id="drawTitle" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="drawFile">Doc. File</label>
            <input type="file" name="drawFile" id="drawFile" accept=".xlsx,.xls,.pdf" required>
        </div>
        <div class="lower">
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Save">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>