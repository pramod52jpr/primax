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
<form action="documents.php?proId=<?php echo $_GET['proId'] ?>" method="post" enctype="multipart/form-data">
    <div class="title">Add Document</div>
    <div class="upper">
        <div class="lower">
            <label for="docSpec">Spec</label>
            <input type="text" name="docSpec" id="docSpec" required>
        </div>
        <div class="lower">
            <label for="docDesc">Desc.</label>
            <input type="text" name="docDesc" id="docDesc" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="doc_po_code">P.O. Code</label>
            <input type="text" name="doc_po_code" id="doc_po_code" required>
        </div>
        <div class="lower">
            <label for="docFile">Doc. File</label>
            <input type="file" name="docFile" id="docFile" accept=".xlsx,.xls,.pdf" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="doc_supplier">Supplier</label>
            <select name="doc_supplier" id="doc_supplier" required>
                <option value="" selected disabled>Select Supplier</option>
                <?php
                $supplierResult=$conn->read("users","*","`category`!=1");
                if($supplierResult->num_rows>0){
                    while($supplierRow=$supplierResult->fetch_assoc()){
                        ?>
                        <option value="<?php echo $supplierRow['user_id'] ?>"><?php echo $supplierRow['name'] ?></option>
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
        <input type="submit" value="Save">
        <a href="javascript:history.go(-1)">Cancel</a>
    </div>
</form>
<?php include "./components/footer.php" ?>