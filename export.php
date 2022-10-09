<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['country_name']) && !empty($_POST['country_name'])){
  $all_data = "";
  $country_name = $_POST['country_name'];
  $url = 'https://brains.tradingeconomics.com/v2/search/wb,fred,comtrade?q='.$country_name.'&pp=50&p=0&_=1557934352427&stance=2';
  $headers = array(
      "Accept: application/json",
      "Authorization: Client guest:guest"
  );
  $handle = curl_init(); 
  curl_setopt($handle, CURLOPT_URL, $url);
  curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

  $data = curl_exec($handle);
  curl_close($handle);
  //showing result
  $data = json_decode($data, true);

  // All info Data
  $info_data = $data['info'];
  
  // Cell 
  $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O');
  
  // Creates New Spreadsheet
  $spreadsheet = new Spreadsheet();
  
  // Retrieve the current active worksheet
  $sheet = $spreadsheet->getActiveSheet();
  
  // // Sets the width of cells
  for ($i=0; $i < 15 ; $i++) { 
    $spreadsheet->getActiveSheet()->getColumnDimension($alphabet[$i])->setWidth(20);
  }
  
  // Heading
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'TRADING ECONOMICS');
  $spreadsheet->getActiveSheet()->mergeCells("A1:B1");
  $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);
  
  // Country Name
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('C1', strtoupper($country_name));
    $spreadsheet->getActiveSheet()->mergeCells("C1:E1");
  $spreadsheet->getActiveSheet()->getStyle("C1")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("C1")->getFont()->setSize(16);

  $spreadsheet->getActiveSheet()->setCellValue("A3", "Hits");
  $spreadsheet->getActiveSheet()->getStyle("A3")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("A3")->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue("B3", "Value");
  $spreadsheet->getActiveSheet()->getStyle("B3")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("B3")->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue("C3", "Relation");
  $spreadsheet->getActiveSheet()->getStyle("C3")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("C3")->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue("D3", "Page");
  $spreadsheet->getActiveSheet()->getStyle("D3")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("D3")->getFont()->setSize(12);

  // Info Hits Data
  $info_hits_value = $info_hits_relation = $info_hits_page = "";
  if($info_data['hits']){
    $info_hits_value = $info_data['hits']['value'];
    $info_hits_relation = $info_data['hits']['relation'];
  } else {
    $info_hits_value = "N/A";
    $info_hits_relation = "N/A";
  }
  // Info Page Data
  if($info_data['page'] == 0){
    $info_hits_page = 0;
  } else {
    $info_hits_page = $info_data['page'];
  }

  $spreadsheet->getActiveSheet()->setCellValue("A4", "");
  $spreadsheet->getActiveSheet()->setCellValue("B4", $info_hits_value);
  $spreadsheet->getActiveSheet()->setCellValue("C4", $info_hits_relation);
  $spreadsheet->getActiveSheet()->setCellValue("D4", $info_hits_page);

  // Country Data Heading
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A6', 'COUNTRY');
  $spreadsheet->getActiveSheet()->mergeCells("A6:E6");
  $spreadsheet->getActiveSheet()->getStyle("A6")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("A6")->getFont()->setSize(15);

  // Facets Country Unit Data Heading
  $spreadsheet->getActiveSheet()->setCellValue("A8", "Key");
  $spreadsheet->getActiveSheet()->getStyle("A8")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("A8")->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue("B8", "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle("B8")->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle("B8")->getFont()->setSize(12);

  // Facets Country Unit Data
  $country_data = $info_data['facets'];
  $column_country = 9;
  if($country_data['country']){
    foreach($country_data['country'] as $index => $country){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_country, $country['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_country, $country['doc_count']);
      $column_country++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_country, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_country, 0);
  }

  // Facets Unit Data Heading
  $column_unit = $column_country + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_unit, 'UNIT');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_unit.":".$alphabet[4].$column_unit);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_unit)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_unit)->getFont()->setSize(15);

  $column_unit = $column_unit + 2;  
  $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_unit, "Key");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_unit)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_unit)->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_unit, "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_unit)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_unit)->getFont()->setSize(12);

  // Facets Unit Data
  $unit_data = $info_data['facets'];
  $column_unit = $column_unit + 1;
  if($unit_data['unit']){
    foreach($unit_data['unit'] as $index => $unit){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_unit, $unit['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_unit, $unit['doc_count']);
      $column_unit++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_unit, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_unit, 0);
  }

  // Facets Currency Data Heading
  $column_currency = $column_unit + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_currency, 'Currency');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_currency.":".$alphabet[4].$column_currency);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_currency)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_currency)->getFont()->setSize(15);

  $column_currency = $column_currency + 2;  
  $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_currency, "Key");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_currency)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_currency)->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_currency, "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_currency)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_currency)->getFont()->setSize(12);

  // Facets currency Data
  $currency_data = $info_data['facets'];
  $column_currency = $column_currency + 1;
  if($currency_data['currency']){
    foreach($currency_data['currency'] as $index => $currency){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_currency, $currency['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_currency, $currency['doc_count']);
      $column_currency++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_currency, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_currency, 0);
  }

  // Facets Category Data Heading
  $column_category = $column_currency + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_category, 'Category');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_category.":".$alphabet[4].$column_category);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_category)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_category)->getFont()->setSize(15);

  $column_category = $column_category + 2;  
  $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_category, "Key");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_category)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_category)->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_category, "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_category)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_category)->getFont()->setSize(12);

  // Facets category Data
  $category_data = $info_data['facets'];
  $column_category = $column_category + 1;
  if($category_data['category']){
    foreach($category_data['category'] as $index => $category){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_category, $category['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_category, $category['doc_count']);
      $column_category++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_category, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_category, 0);
  }

  // Facets Type Data Heading
  $column_type = $column_category + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_type, 'Type');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_type.":".$alphabet[4].$column_type);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_type)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_type)->getFont()->setSize(15);

  $column_type = $column_type + 2;  
  $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_type, "Key");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_type)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_type)->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_type, "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_type)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_type)->getFont()->setSize(12);

  // Facets type Data
  $type_data = $info_data['facets'];
  $column_type = $column_type + 1;
  if($type_data['type']){
    foreach($type_data['type'] as $index => $type){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_type, $type['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_type, $type['doc_count']);
      $column_type++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_type, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_type, 0);
  }

  // Facets Group Data Heading
  $column_group = $column_type + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_group, 'Group');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_group.":".$alphabet[4].$column_group);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_group)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_group)->getFont()->setSize(15);

  $column_group = $column_group + 2;  
  $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_group, "Key");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_group)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_group)->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_group, "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_group)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_group)->getFont()->setSize(12);

  // Facets Group Data
  $group_data = $info_data['facets'];
  $column_group = $column_group + 1;
  if($group_data['group']){
    foreach($group_data['group'] as $index => $group){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_group, $group['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_group, $group['doc_count']);
      $column_group++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_group, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_group, 0);
  }

  // Facets Frequency Data Heading
  $column_frequency = $column_group + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_frequency, 'Frequency');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_frequency.":".$alphabet[4].$column_frequency);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_frequency)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_frequency)->getFont()->setSize(15);

  $column_frequency = $column_frequency + 2;  
  $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_frequency, "Key");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_frequency)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_frequency)->getFont()->setSize(12);

  $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_frequency, "Doc Count");
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_frequency)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[1].$column_frequency)->getFont()->setSize(12);

  // Facets Frequency Data
  $frequency_data = $info_data['facets'];
  $column_frequency = $column_frequency + 1;
  if($frequency_data['frequency']){
    foreach($frequency_data['frequency'] as $index => $frequency){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_frequency, $frequency['key']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_frequency, $frequency['doc_count']);
      $column_frequency++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_frequency, 0);
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_frequency, 0);
  }

  // Hits Data

  // Hits Data Heading
  $column_hits = $column_frequency + 2;
  $spreadsheet->setActiveSheetIndex(0)
		->setCellValue($alphabet[0].$column_hits, 'Hits');
  $spreadsheet->getActiveSheet()->mergeCells($alphabet[0].$column_hits.":".$alphabet[4].$column_hits);
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_hits)->getFont()->setBold( true );
  $spreadsheet->getActiveSheet()->getStyle($alphabet[0].$column_hits)->getFont()->setSize(15);

  // Set all Hits in Array
  $hits_array_heading = array("Sr.","Country","Category","Currency","Iids","EsID","S","Importance","Name","Type","Group","Frequency","Unit","Pretty Name","URL");
  $column_hits = $column_hits + 2; 
  for ($i=0; $i < count($hits_array_heading); $i++) { 
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[$i].$column_hits, $hits_array_heading[$i]);
    $spreadsheet->getActiveSheet()->getStyle($alphabet[$i].$column_hits)->getFont()->setBold( true );
    $spreadsheet->getActiveSheet()->getStyle($alphabet[$i].$column_hits)->getFont()->setSize(12);
  } 

  // Facets Frequency Data
  $hits_data = $data['hits'];
  $column_hits_list = $column_hits + 1;
  $sr_no = 1;
  if($hits_data){
    foreach($hits_data as $index => $hits_list){
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_hits_list, $sr_no++);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[1].$column_hits_list, $hits_list['country']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[2].$column_hits_list, $hits_list['category']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[3].$column_hits_list, $hits_list['currency']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[4].$column_hits_list, $hits_list['iids']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[5].$column_hits_list, $hits_list['esID']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[6].$column_hits_list, $hits_list['s']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[7].$column_hits_list, $hits_list['importance']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[8].$column_hits_list, $hits_list['name']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[9].$column_hits_list, $hits_list['type']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[10].$column_hits_list, $hits_list['group']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[11].$column_hits_list, $hits_list['frequency']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[12].$column_hits_list, $hits_list['unit']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[13].$column_hits_list, $hits_list['pretty_name']);
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[14].$column_hits_list, $hits_list['url']);
      $column_hits_list++;
    }
  } else {
    $spreadsheet->getActiveSheet()->setCellValue($alphabet[0].$column_hits_list, 0);
    for ($i=1; $i < 15; $i++) { 
      $spreadsheet->getActiveSheet()->setCellValue($alphabet[$i].$column_hits_list, "N/A");
    }
    
  }
  
  // Write an .xlsx file
  $writer = new Xlsx($spreadsheet);
  $writer->setOffice2003Compatibility(true);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'. $country_name .'.xlsx"'); 
      header('Cache-Control: max-age=0');
      $writer->save('php://output'); // download file
      ob_flush(); //and this point <==========================================
  exit;
}