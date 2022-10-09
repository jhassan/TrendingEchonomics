<?php
if(isset($_POST['country_name']) && !empty($_POST['country_name'])){
  $all_data = "";
  $country_name = $_POST['country_name'];
  $data_type = $_POST['data_type'];
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

  // check data from
  $output = [];
  switch ($data_type) {
    // Data For Unit
    case 'unit':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
          // Unit Data
          if($unit_data['unit']){
            $unit_txt = $all_key = $all_count = "";
            foreach($unit_data['unit'] as $index => $unit){
              $output[] = array(
                'key_data'   => $unit['key'],
                'count_data'  => floatval($unit['doc_count'])
              );
            }
            echo json_encode($output);
          } else {
            echo json_encode($output);
          }
        } 
    break;

    // Data For Type
    case 'type':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
          // Type Data
          if($unit_data['type']){
            $type_txt = $all_key = $all_count = "";
            foreach($unit_data['type'] as $index => $type){
              $output[] = array(
                'key_data'   => $type['key'],
                'count_data'  => floatval($type['doc_count'])
              );
            }
            echo json_encode($output);
          } else {
            echo json_encode($output);
          }
        } 
    break;

    // Data For Group
    case 'group':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
          // Group Data
          if($unit_data['group']){
            $group_txt = $all_key = $all_count = "";
            foreach($unit_data['group'] as $index => $group){
              $output[] = array(
                'key_data'   => $group['key'],
                'count_data'  => floatval($group['doc_count'])
              );
            }
            echo json_encode($output);
          } else {
            echo json_encode($output);
          }
        } 
    break;

    // Data For Currency
    case 'currency':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
          // Currency Data
          if($unit_data['currency']){
            $currency_txt = $all_key = $all_count = "";
            foreach($unit_data['currency'] as $index => $currency){
              $output[] = array(
                'key_data'   => $currency['key'],
                'count_data'  => floatval($currency['doc_count'])
              );
            }
            echo json_encode($output);
          } else {
            echo json_encode($output);
          }
        } 
    break;

    // Data For Frequency
    case 'frequency':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
          // Frequency Data
          if($unit_data['frequency']){
            $frequency_txt = $all_key = $all_count = "";
            foreach($unit_data['frequency'] as $index => $frequency){
              $output[] = array(
                'key_data'   => $frequency['key'],
                'count_data'  => floatval($frequency['doc_count'])
              );
            }
            echo json_encode($output);
          } else {
            echo json_encode($output);
          }
        } 
    break;

    // Get Country Data
    case 'country':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
        // Country Data
        if($unit_data['country']){
          $country_txt = $all_key = $all_count = "";
          foreach($unit_data['country'] as $index => $country){
            $output[] = array(
              'key_data'   => $country['key'],
              'count_data'  => floatval($country['doc_count'])
            );
          }
          echo json_encode($output);
        } else {
          echo json_encode($output);
        }
      } 
    break;

    // Get Category Data
    case 'category':
      // Info Facets Data
      if($info_data['facets']){
        $unit_data = $info_data['facets'];
        // Category Data
        if($unit_data['category']){
          $category_txt = $all_key = $all_count = "";
          foreach($unit_data['category'] as $index => $category){
            $output[] = array(
              'key_data'   => $category['key'],
              'count_data'  => floatval($category['doc_count'])
            );
          }
          echo json_encode($output);
        } else {
          echo json_encode($output);
        }
      } 
    break;
  }

} else {
  echo "not found country";
}