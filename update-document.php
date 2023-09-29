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
    $result=$conn->read("documents","`doc_spec`,`doc_desc`,`doc_po_code`,`doc_supplier`","`doc_id`=$id");
    if($result->num_rows>0){
        $dataRow=$result->fetch_assoc();
    }
}
?>
<?php include "./components/header.php" ?>
<form action="documents.php?proId=<?php echo $_GET['proId'] ?>" method="post" enctype="multipart/form-data">
    <div class="title">Update Document</div>
    <input type="hidden" name="updatedProId" value="<?php echo isset($dataRow)?$id:'' ?>">
    <div class="upper">
        <div class="lower">
            <label for="updateDocSpec">Spec</label>
            <input type="text" name="updateDocSpec" id="updateDocSpec" value="<?php echo isset($dataRow)?$dataRow['doc_spec']:'' ?>" required>
        </div>
        <div class="lower">
            <label for="updateDocDesc">Desc.</label>
            <input type="text" name="updateDocDesc" id="updateDocDesc" value="<?php echo isset($dataRow)?$dataRow['doc_desc']:'' ?>" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="update_doc_po_code">P.O. Code</label>
            <input type="text" name="update_doc_po_code" id="update_doc_po_code" value="<?php echo isset($dataRow)?$dataRow['doc_po_code']:'' ?>" required>
        </div>
        <div class="lower">
            <label for="updateDocFile">Doc. File</label>
            <input type="file" name="updateDocFile" id="updateDocFile" accept=".xlsx,.xls,.pdf">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="update_doc_supplier">Supplier</label>
            <select name="update_doc_supplier" id="update_doc_supplier" required>
                <option value="" selected disabled>Select Supplier</option>
                <?php
                $supplierResult=$conn->read("users","*","`category`!=1");
                if($supplierResult->num_rows>0){
                    while($supplierRow=$supplierResult->fetch_assoc()){
                        if($supplierRow['user_id']==$dataRow['doc_supplier']){
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                        ?>
                        <option value="<?php echo $supplierRow['user_id'] ?>" <?php echo $selected ?>><?php echo $supplierRow['name'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="lower">
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Update">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>