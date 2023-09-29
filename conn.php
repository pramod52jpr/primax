<?php
class Conn{
    public $domain="/primax";
    private $hostname="localhost";
    private $username="root";
    private $db_password="";
    private $db_name="primax";
    private $conn="";
    public function __construct(){
        if($this->conn==""){
            $this->conn=new mysqli($this->hostname,$this->username,$this->db_password,$this->db_name);
        }
    }

// read method

    public function read($table,$column="*",$where=null,$join=null,$limit=null,$groupby=null,$orderby=null){
        $sql="select $column from $table";
        if($join!=null){
            $sql.=" join $join";
        }
        if($where!=null){
            $sql.=" where $where";
        }
        if($groupby!=null){
            $sql.=" group by $groupby";
        }
        if($orderby!=null){
            $sql.=" order by $orderby";
        }
        if($limit!=null){
            $sql.=" limit $limit";
        }
        $result=$this->conn->query($sql);
        return $result;
    }

// insert method

    public function insert($table,$data){
        $column=implode("`,`",array_keys($data));
        $values=implode("','",array_values($data));
        $sql="insert into $table (`$column`) values ('$values')";
        $result=$this->conn->query($sql);
        return $result;
    }

// update method

    public function update($table,$data,$where=null){
        foreach($data as $key=>$value){
            $updateDataArray[]="`$key`='$value'";
        }
        $updatedData=implode(",",$updateDataArray);
        $sql="update $table set $updatedData";
        if($where!=null){
            $sql.=" where $where";
        }
        $result=$this->conn->query($sql);
        return $result;
    }

// delete method

    public function delete($table,$where,$deleteTable=null,$join=null){
        $sql="delete from $table";
        if($deleteTable!=null and $join!=null){
            $sql="delete $deleteTable from $table join $join";
        }
        if($where!=null){
            $sql.=" where $where";
        }
        $result=$this->conn->query($sql);
        return $result;
    }

    public function __destruct(){
        if($this->conn!==""){
            $this->conn->close();
        }
    }
}
?>