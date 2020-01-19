<?php

 session_start();
 $_SESSION['islogedin'] = 0;
?>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>
  </title>
</head>
<body class="bodyofloginpage">

  <!-- signup form -->
  <div class="signupandloginform">
   <form method="POST">
    <input type="text" name="signupname" placeholder=" name" size="20" style=" font-size:25;height:30px;
     border:2px solid black; border-radius:20px;">
     <br><br>
    <input type="text" name="signuppassword" placeholder=" password" size="20" style=" font-size:25;height:30px;
    border:2px solid black; border-radius:20px;">
    <br><br>
    <input type="text" name="phoneno" placeholder=" phoneno" size="20" style=" font-size:25;height:30px;
    border:2px solid black; border-radius:20px;">
    <br><br>
    <button type="submit" name="signupsubmit"  style=" font-size:25;height:35px;
    border:2px solid black;">signup</button><br>
   </form>

 <!-- loginform -->
  <form method="POST">
    <input type="text" name="loginname" placeholder=" name"size="20" style=" font-size:25;height:30px;
     border:2px solid black; border-radius:20px;">
    <br><br>
    <input type="text" name="loginpassword" placeholder=" password"size="20" style=" font-size:25;height:30px;
     border:2px solid black; border-radius:20px;">
    <br><br>
    <button type="text" name="loginsubmit"size="20" style=" font-size:25;height:35px;
     border:2px solid black; ">login</button>
  </form>
</div>
  <?php
    include_once 'dbh.php';
    if(isset($_POST['signupsubmit']))
    {
      // echo "heh";
      $name = $_POST['signupname'];
      $password=$_POST['signuppassword'];
      $phoneno=$_POST['phoneno'];
      if(empty($name) || empty($password))
      {
        echo "pls fill all the details";
      }else{
        // echo "hey man";
        $sql="INSERT into usertable(username,userpassword,phoneno) values('$name','$password','$phoneno'); ";
        mysqli_query($conn,$sql);
        echo "you have been signed up successfully";
      }
    }

    if(isset($_POST['loginsubmit']))
    {
      $name = $_POST['loginname'];
      $password = $_POST['loginpassword'];
      if(!empty($name) && !empty($password))
      {
        $sql="SELECT * from  usertable where username='$name' and userpassword='$password'; ";
        $result = mysqli_query($conn,$sql);
         $no_of_results = mysqli_num_rows($result);
         if($no_of_results>0)
         {
           $row = mysqli_fetch_assoc($result);
           $_SESSION['userid'] = $row['userid'];
           $_SESSION['islogedin'] = 1;
           $_SESSION['phoneno'] = $row['phoneno'];
           header("Location: mainpage.php");

         }
          else{
          echo "incorrect password or user name";
         }
      }//end of empty checking if
      else
      {
        echo "pls fill all details";
      }
    }//end isset button if

  ?>
</body>
</html>
