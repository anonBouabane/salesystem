<?php



include("../setting/conn.php");

include('../Classes/PHPExcel.php');

$objPHPExcel	=	new	PHPExcel();

 

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Country Code');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Country Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Capital');

$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Country Code');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Country Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Capital');


$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

$rowCount = 3;

$stmt1 = $conn->prepare("select * from tbl_account_company");
$stmt1->execute();
if ($stmt1->rowCount() > 0) {
	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

 


		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, mb_strtoupper($row1['acc_number'], 'UTF-8'));
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, mb_strtoupper($row1['acc_name'], 'UTF-8'));
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, mb_strtoupper($row1['acc_code'], 'UTF-8'));
		$rowCount++;
	}
}

$objPHPExcel->getActiveSheet()->setTitle('Name of Sheet 1');


$objPHPExcel->createSheet();


$objPHPExcel->setActiveSheetIndex(1);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Country Code 2');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Country Name 2');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Capital 2');

$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Country Code');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Country Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Capital');

$rowCount2	=	3;

$stmt2 = $conn->prepare("select * from tbl_account_company");
$stmt2->execute();
if ($stmt2->rowCount() > 0) {
	while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
 
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount2, mb_strtoupper($row2['acc_number'], 'UTF-8'));
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount2, mb_strtoupper($row2['acc_name'], 'UTF-8'));
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount2, mb_strtoupper($row2['acc_code'], 'UTF-8'));
		$rowCount2++;
	}
}

 

// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('Second sheet');

 


$objWriter	=	new PHPExcel_Writer_Excel2007($objPHPExcel);


header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="you-file-name.xlsx"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
