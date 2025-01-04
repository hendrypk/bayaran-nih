  @extends('_layout.main')
  @section('title', 'Employees')
  @section('content')


    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Employee Status</h5>
            <div id="statusChart" class="d-flex justify-content-center align-items-center"></div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Employee Gender</h5>
            <div id="genderChart" class="d-flex justify-content-center align-items-center"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Work Duration</h5>
            <div id="workDurationChart" class="d-flex justify-content-center align-items-center"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Education Level</h5>
            <div id="educationChart"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Age Range</h5>
            <div id="ageRangeChart"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Religion</h5>
            <div id="religionChart"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Marital</h5>
            <div id="maritalChart"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      {{-- <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Marital</h5>
            <div id="maritalChart"></div>
          </div>
        </div>
      </div> --}}
    </div>



  <script>
    // Employee Status Summary Chart
    var optionsStatus = {
        series: [{{ implode(',', array_values($statusSummary)) }}],
        chart: {
            type: 'pie',
            width: '400px',
            height: '300px'
        },
        labels: {!! json_encode($employeeStatus) !!},
        legend: {
          position: 'bottom', // Positions the legend at the bottom of the chart
          horizontalAlign: 'center', // Centers the legend horizontally
          floating: false, // Makes sure the legend is positioned statically below the chart
    },
    };
    var statusChart = new ApexCharts(document.querySelector("#statusChart"), optionsStatus);
    statusChart.render();

    // Gender Distribution Chart
    // var optionsGender = {
    //     series: [{{ implode(',', array_values($genderSummary)) }}],
    //     chart: {
    //         type: 'pie',
    //         width: '400px',
    //         height: '300px'
    //     },
    //     xaxis: {
    //         categories: {!! json_encode(array_keys($genders)) !!}
    //     },
    // };
    // var genderChart = new ApexCharts(document.querySelector("#genderChart"), optionsGender);
    // genderChart.render();
    var optionsGender = {
        series: [{{ implode(',', array_values($genderSummary)) }}], // Pie chart data
        chart: {
            type: 'pie', // Set chart type to 'pie'
            width: '600px',
            height: '300px'
        },
        labels: {!! json_encode($genders) !!}, // Set the labels for the pie chart
        legend: {
            position: 'bottom', // Position legend below the pie chart
            horizontalAlign: 'center', // Center the legend
        },
    };

  var genderChart = new ApexCharts(document.querySelector("#genderChart"), optionsGender);
  genderChart.render();


    // Education Level Chart
    var optionsEducation = {
        series: [{
            data: [{{ implode(',', array_values($educationSummary)) }}]
        }],
        chart: {
            type: 'bar',
            width: '600px',
            height: '300px'

        },
        xaxis: {
            categories: {!! json_encode(array_keys($educationSummary)) !!}
        },
    };
    var educationChart = new ApexCharts(document.querySelector("#educationChart"), optionsEducation);
    educationChart.render();

    // Age Range Chart
    var optionAge = {
        series: [{
            data: [{{ implode(',', array_values($ageSummary)) }}]
        }],
        chart: {
            type: 'bar',
            width: '600px',
            height: '300px'

        },
        xaxis: {
            categories: {!! json_encode(array_keys($ageSummary)) !!}
        },
    };
    var ageRangeChart = new ApexCharts(document.querySelector("#ageRangeChart"), optionAge);
    ageRangeChart.render();

    // Religion Chart
    var optionReligion = {
        series: [{
            data: [{{ implode(',', array_values($religionSummary)) }}]
        }],
        chart: {
            type: 'bar',
            width: '600px',
            height: '300px'

        },
        xaxis: {
            categories: {!! json_encode($religions) !!}
        },
    };
    var religionChart = new ApexCharts(document.querySelector("#religionChart"), optionReligion);
    religionChart.render();
  
    // Marrital Chart
    var optionMarital = {
        series: [{
            data: [{{ implode(',', array_values($maritalSummary)) }}]
        }],
        chart: {
            type: 'bar',
            width: '600px',
            height: '300px'

        },
        xaxis: {
            categories: {!! json_encode($marriage) !!}
        },
    };
    var maritalChart = new ApexCharts(document.querySelector("#maritalChart"), optionMarital);
    maritalChart.render();

    // WorkDuration Chart
    var workDuration = {
        series: [{
            data: [{{ implode(',', array_values($workDurationSummary)) }}]
        }],
        chart: {
            type: 'bar',
            width: '600px',
            height: '285px'

        },
        xaxis: {
            categories: {!! json_encode(array_keys($workDurationSummary)) !!}
        },
    };
    var workDurationChart = new ApexCharts(document.querySelector("#workDurationChart"), workDuration);
    workDurationChart.render();

  </script>

  {{-- <main>
      <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
          <h2>UNDER CONSTRUCTION, BUD!</h2>
          <a class="btn" href="{{route('home')}}">Back to home</a>
          <img src="assets/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
        </section>

      </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> --}}

  @endsection