<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
session_unset();
session_destroy();
header("Location: $conn->domain");
?>