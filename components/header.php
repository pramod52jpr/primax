<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primax</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/dashboard.css">
    <link rel="stylesheet" href="style/users.css">
    <link rel="stylesheet" href="style/add-user.css">
</head>
<body>
    <header>
        <?php
        session_start();
        $conn=new Conn();
        $currentUser=$conn->read("users","`name`,`category`","`user_id`=$_SESSION[user_id]");
        if($currentUser->num_rows>0){
            $userRow=$currentUser->fetch_assoc();
        }

        session_abort();
        ?>
        <div class="hamburger">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="myAccount">
            <i class="fa-solid fa-user"></i>
            <div><?php echo $userRow['name'] ?></div>
        </div>
    </header>
    <div class="logout">
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="sectionContainer">
        <div class="menuItems">
            <a href="dashboard.php"><i class="fa-solid fa-gauge"></i>Dashboard</a>
            <?php
            if($userRow['category']==1){
                ?>
                <div class="item" id="master"><div><i class="fa-solid fa-layer-group"></i>Master Data</div><i class="fa-solid fa-caret-down"></i></div>
                <div class="links" id="masterLinks">
                    <a href="users.php"><i class="fa-solid fa-users"></i>Users</a>
                    <a href="projects.php"><i class="fa-solid fa-bars-progress"></i>Projects</a>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="content">