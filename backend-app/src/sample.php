<?php

$City=$_POST['city'] ;
$State=$_POST['state'] ;

if (!empty($City) || !empty($State)){
    $HOSTNAME='localhost';
    $USERNAME='root';
    $PASSWORD='';
    $DATABaSE='demo';

    //Create Connection
    $conn = new mysqli($HOSTNAME,$USERNAME,$PASSWORD,$DATABaSE);

    if($conn->connect_error) {
        die('connection Error(' .$conn->connect_errno.')'.$conn->connect_error);
    }else{
        $SELECT = "SELECT City FROM location WHERE City = ? LIMIT 1";
        $INSERT = "INSERT INTO location (City, State) VALUES (?, ?)";

        //Prepare Statement

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $City);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        //Checking City 
        if($rnum == 0){
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ss", $City, $State);
            $stmt->execute();
            echo("New City Add Succesfully...!");
            header('Location: add.html');
        }else{
            echo "City Has Already in the List";
        }
        $stmt->close();
        $conn->close();
    }
}else{
    echo"All Fields are Required";
    die(); 
}
?>