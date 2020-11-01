<?php
require_once 'app/db.php';

function validationmsg($msg, $type ='danger'){
    return "<p class='alert alert-". $type ." '> ".$msg."! <button class='close' data-dismiss='alert'>&times;</button></p>";
}

function insert($sql){
    global $conn;
   $conn->query($sql);
}

function valucheek($table,$colum,$val){
    global $conn;
    $sql="SELECT $colum FROM $table WHERE $colum='$val'";
    $data=$conn->query($sql);
    return $data->num_rows;
}
function update($sql){
    global $conn;
    $conn->query($sql);
}
function old($input_field_name){
        if (isset($_POST[$input_field_name])){
            echo $_POST[$input_field_name];
        }
}