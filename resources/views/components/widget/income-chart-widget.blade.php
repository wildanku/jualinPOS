@push('css')
    <style>
      #cashflow {
        height: 50vh;
      }

      @media screen and (max-width: 480px) {
        #cashflow {
          height: 35vh;
        }
      }
    </style>
@endpush
<div class="bg-white p-4 rounded-lg">
  <div class="w-full md:flex justify-between pb-4">
    <h3 class="text-xl md:text-2xl">{{__('widget.chart_recap')}}</h3>
    <div class="py-2 md:py-0">
      <button id="btnDaily" onclick="loadCashflow('daily')" class="border border-primary text-primary py-1 px-4 rounded-lg">{{__('general.daily')}}</button>
      <button id="btnWeekly" onclick="loadCashflow('weekly')" class="border border-primary text-primary py-1 px-4 rounded-lg">{{__('general.weekly')}}</button>
      <button id="btnDaily" onclick="loadCashflow('monthly')" class="border border-primary text-primary py-1 px-4 rounded-lg">{{__('general.monthly')}}</button>
    </div>
  </div>
  <div>
    <canvas id="cashflow" style="widht:100%;"></canvas>
  </div>
</div>

@push('js')
    <script src="{{ asset('js/chartjs.min.js') }}"></script>
    <script>
        window.onload = loadCashflow('daily');

        function rupiah2(angka) {
            // Nine Zeroes for Billions
            return Math.abs(Number(angka)) >= 1.0e+9

            ? (Math.abs(Number(angka)) / 1.0e+9).toFixed(1) + "m"
            // Six Zeroes for Millions 
            : Math.abs(Number(angka)) >= 1.0e+6

            ? (Math.abs(Number(angka)) / 1.0e+6).toFixed(1) + "jt"
            // Three Zeroes for Thousands
            : Math.abs(Number(angka)) >= 1.0e+3

            ? (Math.abs(Number(angka)) / 1.0e+3).toFixed(0) + "rb"

            : Math.abs(Number(angka));
        }


        var ctx = document.getElementById('cashflow').getContext('2d');
        var dataCashflow = new Chart(ctx, {
            type: 'line',
            data: {
                labels: null,
                datasets: null
            },
            options: {
                legend :{
                  display: false
                },
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // forces step size to be 50 units
                            stepSize: 1
                        }
                    },

                    yAxes: [{
                        ticks: {
                            
                            callback: function(value, index, values) {
                                return rupiah2(value);
                            }
                        }
                    }],
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel +' '+ rupiah2(tooltipItem.yLabel);
                        }
                    }
                }


            }
        });

        function loadCashflow(type) {
            $.ajax({
                type: "GET",
                url: "{{ route('ajax.pos.income') }}",
                data: {'type' : type},
                success: function(res){
                    console.log(res);
                    dataCashflow.data.labels = res.labels;
                    dataCashflow.data.datasets = res.datasets;
                    dataCashflow.update();
                }
            });

        }
    </script>
@endpush