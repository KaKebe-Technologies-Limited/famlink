<?php

class AllUsers{
    var $users;
    var $con;
    var $table = "users";

    public function __construct($con){
        $this->con = $con;
        $this->getUsers();
    }

    public function getUsers(){
        $user = array();
        $sql = mysqli_query($this->con,"SELECT * FROM ".$this->table." ORDER BY full_name ASC");
        while ($row = mysqli_fetch_assoc($sql)) {
            $user[] = $row;
        }

        $this->users = $user;
        return $user;
    }

    public function getTotal(){
        return count($this->users);
    }

    public function countSuperAdmin(){
        $this->users = [];
        $sql = mysqli_query($this->con,"SELECT * FROM ".$this->table." WHERE userRole = 2 ORDER BY full_name ASC");
        while ($row = mysqli_fetch_assoc($sql)) {
            $this->users[] = $row;
        }
        return count($this->users);
    }

    public function countAdmin(){
        $this->users = [];
        $sql = mysqli_query($this->con,"SELECT * FROM ".$this->table." WHERE userRole = 3 ORDER BY full_name ASC");
        while ($row = mysqli_fetch_assoc($sql)) {
            $this->users[] = $row;
        }
        return count($this->users);
    }

}

?>