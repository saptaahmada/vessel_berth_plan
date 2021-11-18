<?php

$excel = new PHPExcel();
// Settingan awal fil excel
$excel->getProperties()->setCreator('My Notes Code')
             ->setLastModifiedBy('My Notes Code')
             ->setTitle("Produksi Operator")
             ->setSubject("System")
             ->setDescription("Laporan Produksi Operator")
             ->setKeywords("Produksi Operator");
// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
  'font' => array('bold' => true), // Set font nya jadi bold
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);
// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
  )
);
$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA VESSEL BERTHING "); // Set kolom A1 dengan tulisan "DATA TOTALIZER"
$excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); // Set font size 20 untuk kolom A1
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

$excel->setActiveSheetIndex(0)->setCellValue('A2', $start_date." s/d ".$end_date); // Set kolom A3 dengan tulisan "NO"
$excel->getActiveSheet()->mergeCells('A2:H2'); // Set Merge Cell pada kolom A1 sampai E1
$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20); // Set font size 20 untuk kolom A1
$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text 

// Buat header tabel nya pada baris ke 3

$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('B3', "VES ID"); // Set kolom B3 dengan tulisan "NIS"
$excel->setActiveSheetIndex(0)->setCellValue('C3', "VES NAME"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('D3', "VES CODE"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('E3', "ETA"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('F3', "RBT"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('G3', "ETB"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('H3', "ETD"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('I3', "ATB"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('J3', "ATD"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('K3', "LOA"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('L3', "EST DISC"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('M3', "EST LOAD"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('N3', "BSH"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('O3', "BERTH FR METRE"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('P3', "BERTH TO METRE"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('Q3', "OCEAN INTERISLAND"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('R3', "AGENT"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('S3', "AGENT NAME"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('T3', "SERVICE"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('U3', "NEXT PORT"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('V3', "DEST PORT"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('W3', "INFO"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('X3', "CRANE"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('Y3', "VES TYPE"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('Z3', "BTOA SIDE"); // Set kolom C3 dengan tulisan "NAMA"

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
// Panggil function view yang ada di SystemModel untuk menampilkan semua val siswanya

$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach($data as $no => $val){ // Lakukan looping pada variabel siswa

  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no+1);
  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val->ves_id);
  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val->ves_name);
  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val->ves_code);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val->est_pilot_ts_str);
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val->req_berth_ts_str);
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val->est_berth_ts_str);
  $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val->est_dep_ts_str);
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val->act_berth_ts_str);
  $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val->act_dep_ts_str);
  $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val->width_ori);
  $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val->est_disch);
  $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val->est_load);
  $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $val->bsh);
  $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $val->berth_fr_metre_ori);
  $excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $val->berth_to_metre_ori);
  $excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $val->ocean_interisland);
  $excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $val->agent);
  $excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $val->agent_name);
  $excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $val->ves_service);
  $excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $val->next_port);
  $excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $val->dest_port);
  $excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $val->info);
  $excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $val->crane);
  $excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $val->ves_type);
  $excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $val->btoa_side);
  // $excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $val->btoa_side);
  
  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row);

  $numrow++; // Tambah 1 setiap kali looping
}
// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('S')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('T')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('U')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('V')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('W')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('X')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20); // Set width kolom C

// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Data vessel berthing");
$excel->setActiveSheetIndex(0);
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="viera_'.$start_date." s/d ".$end_date.'.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');