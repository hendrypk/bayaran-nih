  @extends('_layout.main')
  @section('title', 'Employees')
  @section('content')


    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.status') }}</h5>
            <canvas id="statusChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.gender') }}</h5>
            <canvas id="genderChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.duration') }}</h5>
            <canvas id="workDurationChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.education') }}</h5>
            <canvas id="educationChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.age') }}</h5>
            <canvas id="ageRangeChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.religion') }}</h5>
            <canvas id="religionChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('home.label.marital') }}</h5>
            <canvas id="maritalChart"></canvas>
            {{-- <div id="maritalChart"></div> --}}
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
document.addEventListener("DOMContentLoaded", function() {
  // Employee Status Summary Chart
  var ctx = document.getElementById('statusChart').getContext('2d');
  var statusLabels = {!! json_encode($employeeStatus) !!};
  var statusData = [{{ implode(',', array_values($employeeStatusSummary)) }}];
  
  //Function for random colors
  function generateRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
  }

  //set color foreach data
  var backgroundColors = statusData.map(function(data, index) {
      if (data === Math.max(...statusData)) {
          return '#118ab2';
      } else {
          return generateRandomColor();
      }
  });

  var statusChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: {!! json_encode($employeeStatus) !!}, 
          datasets: [{
              data: [{{ implode(',', array_values($employeeStatusSummary)) }}], 
              backgroundColor: backgroundColors,
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.label + ': ' + tooltipItem.raw;
                      }
                  }
              }
          },
          legend: {
              position: 'bottom',
              align: 'center'
          }
      }
  });

  // Gender Distribution Chart
  var ctx = document.getElementById('genderChart').getContext('2d');
  var genderChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: {!! json_encode(array_map(function($label) {
            return __('employee.options.gender.' . $label);
          }, array_keys($genderSummary))) !!},
          datasets: [{
              data: [{{ implode(',', array_values($genderSummary)) }}], 
              backgroundColor: ['#118ab2', '#06d6a0'], 
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.label + ': ' + tooltipItem.raw;
                      }
                  }
              }
          },
          legend: {
              position: 'bottom',
              align: 'center'
          }
      }
  });

  // Education Level Chart
  var ctx = document.getElementById('educationChart').getContext('2d');
  var educationChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_map(function($label) {
            return __('employee.options.education.' . $label); 
        }, array_keys($educationSummary))) !!},

          datasets: [{
              data: [{{ implode(',', array_values($educationSummary)) }}], 
              backgroundColor: '#118ab2', 
              borderColor: '#118ab2',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.raw; 
                      }
                  }
              }
          },
          plugins: {
            legend: {
                display: false
            }
        }
      }
  });

  // Age Range Chart
  var ctx = document.getElementById('ageRangeChart').getContext('2d');
  var ageRangeChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_map(function($label) {
            return __('employee.options.age_range.' . $label); 
        }, array_keys($ageSummary))) !!},

          datasets: [{
              data: [{{ implode(',', array_values($ageSummary)) }}], 
              backgroundColor: '#118ab2', 
              borderColor: '#118ab2',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.raw; 
                      }
                  }
              }
          },
          plugins: {
            legend: {
                display: false
            }
        }
      }
  });

  // Religion Chart
  var ctx = document.getElementById('religionChart').getContext('2d');
  var religionChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_map(function($label) {
            return __('employee.options.religion.' . $label); 
        }, array_keys($religionSummary))) !!},

          datasets: [{
              data: [{{ implode(',', array_values($religionSummary)) }}], 
              backgroundColor: '#118ab2', 
              borderColor: '#118ab2',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.raw; 
                      }
                  }
              }
          },
          plugins: {
            legend: {
                display: false
            }
        }
      }
  });

  // Marital Chart
  var ctx = document.getElementById('maritalChart').getContext('2d');
  var maritalChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_map(function($label) {
            return __('employee.options.marital_status.' . $label); 
        }, array_keys($maritalSummary))) !!},

          datasets: [{
              data: [{{ implode(',', array_values($maritalSummary)) }}], 
              backgroundColor: '#118ab2', 
              borderColor: '#118ab2',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.raw; 
                      }
                  }
              }
          },
          plugins: {
            legend: {
                display: false
            }
        }
      }
  });

  // WorkDuration Chart
  var ctx = document.getElementById('workDurationChart').getContext('2d');
  var workDurationChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_map(function($label) {
            return __('employee.options.work_duration.' . $label); 
        }, array_keys($workDurationSummary))) !!},

          datasets: [{
              data: [{{ implode(',', array_values($workDurationSummary)) }}], 
              backgroundColor: '#118ab2', 
              borderColor: '#118ab2',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              tooltip: {
                  callbacks: {
                      label: function(tooltipItem) {
                          return tooltipItem.raw; 
                      }
                  }
              }
          },
          plugins: {
            legend: {
                display: false
            }
        }
      }
  });
});
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