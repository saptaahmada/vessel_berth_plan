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

$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
$excel->setActiveSheetIndex(0)->setCellValue('B3', "BERTH");
$excel->setActiveSheetIndex(0)->setCellValue('C3', "VES ID");
$excel->setActiveSheetIndex(0)->setCellValue('D3', "VES NAME");
$excel->setActiveSheetIndex(0)->setCellValue('E3', "VES CODE");
$excel->setActiveSheetIndex(0)->setCellValue('F3', "NEXT PORT");
$excel->setActiveSheetIndex(0)->setCellValue('G3', "DEST PORT");
$excel->setActiveSheetIndex(0)->setCellValue('H3', "LOA");
$excel->setActiveSheetIndex(0)->setCellValue('I3', "AGENT");
$excel->setActiveSheetIndex(0)->setCellValue('J3', "AGENT NAME");
$excel->setActiveSheetIndex(0)->setCellValue('K3', "SERVICE");
$excel->setActiveSheetIndex(0)->setCellValue('L3', "EST DISC");
$excel->setActiveSheetIndex(0)->setCellValue('M3', "EST LOAD");
$excel->setActiveSheetIndex(0)->setCellValue('N3', "EST BSH");
$excel->setActiveSheetIndex(0)->setCellValue('O3', "ETA");
$excel->setActiveSheetIndex(0)->setCellValue('P3', "RBT");
$excel->setActiveSheetIndex(0)->setCellValue('Q3', "ETB");
$excel->setActiveSheetIndex(0)->setCellValue('R3', "ETD");
$excel->setActiveSheetIndex(0)->setCellValue('S3', "CRANE");
$excel->setActiveSheetIndex(0)->setCellValue('T3', "DISC");
$excel->setActiveSheetIndex(0)->setCellValue('U3', "LOAD");
$excel->setActiveSheetIndex(0)->setCellValue('V3', "HATCH COVER");
$excel->setActiveSheetIndex(0)->setCellValue('W3', "MOVE");
$excel->setActiveSheetIndex(0)->setCellValue('X3', "ATB");
$excel->setActiveSheetIndex(0)->setCellValue('Y3', "START WORK");
$excel->setActiveSheetIndex(0)->setCellValue('Z3', "END WORK");
$excel->setActiveSheetIndex(0)->setCellValue('AA3', "ATD");
$excel->setActiveSheetIndex(0)->setCellValue('AB3', "BT");
$excel->setActiveSheetIndex(0)->setCellValue('AC3', "BWT");
$excel->setActiveSheetIndex(0)->setCellValue('AD3', "ET");
$excel->setActiveSheetIndex(0)->setCellValue('AE3', "IT");
$excel->setActiveSheetIndex(0)->setCellValue('AF3', "NOT");
$excel->setActiveSheetIndex(0)->setCellValue('AG3', "ET:BT");
$excel->setActiveSheetIndex(0)->setCellValue('AH3', "CRANE DENSITY");
$excel->setActiveSheetIndex(0)->setCellValue('AI3', "BSH BT");
$excel->setActiveSheetIndex(0)->setCellValue('AJ3', "BSH BWT");
$excel->setActiveSheetIndex(0)->setCellValue('AK3', "BSH ET");
$excel->setActiveSheetIndex(0)->setCellValue('AL3', "BCH BT");
$excel->setActiveSheetIndex(0)->setCellValue('AM3', "BCH BWT");
$excel->setActiveSheetIndex(0)->setCellValue('AN3', "BCH ET");
$excel->setActiveSheetIndex(0)->setCellValue('AO3', "BERTH FR METRE");
$excel->setActiveSheetIndex(0)->setCellValue('AP3', "BERTH TO METRE");
$excel->setActiveSheetIndex(0)->setCellValue('AQ3', "OCEAN INTERISLAND");
$excel->setActiveSheetIndex(0)->setCellValue('AR3', "INFO");
$excel->setActiveSheetIndex(0)->setCellValue('AS3', "VES TYPE");
$excel->setActiveSheetIndex(0)->setCellValue('AT3', "BTOA SIDE");

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
$excel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AK3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AL3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AM3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AN3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AO3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AP3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AQ3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AR3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AS3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('AT3')->applyFromArray($style_col);

$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach($data as $no => $val){ // Lakukan looping pada variabel siswa

  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no+1);
  $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val->ocean_interisland_fake);
  $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val->ves_id);
  $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val->ves_name);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val->ves_code);
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val->next_port);
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val->dest_port);
  $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val->loa);
  $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val->agent);
  $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val->agent_name);
  $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val->ves_service);
  $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $val->est_disc);
  $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $val->est_load);
  $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $val->bsh);
  $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $val->est_pilot_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $val->req_berth_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $val->est_berth_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $val->est_dep_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $val->crane);
  $excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $val->disc);
  $excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $val->load);
  $excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $val->hatch_cover);
  $excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $val->move);
  $excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $val->act_berth_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $val->act_start_work_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $val->act_end_work_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, $val->act_dep_ts);
  $excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, $val->berthingtime);
  $excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, $val->workingtime);
  $excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, $val->et);
  $excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, $val->r_it);
  $excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, $val->r_not);
  $excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, $val->etbt);
  $excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, $val->crane_density);
  $excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, $val->bsh_bt);
  $excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, $val->bsh_bwt);
  $excel->setActiveSheetIndex(0)->setCellValue('AK'.$numrow, $val->bsh_et);
  $excel->setActiveSheetIndex(0)->setCellValue('AL'.$numrow, $val->bch_bt);
  $excel->setActiveSheetIndex(0)->setCellValue('AM'.$numrow, $val->bch_bwt);
  $excel->setActiveSheetIndex(0)->setCellValue('AN'.$numrow, $val->bch_et);
  $excel->setActiveSheetIndex(0)->setCellValue('AO'.$numrow, $val->berth_fr_metre);
  $excel->setActiveSheetIndex(0)->setCellValue('AP'.$numrow, $val->berth_to_metre);
  $excel->setActiveSheetIndex(0)->setCellValue('AQ'.$numrow, $val->ocean_interisland);
  $excel->setActiveSheetIndex(0)->setCellValue('AR'.$numrow, $val->info);
  $excel->setActiveSheetIndex(0)->setCellValue('AS'.$numrow, $val->ves_type);
  $excel->setActiveSheetIndex(0)->setCellValue('AT'.$numrow, $val->btoa_side);
  
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
  $excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AK'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AL'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AM'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AN'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AO'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AP'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AQ'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AR'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AS'.$numrow)->applyFromArray($style_row);
  $excel->getActiveSheet()->getStyle('AT'.$numrow)->applyFromArray($style_row);

  $numrow++; // Tambah 1 setiap kali looping
}
// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
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
$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AK')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AL')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AM')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AN')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AO')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AP')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AR')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AS')->setWidth(20); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('AT')->setWidth(20); // Set width kolom A

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