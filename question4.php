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
          <td width="25%">
            <form action="export.php" method="post">
              <input type="hidden" name="country_name" id="hdn_country_name" value="">
              <button class="btn btn-success" id="btn_exports_data" type="submit">Export Country
                Data</button>
            </form>

          </td>
          <td width="25%"></td>
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