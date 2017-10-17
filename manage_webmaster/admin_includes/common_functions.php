<?php
    
    function getDataFromTables($table=NULL,$status=NULL,$clause=NULL,$id=NULL,$activeStatus=NULL,$activeTop=NULL) {
        
        //echo $table ."<br />". $status;
        global $conn;
        if($table!='' && $table!=NULL && $clause!='' && $clause!=NULL && $id!='' && $id!=NULL) {
            //Get All Table Data with Where Condition(4)
            $sql="select * from `$table` WHERE `$clause` = '$id' ";
        } elseif($table!='' && $table!=NULL && $status!='' ) {
            //Get Active Records (3)
            $sql="select * from `$table` WHERE `status` = '$status' ORDER BY id DESC";
        } elseif($table!='' && $table!=NULL && $activeTop!='' && $activeTop!=NULL) {
            //Get All Active records top Table Data (6)
            $sql="select * from `$table` ORDER BY status, id DESC ";
        } elseif($table!='' && $table!=NULL) {
            //Get All Table Data (1)
            $sql="select * from `$table` ORDER BY status, id DESC";
        }  else {
            //Last if fail then go to this
            $sql="select * from `$table` ORDER BY status, id DESC";
        }
        
        $result = $conn->query($sql);
        return $result;
    }

    /*Common function with where out where get all data from query */
    function getAllDataWithActiveRecent($table)  {
        global $conn;
        $sql="select * from `$table` ORDER BY status, id DESC ";
        $result = $conn->query($sql); 
        return $result;
    }

    /* Common function for get count for rows */
     function getRowsCount($table)  {
        global $conn;
        $sql="select * from `$table` ";
        $result = $conn->query($sql);
        $noRows = $result->num_rows;
        return $noRows;
    }

    /* encrypt and decrypt password */
     function encryptPassword($pwd) {
        $key = "123";
        $admin_pwd = bin2hex(openssl_encrypt($pwd,'AES-128-CBC', $key));
        return $admin_pwd;
    }

    function decryptPassword($admin_password) {
        $key = "123";
        $admin_pwd = openssl_decrypt(hex2bin($admin_password),'AES-128-CBC',$key);
        return $admin_pwd;
    }

    function getImageUnlink($val,$table,$clause,$id,$target_dir) {
        global $conn;
        $getBanner = "SELECT $val FROM $table WHERE $clause='$id' ";
        $getRes = $conn->query($getBanner);
        $row = $getRes->fetch_assoc();
        $img = $row[$val];
        $path = $target_dir.$img.'';
        chown($path, 666);
        if (unlink($path)) {
            return 1;
        } else {
            return 0;
        }
    }
?>
