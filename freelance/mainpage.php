<?php
 // $_SESSION['islogedin'] = 0;
 session_start();
?>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title></title>
</head>
<body>
  <nav>
  <div class="postanewpost">
  <form method="POST">
    <textarea name="postdescription" rows="5" cols="30" placeholder="post something here"
    style=" font-size:25;
     border:2px solid black; border-radius:20px;">post something here </textarea>

    <br>
    <button type="submit" name="postsubmit" style=" font-size:25;height:35px;
    width:80px;
     border:2px solid black; border-radius:20px;">post</button>
  </form>
</div>
<div class="postanewpost">
  <form method="POST">
    <button type="submit" name="logout"
    style=" font-size:25;height:35px;
   width:80px;
    border:2px solid black; border-radius:20px;">logout</button>
  </form>
</div>
</nav>
<hr style="border:0.8px solid grey">
  <?php
    include_once 'dbh.php';
    if( isset($_POST['postsubmit']) )
    {
        $userid = $_SESSION['userid'];
      if(!empty($userid))
      {
        $phoneno  = $_SESSION['phoneno'];
        $postdescription = $_POST['postdescription'];
        if(!empty($postdescription) && $postdescription!="")
        {
           $sql = "INSERT into posttable(userid,phoneno,postdescription)
                 values('$userid','$phoneno','$postdescription');";
         mysqli_query($conn,$sql);
         header("location:redirect.php");

       }
       else{
         echo "empty posts are not allowed";
       }
     }else{
        header("location:loginpage.php");
     }
       // echo '
       //      <script type="text/javascript">
       //      location.reload();
       //      </script>';
    }


   if(isset($_POST['logout']))
   {
     session_unset();
     session_destroy();
     header("location:loginpage.php");

   }
  ?>

    <?php
      include_once 'dbh.php';
      $sql = "SELECT * from posttable order by postid desc;";
      $result  = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($result))
      {
        $sum = 0;
        $count = 0;
        $avgbid = 0;
        $postid = $row["postid"];
        $sql1 = " SELECT * from replytable where postid='$postid'; " ;
        $result1 = mysqli_query($conn,$sql1);
        while($row1 = mysqli_fetch_assoc($result1))
        {
          if(!empty($row1["bidamount"]))
          {
           $sum=$sum+$row1["bidamount"];
           $count++;
         }
          // echo '<div class="postreply">
          //      </div>';
          //       <p><p>
        }
        if($count>0)
        {
         $avgbid = $sum/$count;
        }
        $uid = $row["userid"];
        $sql2= "SELECT * from usertable where userid='$uid';";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);

        echo '<div class="post">
          <h4 class="headerofpost">'."POSTID: ".$row["postid"]."  &nbsp &nbsp&nbsp&nbsp PostedBy:  ".$row2["username"].
          " &nbsp &nbsp&nbsp&nbsp CONTACT: ".$row2["phoneno"].'</h4>
          <hr width=590px  color=grey>
          <h5 class="postdescription">'.$row["postdescription"].'<h5>
          <h5 class="avgbid">'.'avgbid: '.$avgbid."$".'
          <form method="POST" action="reply.php">
          <button class="bidsubmit" type="submit" name="bidsubmit">bid</button>
          </form></h5>
        </div>';

    }
    ?>



</body>
</html>
