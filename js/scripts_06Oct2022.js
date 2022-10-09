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
    console.log("name", country_name);
    $.ajax({
      type: "POST",
      data: { country_name: country_name },
      url: "server.php",
      beforeSend: function () {
        $("body").addClass("loading");
      },
      success: function (data) {
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
  });

  // root drop down
  $(document).on("change", "#root_drop_down_list", function () {
    var value = $(this).val();
    if (value == "info") {
      $("#div_all_info_list").removeClass("hide");
      $("#div_all_hits_list").addClass("hide");
      // facets_unit_grpah();
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
    // facets_unit_grpah();
  });

  // all info drop down
  $(document).on("change", "#info_facets_list", function () {
    var value = $(this).val();
    var country_name = $("#get_country").val();
    var data = "";
    // data = graph_data(value, country_name);
    // console.log("data.data", data);
    // facets_unit_grpah(data.key_data, data.count_data);
    load_monthwise_data(value, "Month Wise Profit Data For", country_name);
  });

  // Facets Unit graph
  function facets_unit_grpah(key_data, count_data) {
    console.log("data.key_data", key_data);
    console.log("data.count_data", count_data);
    var xValues = [key_data];
    var yValues = [count_data];
    // var xValues = ["Percent", "Persons", "LCU"];
    // var yValues = [361, 327, 8];
    // var xValues = [
    //   "Percent",
    //   "Persons",
    //   "LCU",
    //   "Year",
    //   "Day",
    //   "GPI",
    //   "Hour",
    //   "Kilometer",
    //   "Square",
    //   "100",
    //   "People",
    //   "Per",
    //   "Ha",
    //   "Kwh",
    // ];
    // var yValues = [668, 366, 78, 30, 11, 11, 5, 5, 5, 4, 4, 4, 2, 1];

    var barColors = ["red", "green", "blue", "orange", "brown"];

    new Chart("myChart", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [
          {
            backgroundColor: barColors,
            data: yValues,
          },
        ],
      },
      options: {
        legend: { display: false },
        title: {
          display: true,
          text: "World Wine Production 2018",
        },
      },
    });
  }
  // Graph server Data
  function graph_data(data_type, country_name) {
    var all_data = "";
    $.ajax({
      type: "POST",
      async: false,
      // dataType: "JSON",
      data: { data_type: data_type, country_name: country_name },
      url: "graph.php",
      success: function (data) {
        // console.log("data", data);
        all_data = JSON.parse(data);
        // console.log("all_data", all_data);
      },
    });
    return all_data;
  }
});

google.charts.load("current", { packages: ["corechart", "bar"] });
google.charts.setOnLoadCallback();

function load_monthwise_data(data_type, title, country_name) {
  var temp_title = title + " " + data_type + "";
  $.ajax({
    url: "graph.php",
    method: "POST",
    data: { data_type: data_type, country_name: country_name },
    dataType: "JSON",
    success: function (data) {
      // console.log("data", data);
      // return false;
      drawMonthwiseChart(data, temp_title);
    },
  });
}

function drawMonthwiseChart(chart_data, chart_main_title) {
  console.log("chart_data", chart_data);
  var jsonData = chart_data;
  var data = new google.visualization.DataTable();
  data.addColumn("string", "Month");
  data.addColumn("number", "Profit");
  $.each(jsonData, function (i, jsonData) {
    var key_data = jsonData.key_data;
    var count_data = parseFloat($.trim(jsonData.count_data));
    data.addRows([[key_data, count_data]]);
  });
  var options = {
    title: chart_main_title,
    hAxis: {
      title: "Months",
    },
    vAxis: {
      title: "Profit",
    },
  };

  var chart = new google.visualization.ColumnChart(
    document.getElementById("chart_area")
  );
  chart.draw(data, options);
}
