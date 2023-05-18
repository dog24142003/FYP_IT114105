<?php
require 'vendor_s3/autoload.php';

use Aws\S3\S3Client;

// 設置 S3 客戶端
$client = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-northeast-1',
    'credentials' => [
        'key'    => 'AKIASQ45CSNAH2YNTQVG',
        'secret' => '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',
    ],
]);

require_once ("conn.php");
require_once ("common/header.php");

    $sender = $_SESSION['Email'];
/*from viewteacher_profile*/
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $reason_Option = $_POST["reason_Option"];
    $detail = $_POST["Description"];
	$getter = $_POST["getter"];
	$dateTime = $_POST["dateTime"];
	
    $sql = "INSERT INTO `reports` (`senderEmail`, `getterEmail`, `dateTime`, `reason`, `detail`, `report_status`) VALUES
('$sender', '$getter', '$dateTime', '$reason_Option', '$detail', 'Pending');";
    	
   	if(mysqli_query(getDBconn(),$sql)) {
       echo '<script>alert("Successfully!");window.location.href="page_viewTeachers.php";</script>';
    }
        
    else {
		echo '<script>alert("Error!");window.location.href="page_viewTeachers.php;</script>';
	}
    
}
$bucket = 'fypobjectone';
$keyname = 'video/' .$sender."_evidence_".basename($_FILES["fileToUpload"]["name"]);

// 上傳文件
try {
	$file = $_FILES["fileToUpload"]["tmp_name"];
    
    $result = $client->putObject(
		array(
			'Bucket' => $bucket,
        	'Key'    => $keyname,
			'SourceFile' => $file,
			'StorageClass' => 'REDUCED_REDUNDANCY'
		)
        
    );
    echo "文件已成功上傳至 S3 存儲桶！";
	
	// 设置响应标头
	header('Content-Type: video/mp4');

	// 输出视频数据到响应流
	echo $result['Body'];
} catch (S3Exception $e) {
    echo "上傳失敗：" . $e->getMessage();
}
// 輸出文件內容
mysqli_close(getDBconn());

?>
