<?php
 session_start();
?>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>
  </title>
</head>
<body class="bodyofreplypage">

<div class="postidsubmitbox">
  <form method="POST">
  <input type="number" name="postid" placeholder=" postid" style=" font-size:25;height:30px;
   border:2px solid black; border-radius:20px;">
  <button type="submit" name="findpostbutton" style=" font-size:25;height:30px;
   border:2px solid black; border-radius:20px;">view post</button>
  </form>
</div>
  <?php
   if(isset($_POST['findpostbutton']))
    {
       $postid = $_POST['postid'];
        $_SESSION['postid'] = $postid;
       // $_SESSION['postid'] = $postid;
       include_once 'dbh.php';
       $sql ="SELECT  * from posttable where postid='$postid'; ";
       $result = mysqli_query($conn,$sql);
       $row = mysqli_fetch_assoc($result);
       $userid = $row["userid"];
        $sql1 = "SELECT * from usertable where userid = '$userid';";
        $result1 = mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_assoc($result1);
       echo '<div class="postviewinreplysection">
         <h5>'."&nbspPostedby".$row1["username"]."&nbsp&nbspPhoneNo:".$row1["username"].'</h5>
        <hr>
         <h5>'.$row["postdescription"].'</h5>
       </div>';

       $sql = "SELECT * from replytable where postid = '$postid';";
       $result = mysqli_query($conn,$sql);
       while($row = mysqli_fetch_assoc($result))
       {
         $userid = $row["userid"];
          $sql1 = "SELECT * from usertable where userid = '$userid';";
          $result1 = mysqli_query($conn,$sql1);
          $row1 = mysqli_fetch_assoc($result1);
         echo'<div class = "replyviewinreplypage">
         <h6>'."&nbsp PostedBy:".$row1["username"]."&nbsp&nbsp Bid:".$row["bidamount"]."$".
         "&nbsp&nbsp PhoneNo".$row1["phoneno"].'</h6>
         <hr>
          <h6>'.$row["replydescription"].'</h6>
         </div>';
       }
     }

  ?>
<div class="replyingbox">
  <form method="POST">
    <textarea name="reply" rows="3" columns="80" placeholder=" type your reply here..."
    style=" font-size:25;
     border:2px solid black; border-radius:20px;"></textarea><br><br>

    <input type="number" name="bidamount" placeholder=" your bid"
    style=" font-size:25;height:30px;
     border:2px solid black; border-radius:20px;">

    <button type="submit" name="replysubmit"style=" font-size:25;height:30px;
     border:2px solid black; border-radius:20px;">reply</post>
  </form>
</div>
  <?php
    include_once 'dbh.php';
    if(isset($_POST['replysubmit']))
    {
    if(!empty($_SESSION['userid']))
    {
        $userid = $_SESSION['userid'];
      $replydescription = $_POST['reply'];
      $bidamount = $_POST['bidamount'];
    if(!empty($_SESSION['postid']))
    {
     if(!empty($replydescription) && !empty($bidamount) )
     {
        $postid = $_SESSION['postid'];
       $sql="INSERT into replytable (postid,userid,replydescription,bidamount)  values('$postid','$userid','$replydescription','$bidamount');";
       mysqli_query($conn,$sql);
       echo "posted successfully";
       //to ensure that same reply is not posted again on reloading
       //the reply.php page
       unset($_SESSION['postid']);
       header("location: redirect2.php");
     }
    else{
      echo "both reply and bid amount is a compulsory field";
    }
  }else{
    echo "please select the post id first";
  }
}
else{
  header("location :loginpage.php");
}
}//end of isset if condition for replysubmit button
?>
</body>
</html>
