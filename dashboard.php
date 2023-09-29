<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: $conn->domain");
}
session_abort();

if(isset($_GET['pro-id']) and !empty($_GET['pro-id']) and intval($_GET['pro-id'])!=0){
    $proId=$_GET['pro-id'];
    $readData=$conn->read("projects","`pro_name`","`pro_id`=$proId");
    if($readData->num_rows>0){
        $dataRow=$readData->fetch_assoc();
        $proName=$dataRow['pro_name'];
    }
}
session_start();
if(isset($_POST['profileName']) and isset($_SESSION['user_id'])){
    $userId=$_SESSION['user_id'];
    extract($_POST);
    $data=[
        "name"=>$profileName,
        "username"=>$profileUsername,
        "password"=>bin2hex($profilePassword)
    ];
    $profileResult=$conn->update("users",$data,"`user_id`=$userId");
    if($profileResult){
        echo "<script>alert('Profile Updated Successfully')</script>";
    }else{
        echo "<script>alert('Profile Updation Failed')</script>";
    }
}
session_abort();
?>
<?php include "./components/header.php" ?>
<div class="dashboardPage">
    <div class="projects">
        <div class="dropdown">
            <div>
                <i class="fa-solid fa-bars-progress" style="margin: 0px 5px;"></i>
                <?php echo isset($proName)?$proName:'Select Project' ?>
            </div>
            <i class="fa-solid fa-chevron-down"></i>
        </div>
        <div class="projectList">
            <input type="text" onkeyup="searchProject()" name="search" id="search" placeholder="Search">
            <div class="items">
                <?php
                if($userRow['category']!=1){
                    $conn=new Conn();
                    $result=$conn->read("projects");
                    if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                            session_start();
                            $userId=$_SESSION['user_id'];
                            $userDoc=$conn->read("documents","*","`doc_supplier`=$userId and `project_id`=$row[pro_id]");
                            session_abort();
                            if($userDoc->num_rows>0){
                                ?>
                                <a href="?pro-id=<?php echo $row['pro_id'] ?>" class="projectData">
                                    <i class="fa-solid fa-bars-progress" style="margin: 10px;"></i>
                                    <div class="name">
                                        <?php echo $row['pro_name'] ?>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                    }
                }else{
                    $conn=new Conn();
                    $result=$conn->read("projects");
                    if($result->num_rows>0){
                        while($row=$result->fetch_assoc()){
                            ?>
                            <a href="?pro-id=<?php echo $row['pro_id'] ?>" class="projectData">
                                <i class="fa-solid fa-bars-progress" style="margin: 10px;"></i>
                                <div class="name">
                                    <?php echo $row['pro_name'] ?>
                                </div>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    if(isset($_GET['pro-id']) and !empty($_GET['pro-id']) and intval($_GET['pro-id'])!=0){
        $readDataAgain=$conn->read("projects","`pro_name`","`pro_id`=$proId");
        if($readDataAgain->num_rows>0){
            ?>
            <div class="projectMenuTitle">Menu</div>
            <div class="projectMenu">
                <div class="section">
                    <form action="documents.php" method="get">
                        <input type="hidden" name="proId" value="<?php echo $_GET['pro-id'] ?>">
                        <input type="submit" value="Supplier Docs">
                    </form>
                    <form action="#" method="post">
                        <input type="submit" value="Technical Contract">
                    </form>
                </div>
                <div class="section">
                    <form action="#" method="post">
                        <input type="submit" value="Invoices per PO">
                    </form>
                    <form action="#" method="post">
                        <input type="submit" value="Packing List">
                    </form>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<?php include "./components/footer.php" ?>