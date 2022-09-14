<?php

$username = $_POST['username'];
$email = $_POST['email'];
$subjec = $_POST['subjec'];
$messag = $_POST['messag'];

if(!empty($username) || !empty($email) || !empty($subjec) || !empty($messag)) {
  $host = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbname = "fatunla";

  //create connection
  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if (mysqli_connect_error()) {
    die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
  } else {
      $SELECT = "SELECT email From contactform Where email = ? Limit 1";
      $INSERT = "INSERT Into contactform (username, email, subjec, messag) values(?, ?, ?, ?)";

      //Prepare statement
      $stmt = $conn->prepare($SELECT);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($email);
      $stmt->store_result();
      $rnum = $stmt->num_rows;

      if ($rnum==0) {
        $stmt->close();

        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssss", $username, $email, $subjec, $messag);
        $stmt->execute();
        echo "Your message has been sent successfully";
      } else {
        echo "Message Sent";
      }
      $stmt->close();
      $conn->close();
  }
} else {
  echo "All field are required";
  die();
}
 
?>

<script type="text/javascript">
  window.location="../index.html";
</script>
