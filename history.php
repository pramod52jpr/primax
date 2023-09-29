<?php include "conn.php" ?>
<?php
$date=date("Y-m-d");
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();

// insert Drawing File

if(isset($_FILES['addDrawFile']) and isset($_GET['drawId'])){
    extract($_FILES['addDrawFile']);
    $data=[
        "drawing_id"=>$_GET['drawId'],
        "drawing_file"=>$name,
        "date"=>$date
    ];
    if($size < 10485760){
        $result=$conn->insert("revision_drawings",$data);
        if($result){
            move_uploaded_file($tmp_name,"./pofiles/drawing-files/$name");
            echo "<script>alert('File Updated Successfully')</script>";
        }else{
            echo "<script>alert('Drawing Updation Failed')</script>";
        }
    }else{
        echo "<script>alert('File Size must be less than 10MB')</script>";
    }
}
?>
<?php include "./components/header.php" ?>
<div class="usersPage">
    <h2>History</h2>
    <?php
    if($userRow['category']==1){
        ?>
        <div class="crudBtn">
            <?php
            if(isset($_GET['docId']) and isset($_GET['proId'])){
                $addproject="add-history.php?drawId=$_GET[drawId]&docId=$_GET[docId]&proId=$_GET[proId]";
            }else{
                $addproject="#";
            }
            ?>
            <a href="<?php echo $addproject ?>">Add</a>
        </div>
        <?php
    }
    ?>
    <div class="tableContainer">
        <table cellspacing="0">
            <thead>
                <tr>
                    <th>Rev.</th>
                    <th>File Name</th>
                    <th>File</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $conn=new Conn();
            $result=$conn->read("revision_drawings","*","`drawing_id`=$_GET[drawId]",null,null,null,"`revision_id` desc");
            if($result->num_rows>0){
                $rev=$result->num_rows-1;
                while($row=$result->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $rev ?></td>
                        <td><?php echo $row['drawing_file'] ?></td>
                        <td><a href="./pofiles/drawing-files/<?php echo $row['drawing_file'] ?>" style="text-decoration: none;" download><i class="fa-solid fa-download"></i></a></td>
                        <td><?php echo $row['date'] ?></td>
                    </tr>
                    <?php
                    $rev--;
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