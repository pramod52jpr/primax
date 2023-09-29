<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();

// insert project

if(isset($_POST['proName']) and isset($_FILES['poFile'])){
    extract($_POST);
    extract($_FILES['poFile']);
    $data=[
        "pro_name"=>$proName,
        "pro_desc"=>$proDesc,
        "pro_po_no"=>$poNo,
        "pro_po_date"=>$poDate,
        "pro_file"=>$name
    ];
    $readData=$conn->read("projects","`pro_name`","`pro_name`='$proName'");
    if($readData->num_rows>0){
        echo "<script>alert('Project Already Added')</script>";
    }else{
        if($size < 10485760){
            $result=$conn->insert("projects",$data);
            if($result){
                move_uploaded_file($tmp_name,"./pofiles/project-files/$name");
                echo "<script>alert('Project Added Successfully')</script>";
            }else{
                echo "<script>alert('Project Addition Failed')</script>";
            }
        }else{
            echo "<script>alert('File Size must be less than 10MB')</script>";
        }
    }
}

// update projects

if(isset($_POST['updatedProName']) and isset($_POST['updatedProDesc'])){
    extract($_POST);
    if(empty($_FILES['updatedPoFile']['name'])){
        $data=[
            "pro_name"=>$updatedProName,
            "pro_desc"=>$updatedProDesc,
            "pro_po_no"=>$updatedPoNo,
            "pro_po_date"=>$updatedPoDate
        ];
    }else{
        extract($_FILES['updatedPoFile']);
        $data=[
            "pro_name"=>$updatedProName,
            "pro_desc"=>$updatedProDesc,
            "pro_po_no"=>$updatedPoNo,
            "pro_po_date"=>$updatedPoDate,
            "pro_file"=>$name
        ];
    }
    $readData=$conn->read("projects","`pro_name`","`pro_name`='$updatedProName' and `pro_id`!=$updatedId");
    if($readData->num_rows>0){
        echo "<script>alert('Project Name Already Added')</script>";
    }else{
        if(!empty($_FILES['updatedPoFile']['name'])){
            if($size < 10485760){
                $result=$conn->update("projects",$data,"`pro_id`=$updatedId");
                if($result){
                    move_uploaded_file($tmp_name,"./pofiles/project-files/$name");
                    echo "<script>alert('Project Updated Successfully')</script>";
                }else{
                    echo "<script>alert('Project Updation Failed')</script>";
                }
            }else{
                echo "<script>alert('File Size must be less than 10MB')</script>";
            }
        }else{
            $result=$conn->update("projects",$data,"`pro_id`=$updatedId");
            if($result){
                echo "<script>alert('Project Updated Successfully')</script>";
            }else{
                echo "<script>alert('Project Updation Failed')</script>";
            }
        }
    }
}

// delete projects

if(isset($_GET['del-id']) and !empty($_GET['del-id']) and intval($_GET['del-id'])!=0){
    $delId=$_GET['del-id'];
    $readData=$conn->read("projects","`pro_name`","`pro_id`=$delId");
    if($readData->num_rows>0){
        $result=$conn->delete("projects","`pro_id`=$delId");
        if($result){
            echo "<script>alert('Project Deleted Successfully')</script>";
        }else{
            echo "<script>alert('Project Deletion Failed')</script>";
        }
    }else{
        echo "<script>alert('No Project Exist')</script>";
    }
}
?>
<?php include "./components/header.php" ?>
<div class="usersPage">
    <h2>Projects</h2>
    <div class="crudBtn">
        <a href="add-project.php">Add</a>
        <input type="search" name="search" onkeyup="searchAllProjects()" placeholder="Search" id="searchAllProjects">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <thead>
                <tr>
                    <th>Project name</th>
                    <th>Project Desc</th>
                    <th>P.O. No.</th>
                    <th>P.O. Date</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $conn=new Conn();
            $result=$conn->read("projects");
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    ?>
                    <tr class="allProjectData">
                        <td><?php echo $row['pro_name'] ?></td>
                        <td><?php echo $row['pro_desc'] ?></td>
                        <td><?php echo $row['pro_po_no'] ?></td>
                        <td><?php echo $row['pro_po_date'] ?></td>
                        <td><a href="./pofiles/project-files/<?php echo $row['pro_file'] ?>" download><i class="fa-solid fa-download"></i></a></td>
                        <td>
                            <a href="update-project.php?id=<?php echo $row['pro_id'] ?>"><i class="fa-solid fa-pen"></i></a>
                            <a href="?del-id=<?php echo $row['pro_id'] ?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr align="center"><td colspan="40">No Project Added</td></tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "./components/footer.php" ?>