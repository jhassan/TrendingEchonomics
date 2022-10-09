<?php
if(isset($_POST['country_name']) && !empty($_POST['country_name'])){
  $all_data = [];
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

  // Info Hits Data
  if($info_data['hits']){
    $all_data['info_hits_value'] = $info_data['hits']['value'];
    $all_data['info_hits_relation'] = $info_data['hits']['relation'];
  } else {
    $all_data['info_hits_value'] = "N/A";
    $all_data['info_hits_relation'] = "N/A";
  }

  // Info Page Data
  if($info_data['page'] == 0){
    $all_data['info_hits_page'] = 0;
  } else {
    $all_data['info_hits_page'] = $info_data['page'];
  }

  // Info Facets Data
  if($info_data['facets']){
    $unit_data = $info_data['facets'];
    // Country Data
    if($unit_data['country']){
      $country_txt = "";
      foreach($unit_data['country'] as $index => $country){
        if(($index % 2 == 0))
          $country_txt .= "<tr>";
            $country_txt .= "<td>".$country['key']."</td>";
            $country_txt .= "<td>".$country['doc_count']."</td>";
        if(($index % 2 != 0))    
          $country_txt .= "</tr>";
      }
      $all_data['facets_country_data'] = $country_txt;
    } else {
      $all_data['facets_country_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }

    // Unit Data
    if($unit_data['unit']){
      $unit_txt = "";
      foreach($unit_data['unit'] as $index => $unit){
        if(($index % 2 == 0))
          $unit_txt .= "<tr>";
            $unit_txt .= "<td>".$unit['key']."</td>";
            $unit_txt .= "<td>".$unit['doc_count']."</td>";
        if(($index % 2 != 0))    
          $unit_txt .= "</tr>";
      }
      $all_data['facets_unit_data'] = $unit_txt;
    } else {
      $all_data['facets_unit_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }

    // Currency Data
    if($unit_data['currency']){
      $currency_txt = "";
      foreach($unit_data['currency'] as $index => $currency){
        if(($index % 2 == 0))
          $currency_txt .= "<tr>";
            $currency_txt .= "<td>".$currency['key']."</td>";
            $currency_txt .= "<td>".$currency['doc_count']."</td>";
        if(($index % 2 != 0))    
          $currency_txt .= "</tr>";
      }
      $all_data['facets_currency_data'] = $currency_txt;
    } else {
      $all_data['facets_currency_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }

    // Category Data
    if($unit_data['category']){
      $currency_txt = "";
      foreach($unit_data['category'] as $index => $category){
        if(($index % 2 == 0))
          $category_txt .= "<tr>";
            $category_txt .= "<td>".$category['key']."</td>";
            $category_txt .= "<td>".$category['doc_count']."</td>";
        if(($index % 2 != 0))    
          $category_txt .= "</tr>";
      }
      $all_data['facets_category_data'] = $category_txt;
    } else {
      $all_data['facets_category_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }

    // Type Data
    if($unit_data['type']){
      $type_txt = "";
      foreach($unit_data['type'] as $index => $type){
        if(($index % 2 == 0))
          $type_txt .= "<tr>";
            $type_txt .= "<td>".$type['key']."</td>";
            $type_txt .= "<td>".$type['doc_count']."</td>";
        if(($index % 2 != 0))    
          $type_txt .= "</tr>";
      }
      $all_data['facets_type_data'] = $type_txt;
    } else {
      $all_data['facets_type_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }

    // Group Data
    if($unit_data['group']){
      $group_txt = "";
      foreach($unit_data['group'] as $index => $group){
        if(($index % 2 == 0))
          $group_txt .= "<tr>";
            $group_txt .= "<td>".$group['key']."</td>";
            $group_txt .= "<td>".$group['doc_count']."</td>";
        if(($index % 2 != 0))    
          $group_txt .= "</tr>";
      }
      $all_data['facets_group_data'] = $group_txt;
    } else {
      $all_data['facets_group_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }

    // Frequency Data
    if($unit_data['frequency']){
      $frequency_txt = "";
      foreach($unit_data['frequency'] as $index => $frequency){
        if(($index % 2 == 0))
          $frequency_txt .= "<tr>";
            $frequency_txt .= "<td>".$frequency['key']."</td>";
            $frequency_txt .= "<td>".$frequency['doc_count']."</td>";
        if(($index % 2 != 0))    
          $frequency_txt .= "</tr>";
      }
      $all_data['facets_frequency_data'] = $frequency_txt;
    } else {
      $all_data['facets_frequency_data'] = "<tr><td colspan='4'>No Data Found!</td></tr>";
    }
  }

  // All Hits Data
  $hits_data = $data['hits'];
  if($hits_data){
    $hits_text = "";
    $count = 1;
    foreach($hits_data as $hdata){
      $hits_text .= "<tr>";
      $hits_text .= "<td>".$count."</td>";
      $hits_text .= "<td>".$hdata['country']."</td>";
      $hits_text .= "<td>".$hdata['category']."</td>";
      $hits_text .= "<td>".$hdata['currency']."</td>";
      $hits_text .= "<td>".$hdata['iids']."</td>";
      $hits_text .= "<td>".$hdata['esID']."</td>";
      $hits_text .= "<td>".$hdata['s']."</td>";
      $hits_text .= "<td>".$hdata['importance']."</td>";
      $hits_text .= "<td>".$hdata['name']."</td>";
      $hits_text .= "<td>".$hdata['type']."</td>";
      $hits_text .= "<td>".$hdata['group']."</td>";
      $hits_text .= "<td>".$hdata['frequency']."</td>";
      $hits_text .= "<td>".$hdata['unit']."</td>";
      $hits_text .= "<td>".$hdata['pretty_name']."</td>";
      $hits_text .= "<td>".$hdata['url']."</td>";
      $hits_text .= "</tr>";
      $count++;
    }
    $all_data['all_hits_data'] = $hits_text;
  } else {
    $all_data['all_hits_data'] = "<tr><td colspan='15'>No Data Found!</td></tr>";
  }
    
  echo json_encode($all_data);

} else {
  echo "not found country";
}