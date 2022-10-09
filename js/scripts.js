$(document).ready(function () {
  // get first country base data
  $(document).on("change", "#get_first_country", function () {
    var country_name = $(this).val();

    $.ajax({
      type: "POST",
      data: { country_name: country_name },
      url: "server.php",
      beforeSend: function () {
        $("body").addClass("loading");
      },
      success: function (data) {
        var get_first_country = $(
          "select#get_first_country option:selected"
        ).text();
        $("#first_country_name").html(get_first_country);
        var json = JSON.parse(data);
        $("#first_info_hits_value").html(json.info_hits_value);
        $("#first_info_hits_relation").html(json.info_hits_relation);
        $("#first_info_hits_page").html(json.info_hits_page);
        $("#first_facets_unit_data").html(json.facets_unit_data);
        $("#first_facets_country_data").html(json.facets_country_data);
        $("#first_facets_currency_data").html(json.facets_currency_data);
        $("#first_facets_category_data").html(json.facets_category_data);
        $("#first_facets_type_data").html(json.facets_type_data);
        $("#first_facets_group_data").html(json.facets_group_data);
        $("#first_facets_frequency_data").html(json.facets_frequency_data);
        $("#first_all_hits_data").html(json.all_hits_data);
      },
      complete: function (data) {
        $("body").removeClass("loading");
      },
    });
  });

  // get second country base data
  $(document).on("change", "#get_second_country", function () {
    var country_name = $(this).val();

    $.ajax({
      type: "POST",
      data: { country_name: country_name },
      url: "server.php",
      beforeSend: function () {
        $("body").addClass("loading");
      },
      success: function (data) {
        var get_second_country = $(
          "select#get_second_country option:selected"
        ).text();
        $("#second_country_name").html(get_second_country);
        var json = JSON.parse(data);
        $("#second_info_hits_value").html(json.info_hits_value);
        $("#second_info_hits_relation").html(json.info_hits_relation);
        $("#second_info_hits_page").html(json.info_hits_page);
        $("#second_facets_unit_data").html(json.facets_unit_data);
        $("#second_facets_country_data").html(json.facets_country_data);
        $("#second_facets_currency_data").html(json.facets_currency_data);
        $("#second_facets_category_data").html(json.facets_category_data);
        $("#second_facets_type_data").html(json.facets_type_data);
        $("#second_facets_group_data").html(json.facets_group_data);
        $("#second_facets_frequency_data").html(json.facets_frequency_data);
        $("#second_all_hits_data").html(json.all_hits_data);
      },
      complete: function (data) {
        $("body").removeClass("loading");
      },
    });
  });

  // get country base data
  $(document).on("change", "#get_country", function () {
    var country_name = $(this).val();
    var selected_value = $("select#get_country option:selected").text();
    if (country_name) {
      $("#hdn_country_name").val(country_name);
      $("#btn_exports_data").html("Export " + selected_value + " Data");
      $.ajax({
        type: "POST",
        data: { country_name: country_name },
        url: "server.php",
        beforeSend: function () {
          $("body").addClass("loading");
        },
        success: function (data) {
          $("#text_selected_country").html(selected_value);
          $("#div_main_info_hits").removeClass("hide");
          var json = JSON.parse(data);
          $("#info_hits_value").html(json.info_hits_value);
          $("#info_hits_relation").html(json.info_hits_relation);
          $("#info_hits_page").html(json.info_hits_page);
          $("#facets_unit_data").html(json.facets_unit_data);
          $("#facets_country_data").html(json.facets_country_data);
          $("#facets_currency_data").html(json.facets_currency_data);
          $("#facets_category_data").html(json.facets_category_data);
          $("#facets_type_data").html(json.facets_type_data);
          $("#facets_group_data").html(json.facets_group_data);
          $("#facets_frequency_data").html(json.facets_frequency_data);
          $("#all_hits_data").html(json.all_hits_data);
        },
        complete: function (data) {
          $("body").removeClass("loading");
        },
      });
    } else {
      $("#div_main_info_hits").addClass("hide");
    }
  });

  // root drop down
  $(document).on("change", "#root_drop_down_list", function () {
    var value = $(this).val();
    if (value == "info") {
      $("#div_all_info_list").removeClass("hide");
      $("#div_all_hits_list").addClass("hide");
    } else {
      $("#div_all_info_list").addClass("hide");
      $("#div_all_hits_list").removeClass("hide");
    }
  });

  // all info drop down
  $(document).on("change", "#all_info_list", function () {
    var value = $(this).val();
    if (value == "facets") {
      $("#div_info_facets_list").removeClass("hide");
    } else {
      $("#div_info_facets_list").addClass("hide");
    }
  });

  // all info drop down
  $(document).on("change", "#info_facets_list", function () {
    var value = $(this).val();
    var selected_value = $("select#info_facets_list option:selected").text();
    var country_name = $("#get_country").val();
    load_monthwise_data(value, "Show Data For", country_name, selected_value);
  });

  // download data with xls file
  $("#btn_exports_data").on("click", function () {
    var country_name = $("#get_country").val();
    if (country_name) {
      $.ajax({
        url: "export.php",
        type: "POST",
        data: {
          country_name: country_name,
        },
        cache: false,
        success: function (dataResult) {
          window.open("export.php?country_name=" + country_name);
        },
      });
    } else {
      alert("Please select Country");
      return false;
    }
  });
});

google.charts.load("current", { packages: ["corechart", "bar"] });
google.charts.setOnLoadCallback();

function load_monthwise_data(data_type, title, country_name, selected_value) {
  var temp_title = title + " " + selected_value + "";
  $.ajax({
    url: "graph.php",
    method: "POST",
    data: { data_type: data_type, country_name: country_name },
    dataType: "JSON",
    beforeSend: function () {
      $("body").addClass("loading");
    },
    success: function (data) {
      console.log("data", data);
      document.getElementById("chart_area").innerHTML = "";
      if (data) drawDataChart(data, temp_title);
      else document.getElementById("chart_area").innerHTML = "No Data Found!";
    },
    complete: function () {
      $("body").removeClass("loading");
    },
  });
}

function drawDataChart(chart_data, chart_main_title) {
  var jsonData = chart_data;
  var data = new google.visualization.DataTable();
  data.addColumn("string", "Key");
  data.addColumn("number", "Doc Count");
  $.each(jsonData, function (i, jsonData) {
    var key_data = jsonData.key_data;
    var count_data = parseFloat($.trim(jsonData.count_data));
    data.addRows([[key_data, count_data]]);
  });
  var options = {
    title: chart_main_title,
    hAxis: {
      title: "Key",
    },
    vAxis: {
      title: "Doc Count",
    },
  };

  var chart = new google.visualization.ColumnChart(
    document.getElementById("chart_area")
  );
  chart.draw(data, options);
}
