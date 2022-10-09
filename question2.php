<!DOCTYPE html>
<html lang="en">

<head>
  <title>TRADING ECONOMICS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->

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

  .margin-top-md {
    margin-top: 1em;
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
          <td width="25%" class="text-center">
            <h3 style="margin-top: 0;" id="text_selected_country"></h3>
          </td>
          <td width="25%"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="container">
    <div class="row margin-top-md hide" id="div_main_info_hits">
      <div class="col-sm-4">
        <label for="">Info</label>
        <select name="root_drop_down_list" id="root_drop_down_list" class="form-control">
          <option value="">Select</option>
          <option value="info">Info</option>
        </select>
      </div>
    </div>
    <div class="row margin-top-md hide" id="div_all_info_list">
      <div class="col-sm-4">
        <label for="">Info</label>
        <select name="all_info_list" id="all_info_list" class="form-control">
          <option value="">Select</option>
          <option value="facets">Facets</option>
        </select>
      </div>
    </div>
    <div class="row margin-top-md hide" id="div_info_facets_list">
      <div class="col-sm-4">
        <label for="">Facets</label>
        <select name="info_facets_list" id="info_facets_list" class="form-control">
          <option value="">Select</option>
          <option value="country">Country</option>
          <option value="unit">Unit</option>
          <option value="currency">Currency</option>
          <option value="category">Category</option>
          <option value="type">Type</option>
          <option value="group">Group</option>
          <option value="frequency">Frequency</option>
        </select>
      </div>
    </div>
    <div class="row margin-top-md hide" id="div_all_hits_list">
      <div class="col-sm-4">
        <label for="">Hits</label>
        <select name="all_hits_list" id="all_hits_list" class="form-control">
          <option value="">Select</option>
          <option value="info">Info</option>
          <option value="hits">Hits</option>
        </select>
      </div>
    </div>
  </div>
  <div class="container margin-top-md" id="div_graphs_info">
    <div class="row">
      <div class="col-sm-12">
        <div id="chart_area" style="height: 620px;"></div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="js/scripts.js"></script>
  <style>
  .hide {
    display: none !important;
  }
  </style>
</body>

</html>