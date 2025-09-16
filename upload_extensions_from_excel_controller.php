<?php


// Include PhpSpreadsheet library autoloader 
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel_reader;

use Phppot\DataSource;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require 'database.php';
	
 
$db = DB();	
  
if(isset($_POST['action']))
{

	if ($_POST['action'] == "upload_extensions") 
	{ 
		upload_extensions(); 
	} 
	if ($_POST['action'] == "download_extensions") 
	{ 
		download_extensions2(); 
	} 
}
 

var_dump($_FILES["file"]["name"]);

$target_dir = 'uploads/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}


$filename = $_FILES["file"]["name"];
$filetype = $_FILES["file"]["type"];
$filesize = $_FILES["file"]["size"];


echo '<br />';
echo $filename . '<br />';
echo $filetype . '<br />';
echo $filesize . '<br />';


move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

		echo "start processing..";
		//return;



// require_once 'DataSource.php';
// $db = new DataSource();
// $conn = $db->getConnection();
// require_once ('vendor/autoload.php');
 
    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $targetPath = 'uploads/' . $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

		$reader = new excel_reader(); 
		$spreadsheet = $reader->load($_FILES['file']['tmp_name']); 
		$worksheet = $spreadsheet->getActiveSheet();  
		$worksheet_arr = $worksheet->toArray(); 
		$sheet_Count = count($worksheet_arr);

		var_dump($sheet_Count);

        //$Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        for ($i = 1; $i <= $sheetCount; $i ++) {
            $name = "";
            if (isset($spreadSheetAry[$i][0])) {
                $name = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
            }
            $description = "";
            if (isset($spreadSheetAry[$i][1])) {
                $description = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
            }

            if (! empty($name) || ! empty($description)) {
                $query = "insert into tbl_info(name,description) values(?,?)";
                $paramType = "ss";
                $paramArray = array(
                    $name,
                    $description
                );
                $insertId = $db->insert($query, $paramType, $paramArray);
                // $query = "insert into tbl_info(name,description) values('" . $name . "','" . $description . "')";
                // $result = mysqli_query($conn, $query);

                if (! empty($insertId)) {
                    $type = "success";
                    $message = "Excel Data Imported into the Database";
                } else {
                    $type = "error";
                    $message = "Problem in Importing Excel Data";
                }
            }
        }
    } else {
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
    } 





function upload_extensions()
{
	try {
		

		echo "start processing..";
		return;











		echo "start processing..";
		end;		
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
	 
				 if(isset($_POST)){
				   
					$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
					  
					if(!isset($addedby)){
						$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Added By is mandatory field.</div>';
					}  

					if(!empty($response)){
						echo $response;
						return;
					}
				}

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
						$response .=  $extension_dal->create_extension_from_upload($code, $extension_number, $owner_assigned, $department, $addedby);
					}
			 
				}		 
		  
			}else{
				$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error uploading file to server.</div>';
			} 

		}else{
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error accessing the uploaded file or the file extension is invalid.</div>';
		} 

		echo $response;

	} catch (Exception $e) {
		echo $e->getMessage();
	}

}
 
function upload_extensions_v2()
{
	try {
		
		echo "start processing..";
		end;		
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
	 
				 if(isset($_POST)){
				   
					$addedby = trim(htmlspecialchars(strip_tags($_POST['addedby']))); 
					  
					if(!isset($addedby)){
						$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Added By is mandatory field.</div>';
					}  

					if(!empty($response)){
						echo $response;
						return;
					}
				}

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
						$response .=  $extension_dal->create_extension_from_upload($code, $extension_number, $owner_assigned, $department, $addedby);
					}
			 
				}		 
		  
			}else{
				$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error uploading file to server.</div>';
			} 

		}else{
			$response .= '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error accessing the uploaded file or the file extension is invalid.</div>';
		} 

		echo $response;

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