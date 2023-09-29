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
<form action="projects.php" method="post" enctype="multipart/form-data">
    <div class="title">Add Project</div>
    <div class="upper">
        <div class="lower">
            <label for="proName">Name</label>
            <input type="text" name="proName" id="proName" required>
        </div>
        <div class="lower">
            <label for="proDesc">Desc.</label>
            <input type="text" name="proDesc" id="proDesc" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="poNo">P.O. No.</label>
            <input type="text" name="poNo" id="poNo" required>
        </div>
        <div class="lower">
            <label for="poDate">P.O. Date</label>
            <input type="date" name="poDate" id="poDate" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="poFile">P.O. File</label>
            <input type="file" name="poFile" id="poFile" accept=".xlsx,.xls,.pdf" required>
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