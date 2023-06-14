<?php

// Include PhpSpreadsheet library autoloader 
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel_reader;

require 'database.php';
	 
$db = DB();	
  
if(isset($_POST['action'])){
	if ($_POST['action'] == "upload_extensions") 
	{ 
		upload_extensions(); 
	} 
}

if(isset($_POST['action'])){
	if ($_POST['action'] == "download_extensions") 
	{ 
		download_extensions2(); 
	} 
}


function upload_extensions()
{
	try {
		
		echo "start processing..";
				
		$response = "";
		
		// File upload folder 
		$uploadDir = 'uploads/'; 

		// Allowed file types 
		$allowTypes = array('xls', 'xlsx'); 
 
		$allowedFileType = [
			'application/vnd.ms-excel',
			'text/xls',
			'text/xlsx',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];
	
		if (in_array($_FILES["txt_file"]["type"], $allowedFileType)) {
		 
		}
		 
		$valid_extensions = array('xls', 'xlsx'); // valid extensions
		$path = 'uploads/'; // upload directory
		
		 // Allowed mime types 
		$excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
		
		$test = explode('.', $_FILES['txt_file']['name']);
		$extension = end($test);  
		
		echo $test;		
		echo $extension;
		
		// Validate whether selected file is a Excel file 
		if(!empty($_FILES['txt_file']['name']) && in_array($_FILES['txt_file']['type'], $excelMimes)){ 
			
			// If the file is uploaded 
			if(is_uploaded_file($_FILES['txt_file']['tmp_name'])){ 
			
				$reader = new excel_reader(); 
				$spreadsheet = $reader->load($_FILES['txt_file']['tmp_name']); 
				$worksheet = $spreadsheet->getActiveSheet();  
				$worksheet_arr = $worksheet->toArray(); 
	 
				// Remove header row 
				unset($worksheet_arr[0]); 
	 
				foreach($worksheet_arr as $row){ 
				
					$first_name = $row[0]; 
					$last_name = $row[1]; 
					$email = $row[2]; 
					$phone = $row[3]; 
					$status = $row[4]; 
					
					$extension_dal = new extension_dal();
					
					$extension_number_exists =  $extension_dal->check_if_extension_number_exists($extension_number);
					
					if($extension_number_exists){ 
						$response .=  $extension_dal->update_extension_from_upload($code, $extension_number, $owner_assigned, $department);
					}else{
						$response .=  $extension_dal->create_extension_from_upload($code, $extension_number, $owner_assigned, $department);
					}
			 
				}		 
		  
			} 
		}

	} catch (Exception $e) {
		echo $e->getMessage();
	}

}
 
function download_extensions()
{
	try {
		
		echo "start processing..";
				
		//CREATE A NEW SPREADSHEET + WORKSHEET
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle("Extensions");

		//FETCH DATA + WRITE TO SPREADSHEET		
		// select query - select all data
		$query = "SELECT * FROM depts";
		
		// prepare query for execution	
		$stmt = $db->prepare($query);
		
		// Execute the query
		$stmt->execute();
		
		$i = 1;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$sheet->setCellValue("A".$i, $row["ccode"]);
			$sheet->setCellValue("B".$i, $row["deptcode"]);
			$sheet->setCellValue("C".$i, $row["ownerassigned"]);
			$sheet->setCellValue("D".$i, $row["deptname"]);
			$i++;
		}

		//SAVE FILE
		$writer = new Xlsx($spreadsheet);
		$writer->save("extensions.xlsx");
		echo "OK";

	} catch (Exception $e) {
		echo $e->getMessage();
	}

}

function download_extensions2()
{
	try {
		
		echo "start processing..";
		
		$spreadsheet = new Spreadsheet();
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();
		
		$activeSheet->setCellValue('A1', 'CAMPUS');
		$activeSheet->setCellValue('B1', 'EXTENSION');
		$activeSheet->setCellValue('C1', 'OWNER ASSIGNED');
		$activeSheet->setCellValue('D1', 'DEPARTMENT');
		  
		// select query - select all data
		$query = "SELECT * FROM depts";
		
		// prepare query for execution	
		$stmt = $db->prepare($query);
		
		// Execute the query
		$stmt->execute();
		
		$num = $stmt->rowCount();
		
		if($num > 0) {
			$i = 2;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$activeSheet->setCellValue("A".$i, $row["ccode"]);
				$activeSheet->setCellValue("B".$i, $row["deptcode"]);
				$activeSheet->setCellValue("C".$i, $row["ownerassigned"]);
				$activeSheet->setCellValue("D".$i, $row["deptname"]);
				$i++;
			}
		}
		  
		$filename = 'extensions.xlsx';
		  
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='. $filename);
		header('Cache-Control: max-age=0');
		
		//$Excel_writer->save('php://output');
 
		if (!file_exists('files')) {
			mkdir('files', 0755);
		}
		
		$Excel_writer->save('files/'.$filename);
		
		$content = file_get_contents($filename);
		echo $contents;
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}

}


?>