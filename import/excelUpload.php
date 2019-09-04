
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');

$dbHost = "localhost";
$dbDatabase = "cias";
$dbPasswrod = "";
$dbUser = "root";
$mysqli = new mysqli($dbHost, $dbUser, $dbPasswrod, $dbDatabase);

if(isset($_POST['Submit']))
{
	
    $mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    if(in_array($_FILES["file"]["type"],$mimes))
    {
        $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
		
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
        $Reader = new SpreadsheetReader($uploadFilePath);
        echo $uploadFilePath;die();
		$totalSheet = count($Reader->sheets());
		/* For Loop for all sheets */
        for($i=0;$i<$totalSheet;$i++)
        {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row)
            {
            
                $loaithe = isset($Row[0]) ? $Row[0] : '';
                $gold = isset($Row[1]) ? $Row[1] : '';
				$serial = isset($Row[2]) ? $Row[2] : '';
				$mathe = isset($Row[3]) ? $Row[3] : '';

				$query = "insert into tbl_reward(loaithe,gold,status,serial,mathe) values('".$loaithe."','".$gold."','1','".$serial."','".$mathe."')";
				$mysqli->query($query);
				
            }
        }
        

            echo "<br />Them thanh cong";
			echo "<br> <a href = 'http://big686.club/account/import/index.php'>Quay lai</a>";
        }
        else
        {
            die("<br/>Sorry, File type is not allowed. Only Excel file.");
        }
}
?>