<?php

// 設置PHPMailer庫文件的路徑
require 'inc/PHPMailer.php';
require 'inc/SMTP.php';
require 'inc/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once ("conn.php");
require_once ("common/header.php");


   	


if($_SERVER["REQUEST_METHOD"] == "POST"){
	$account = $_POST['account'];
    $Email = $_POST['Email'];
   	$Reason = $_POST['reason_Option'];
   	$Detail = $_POST['Description'];
   	$SuspendDate = date('Y-m-d');
	$susDay = $_POST['susDay'];
	$SuspendUntil = date('Y-m-d', strtotime("+$susDay days"));
		$sql = "INSERT INTO suspenduser (Email,Reason,Detail,blocked_date,blocked_until) VALUES ('$Email','$Reason', '$Detail','$SuspendDate','$SuspendUntil')";
	
		
    // 新增資料
   	if(mysqli_query(getDBconn(),$sql)) {
       	echo "New record created successfully";
    }
    else {
		echo '<script>alert("Error!");window.location.href="page_admin_profile.php;</script>';
	}
	// 更新資料
	if($account == "tutor"){
		$sql = "UPDATE tutor SET blockStatus=1 WHERE Email='$Email'";
	}else{
		$sql = "UPDATE student SET blockStatus=1 WHERE Email='$Email'";
	}
    
	
	if (mysqli_query(getDBconn(), $sql)) {
		echo '<script>alert("Successfully!");window.location.href="page_admin_profile.php";</script>';
	} else {
		echo '<script>alert("Error!");window.location.href="page_admin_profile.php;</script>';
	}
	$sql = "SELECT * FROM tutor WHERE Email='$Email';";
	$result = mysqli_query(getDBconn(),$sql);
	if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $tname = $row['FirstName'] . ' ' . $row['LastName'];
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
 

    }
 
} 
//Create instance of PHPMailer
	$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
//Define smtp host
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = "chanwaikuen556@gmail.com";
//Set gmail password
	$mail->Password = "xteucgzpxnoeumde";
//Email subject
	$mail->Subject = "Notification-account has been suspended";
//Set sender email
	$mail->setFrom('chanwaikuen556@gmail.com');
//Enable HTML
	$mail->isHTML(true);
//Attachment
	$mail->addAttachment('img/logo.jpg');
//Email body
	$mail->Body = "Dear $tname,</br>
	<p>我們希望這封電子郵件能找到您處於安好的狀態。我們寫信給您是因為您在我們的網站上的帳戶已經被封鎖了。以下是詳細信息：</p></br>
	<p>用戶名：$tname</p></br>
	<p>封鎖日期：$SuspendDate</p></br>
	<p>封鎖直至：$SuspendUntil</p></br>
	<p>封鎖原因：$Reason</p></br>
	<p>封鎖詳情：$Detail</p></br>
	<p>如果您對此有任何疑問，請隨時與我們聯繫。謝謝您。</p></br>
	<p>敬祝安好,</p></br>
	<p>TutorCat Admin</p></br> 
	<p>Chan Wai Kuen</p>";
	
	
//Add recipient send to who
	$mail->addAddress('chanwaikuen5556@gmail.com');
//Finally send email
	if ( $mail->send() ) {
		echo "Email Sent..!";
	}else{
		echo "Message could not be sent. Mailer Error: ";
	}
//Closing smtp connection
	$mail->smtpClose();


}
mysqli_close(getDBconn());
?>