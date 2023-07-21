<?php 
class AdminUsers{
    var $con;
    var $tableName = "users";
    var $result;

    public function __construct($con){
        $this->con = $con;
        $this->users = array();
        
    }

    public function getUsers(){
        $users = array();

        $query = mysqli_query($this->con, "SELECT * FROM ".$this->tableName." WHERE (userRole =2 OR userRole =3) ORDER BY  full_name ASC");

        while ($row = mysqli_fetch_assoc($query)) {
            $users[] = $row;
        }

        return $users;
    }
}


?>