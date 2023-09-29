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
    $result=$conn->read("projects","`pro_name`,`pro_desc`,`pro_po_no`,`pro_po_date`","`pro_id`=$id");
    if($result->num_rows>0){
        $dataRow=$result->fetch_assoc();
    }
}
?>
<?php include "./components/header.php" ?>
<form action="projects.php" method="post" enctype="multipart/form-data">
    <div class="title">Update Project</div>
    <input type="hidden" name="updatedId" value="<?php echo isset($dataRow)?$id:'' ?>">
    <div class="upper">
        <div class="lower">
            <label for="updatedProName">Name</label>
            <input type="text" name="updatedProName" id="updatedProName" value="<?php echo isset($dataRow)?$dataRow['pro_name']:'' ?>" required>
        </div>
        <div class="lower">
            <label for="updatedProDesc">Desc.</label>
            <input type="text" name="updatedProDesc" id="updatedProDesc" value="<?php echo isset($dataRow)?$dataRow['pro_desc']:'' ?>" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedPoNo">P.O. No.</label>
            <input type="text" name="updatedPoNo" id="updatedPoNo" value="<?php echo isset($dataRow)?$dataRow['pro_po_no']:'' ?>" required>
        </div>
        <div class="lower">
            <label for="updatedPoDate">P.O. Date</label>
            <input type="date" name="updatedPoDate" id="updatedPoDate" value="<?php echo isset($dataRow)?$dataRow['pro_po_date']:'' ?>" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedPoFile">P.O. File</label>
            <input type="file" name="updatedPoFile" id="updatedPoFile" accept=".xlsx,.xls,.pdf">
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