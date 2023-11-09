<?php include "conn.php" ?>
<?php
$date=date("Y-m-d");
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();

// insert Document

if(isset($_POST['drawNumber']) and isset($_GET['docId'])){
    extract($_POST);
    extract($_FILES['drawFile']);
    $data=[
        "document_id"=>$_GET['docId'],
        "draw_number"=>$drawNumber,
        "draw_title"=>$drawTitle
    ];
    $readData=$conn->read("drawings","`draw_number`","`draw_number`='$drawNumber'");
    if($readData->num_rows>0){
        echo "<script>alert('Drawing Already Added')</script>";
    }else{
        if($size < 104857600){
            $result=$conn->insert("drawings",$data);
            if($result){
                $drawData=$conn->read("drawings","*","`draw_number`='$drawNumber'");
                if($drawData->num_rows>0){
                    $drawDataRow=$drawData->fetch_assoc();
                    $drawingFileData=[
                        "drawing_id"=>$drawDataRow['draw_id'],
                        "drawing_file"=>$name,
                        "date"=>$date
                    ];
                    $insertDrawFile=$conn->insert("revision_drawings",$drawingFileData);
                    if($insertDrawFile){
                        move_uploaded_file($tmp_name,"./pofiles/drawing-files/$name");
                        echo "<script>alert('Drawing Added Successfully')</script>";
                    }
                }
            }else{
                echo "<script>alert('Drawing Addition Failed')</script>";
            }
        }else{
            echo "<script>alert('File Size must be less than 100MB')</script>";
        }
    }
}

// update projects

if(isset($_POST['updateDrawNumber']) and isset($_POST['updateDrawId'])){
    extract($_POST);
    $data=[
        "draw_number"=>$updateDrawNumber,
        "draw_title"=>$updateDrawTitle,
    ];
    $readData=$conn->read("drawings","`draw_number`","`draw_number`='$updateDrawNumber' and `draw_id`!=$updateDrawId");
    if($readData->num_rows>0){
        echo "<script>alert('Drawing Number Already Exists')</script>";
    }else{
        $result=$conn->update("drawings",$data,"`draw_id`=$updateDrawId");
        if($result){
            echo "<script>alert('Drawing Updated Successfully')</script>";
        }else{
            echo "<script>alert('Drawing Updation Failed')</script>";
        }
    }
}

// delete projects

if(isset($_GET['del-id']) and !empty($_GET['del-id']) and intval($_GET['del-id'])!=0){
    $delId=$_GET['del-id'];
    $readData=$conn->read("drawings","`draw_number`","`draw_id`=$delId");
    if($readData->num_rows>0){
        $result=$conn->delete("drawings","`draw_id`=$delId");
        if($result){
            echo "<script>alert('Drawing Deleted Successfully')</script>";
        }else{
            echo "<script>alert('Drawing Deletion Failed')</script>";
        }
    }else{
        echo "<script>alert('No Drawing Exist')</script>";
    }
}
?>
<?php
if(isset($_POST['checkedData'])){
    $zip = new ZipArchive();
    $docResult=$conn->read("documents","`doc_spec`","`doc_id`=$_GET[docId]");
    $docData=$docResult->fetch_assoc();
    $docName=$docData['doc_spec'];
    session_start();
    $zipFileName = "./pofiles/drawing-files/$docName-$_SESSION[user_id].zip";

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $checkedData=$_POST['checkedData'];
        $over="";
        foreach($checkedData as $value){
            $zip->addFile("./pofiles/drawing-files/".$value,$value);
        }
        $zip->close();
    }
    session_abort();
}

?>
<?php include "./components/header.php" ?>
<div class="usersPage">
    <form action="" method="post" style="overflow: visible;margin: 0;background-color: transparent;padding:0;border-radius: 0;">
        <div class="goback" title="Go Back">
            <a href="documents.php?proId=<?php echo $_GET['proId'] ?>"><i class="fa-solid fa-arrow-left" style="color: #ffffff;"></i></a>
        </div>
        <h2>Drawings</h2>
        <div class="crudBtn">
        <?php
        if($userRow['category']==1){
            ?>
                <?php
                if(isset($_GET['docId']) and isset($_GET['proId'])){
                    $addproject="add-drawing.php?docId=$_GET[docId]&proId=$_GET[proId]";
                }else{
                    $addproject="#";
                }
                ?>
                <a href="<?php echo $addproject ?>">Add</a>
                <?php
            }
        ?>
        <div class="options">
            <button type="submit" id="submitBtn" title="Load Selected Files" style="font-size:15px;background-color:rgb(0,150,255);color: white;padding: 10px 20px;font-weight: bold;border-radius: 5px;outline:none;border:none;cursor:pointer;"><i class="fa-solid fa-upload"></i></button>
            <?php
            if(!isset($_POST['checkedData'])){
                $downloadBtnStyle="background-color:grey;pointer-events:none;";
            }else{
                $downloadBtnStyle="background-color:green;";
            }
            ?>
            <a href="<?php echo $zipFileName ?>" id="downloadAll" title="Download file" style="<?php echo $downloadBtnStyle ?>" download><i class="fa-solid fa-download"></i></a>
            <input type="search" name="search" onkeyup="searchDrawing()" placeholder="Search" id="searchDraw" style="width:auto;">
        </div>
        <?php
        session_abort();
        ?>
        </div>
        <div class="tableContainer">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="checkAll()" name="checkedAll" id="checkedAll" style="padding: 0;font-size: auto;border-radius: 0;border: 0;outline: none;width: auto;"> Select</th>
                        <th>Number</th>
                        <th>Assigned Rev.</th>
                        <th>Title</th>
                        <th>Last Action Date</th>
                        <th>File</th>
                        <th>History</th>
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
                $result=$conn->read("drawings","*","`document_id`=$_GET[docId]");
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        $readHistory=$conn->read("revision_drawings","*","`drawing_id`=$row[draw_id]",null,null,null,"`revision_id` desc");
                        $readHistoryData=$readHistory->fetch_assoc();
                        ?>
                        <tr class="drawingData">
                            <td><input type="checkbox" onclick="checkedSpecific()" name="checkedData[]" value="<?php echo $readHistoryData['drawing_file'] ?>" class="check" style="padding: 0;font-size: auto;border-radius: 0;border: 0;outline: none;width: auto;"></td>
                            <td><?php echo $row['draw_number'] ?></td>
                            <td><?php echo $readHistory->num_rows-1 ?></td>
                            <td><?php echo $row['draw_title'] ?></td>
                            <td><?php echo $readHistoryData['date'] ?></td>
                            <td><a href="./pofiles/drawing-files/<?php echo $readHistoryData['drawing_file'] ?>" style="text-decoration: none;" download><i class="fa-solid fa-download"></i></a></td>
                            <td><a href="history.php?drawId=<?php echo $row['draw_id'] ?>&proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $_GET['docId'] ?>" style="text-decoration: none;"><i class="fa-solid fa-history"></i></a></td>
                            <?php
                            if($userRow['category']==1){
                                ?>
                                <td>
                                    <a href="update-drawing.php?id=<?php echo $row['draw_id'] ?>&proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $_GET['docId'] ?>"><i class="fa-solid fa-pen"></i></a>
                                    <a href="?del-id=<?php echo $row['draw_id'] ?>&proId=<?php echo $_GET['proId'] ?>&docId=<?php echo $_GET['docId'] ?>"><i class="fa-solid fa-trash"></i></a>
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
    </form>
</div>
<?php include "./components/footer.php" ?>