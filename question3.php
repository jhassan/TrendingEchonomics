<!DOCTYPE html>
<html lang="en">

<head>
  <title>TRADING ECONOMICS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
  .overlay {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255, 255, 255, 0.8) url("images/loader.gif") center no-repeat;
  }

  /* Turn off scrollbar when body element has the loading class */
  body.loading {
    overflow: hidden;
  }

  /* Make spinner image visible when body element has the loading class */
  body.loading .overlay {
    display: block;
  }
  </style>
</head>

<body>
  <?php include_once('country.php'); ?>
  <?php include_once('header.php'); ?>

  <div class="overlay"></div>
  <div class="container">
    <h2>TRADING ECONOMICS</h2>
    <table class="table table-striped">
      <tbody>
        <tr>
          <td width="25%">Select Country</td>
          <td width="25%">
            <select name="get_country" id="get_country" class="form-control">
              <option value="">Select Country</option>
              <?php if($countries){ ?>
              <?php foreach($countries as $country){ ?>
              <option value="<?php echo strtolower($country) ?>"><?php echo $country; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td width="25%"></td>
          <td width="25%"></td>
        </tr>
      </tbody>
    </table>

    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Hits</th>
          <th width="25%">Value</th>
          <th width="25%">Relation</th>
          <th width="25%">Page</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
          <td id="info_hits_value">N/A</td>
          <td id="info_hits_relation">N/A</td>
          <td id="info_hits_page">N/A</td>
        </tr>
      </tbody>
    </table>
    <h3>Facets</h3>
    <hr>
    <h4>Country</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_country_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>
    <hr>
    <h4>Unit</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_unit_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>

    <hr>
    <h4>Currency</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_currency_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>
    <hr>
    <h4>Category</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_category_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>
    <hr>
    <h4>Type</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_type_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>

    <hr>
    <h4>Group</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_group_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>

    <hr>
    <h4>Frequency</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
          <th width="25%">Key</th>
          <th width="25%">Doc Count</th>
        </tr>
      </thead>
      <tbody id="facets_frequency_data">
        <tr>
          <td colspan='4'>No Data Found!</td>
        </tr>
      </tbody>
    </table>

    <hr>
    <h4>Hits</h4>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Sr.</th>
            <th>Country</th>
            <th>Category</th>
            <th>Currency</th>
            <th>Iids</th>
            <th>EsID</th>
            <th>S</th>
            <th>Importance</th>
            <th>Name</th>
            <th>Type</th>
            <th>Group</th>
            <th>Frequency</th>
            <th>Unit</th>
            <th>Pretty Name</th>
            <th>URL</th>
          </tr>
        </thead>
        <tbody id="all_hits_data">
          <tr>
            <td colspan='15'>No Data Found!</td>
          </tr>
        </tbody>
      </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>