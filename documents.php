<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();
// insert Document

if(isset($_POST['docSpec']) and isset($_GET['proId'])){
    extract($_POST);
    extract($_FILES['docFile']);
    $data=[
        "project_id"=>$_GET['proId'],
        "doc_spec"=>$docSpec,
        "doc_desc"=>$docDesc,
        "doc_po_code"=>$doc_po_code,
        "doc_po_file"=>$name,
        "doc_supplier"=>$doc_supplier
    ];
    $readData=$conn->read("documents","`doc_spec`","`doc_spec`='$docSpec'");
    if($readData->num_rows>0){
        echo "<script>alert('Document Already Added')</script>";
    }else{
        if($size < 10485760){
            $result=$conn->insert("documents",$data);
            if($result){
                move_uploaded_file($tmp_name,"./pofiles/document-files/$name");
                echo "<script>alert('Document Added Successfully')</script>";
            }else{
                echo "<script>alert('Document Addition Failed')</script>";
            }
        }else{
            echo "<script>alert('File Size must be less than 2MB')</script>";
        }
    }
}

// update projects

if(isset($_POST['updateDocSpec']) and isset($_POST['updatedProId'])){
    extract($_POST);
    if(empty($_FILES['updateDocFile']['name'])){
        $data=[
            "doc_spec"=>$updateDocSpec,
            "doc_desc"=>$updateDocDesc,
            "doc_po_code"=>$update_doc_po_code,
            "doc_supplier"=>$update_doc_supplier,
        ];
    }else{
        extract($_FILES['updateDocFile']);
        $data=[
            "doc_spec"=>$updateDocSpec,
            "doc_desc"=>$updateDocDesc,
            "doc_po_code"=>$update_doc_po_code,
            "doc_supplier"=>$update_doc_supplier,
            "doc_po_file"=>$name,
        ];
    }
    $readData=$conn->read("documents","`doc_spec`","`doc_spec`='$updateDocSpec' and `doc_id`!=$updatedProId");
    if($readData->num_rows>0){
        echo "<script>alert('Project Name Already Added')</script>";
    }else{
        if(!empty($_FILES['updateDocFile']['name'])){
            if($size < 10485760){
                $result=$conn->update("documents",$data,"`doc_id`=$updatedProId");
                if($result){
                    move_uploaded_file($tmp_name,"./pofiles/document-files/$name");
                    echo "<script>alert('Document Updated Successfully')</script>";
                }else{
                    echo "<script>alert('Document Updation Failed')</script>";
                }
            }else{
                echo "<script>alert('File Size must be less than 10MB')</script>";
            }
        }else{
            $result=$conn->update("documents",$data,"`doc_id`=$updatedProId");
            if($result){
                echo "<script>alert('Document Updated Successfully')</script>";
            }else{
                echo "<script>alert('Document Updation Failed')</script>";
            }
        }
    }
}

// delete projects

if(isset($_GET['del-id']) and !empty($_GET['del-id']) and intval($_GET['del-id'])!=0){
    $delId=$_GET['del-id'];
    $readData=$conn->read("documents","`doc_spec`","`doc_id`=$delId");
    if($readData->num_rows>0){
        $result=$conn->delete("documents","`doc_id`=$delId");
        if($result){
            echo "<script>alert('Documents Deleted Successfully')</script>";
        }else{
            echo "<script>alert('Documents Deletion Failed')</script>";
        }
    }else{
        echo "<script>alert('No Documents Exist')</script>";
    }
}
?>
<?php include "./components/header.php" ?>
<div class="usersPage">
    <h2>Documents</h2>
    <div class="crudBtn">
    <?php
    if($userRow['category']==1){
        ?>
            <?php
            if(isset($_GET['proId'])){
                $addproject="add-document.php?proId=$_GET[proId]";
            }else{
                $addproject="#";
            }
            ?>
            <a href="<?php echo $addproject ?>">Add</a>
            <?php
    }
    ?>
        <input type="search" name="search" onkeyup="searchDocument()" placeholder="Search" id="searchDoc">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <thead>
                <tr>
                    <th>Spec</th>
                    <th>Technical Specification Desc.</th>
                    <th>P.O. Code</th>
                    <th>No. of docs assigned to P.O.</th>
                    <?php
                    if($userRow['category']==1){
                        ?>
                        <th>Actions</th>
                        <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
            <?php
            $conn=new Conn();
            $result=$conn->read("documents","*","`project_id`=$_GET[proId]");
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $numOfDocs=$conn->read("drawings","*","`document_id`=$row[doc_id]");
                    ?>
                    <tr class="documentData">
                        <td><?php echo $row['doc_spec'] ?></td>
                        <td><?php echo $row['doc_desc'] ?></td>
                        <td><a href="./pofiles/document-files/<?php echo $row['doc_po_file'] ?>" style="text-decoration: none;" download><?php echo $row['doc_po_code'] ?></a></td>
                        <td><a href="drawings.php?proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $row['doc_id'] ?>" style="text-decoration: none;"><?php echo $numOfDocs->num_rows ?></a></td>
                        <?php
                        if($userRow['category']==1){
                            ?>
                            <td>
                                <a href="update-document.php?id=<?php echo $row['doc_id'] ?>&proId=<?php echo $_GET['proId'] ?>"><i class="fa-solid fa-pen"></i></a>
                                <a href="?del-id=<?php echo $row['doc_id'] ?>&proId=<?php echo $_GET['proId'] ?>"><i class="fa-solid fa-trash"></i></a>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr align="center"><td colspan="40">No documents exist yet</td></tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "./components/footer.php" ?>