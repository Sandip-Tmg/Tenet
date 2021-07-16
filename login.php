<?php
session_start(); #tracks the details of user on website

require_once('C:\xampp\lab05\db_connection.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $errors = array();
    #validates the user's input
    if(empty($_POST['email'])){
        $errors[] = "An email is required";
    }
    else{
        $email = test_input($_POST["email"]);
        $email = mysqli_real_escape_string($conn, $email);
    }
    if(empty($_POST['password'])){
        $errors[] = "A password is required";
    }
    else{
        $password = test_input($_POST["password"]);
        $password = mysqli_real_escape_string($conn, $password);
    }
    #checks there are no errors before processing user's data
    if(empty($errors)){
        
        $query = "SELECT * FROM employee WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
      
            $_SESSION['email'] = $row['email'];
            #$_SESSION['password'] = $row['password'];
            $_SESSION['log-in'] = 1;
            
            echo "<h2> Welcome! </h2>";
            
            #redirect user to the welcome page after succesful login
            header("location:index.html?Valid=You are logged in successfully"); 
        }
        else { 
            #remains on the login displaying invalid details
            header("location:login.php?Invalid=The username and password are incorrect!");
            mysqli_error($db_connection);
            
        } 

    }
    
   
}


function test_input($data) {
    //handles the data of the form.
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>