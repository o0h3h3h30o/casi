<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cias";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	

	$card_id = $_GET['card_id'];
	$phoneNum = $_GET['phoneNum'];
	$result = $_GET['result'];
	$menhGiaThe = $_GET['menhGiaThe'];
	$menhGiaThuc = $_GET['menhGiaThuc'];
	$menhGiaDK = $_GET['menhGiaDK'];
	$status = $_GET['status'];
	$requestId = $_GET['requestId'];
	if($status=='success'){
		$sql = "SELECT * FROM topup WHERE req_id = '".$requestId."' AND `status` !=2 ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
			   $sql_update = "UPDATE topup SET `status` = 2 WHERE req_id = '".$requestId."'";
			   $conn->query($sql_update);
			   // print_r($row['card_vl']);die();
			   $sql_update_user = "INSERT INTO server_flush (`username`, `flush_type`, `value`) VALUES ('".$row['username']."','GOLD','".$row['card_vl']*0.8."')";
			   $conn->query($sql_update_user);
			}
		} else {
			echo "0 results";
		}
		$conn->close();
	}
?>




card_id (int): id card
phoneNum (string:50): thông tin số điện thoại được thực hiện
result (string:255): kết quả thực hiện
menhGiaThe (int): mệnh giá thẻ được tính doanh thu
menhGiaDK (int): mệnh giá lúc đăng ký
menhGiaThuc (int): mệnh giá thực của thẻ
status (string:20): kết quả thực hiện
•   success: nạp thẻ thành công
•   card_fail: nạp thẻ ko thành công                            
•   deleted: thẻ không được chấp nhận, trùng mã, hoặc sai định dạng.. (nội dung chi tiết được mô tả trong result)
requestId (string:50): requestId của đối tác gửi lên khi RegCharge