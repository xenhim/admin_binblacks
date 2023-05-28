var KTDashboard = function() {

  var freshCount = $("#freshFullz").data('id');
  var youngCount = $("#youngFullz").data('id');
  var oldCount = $("#oldFullz").data('id');
    var widgetTechnologiesChart = function() {
        if ($('#kt_widget_technologies_chart').length == 0) {
            return;
        }
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        youngCount, oldCount, freshCount
                    ],
                    backgroundColor: [
                        KTApp.getBaseColor('shape', 3),
                        KTApp.getBaseColor('shape', 4),
                        KTApp.getStateColor('brand')
                    ]
                }],
                labels: [
                    'Young',
                    'Old',
                    'Fresh'
                ]
            },
            options: {
                cutoutPercentage: 75,
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Technology'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    enabled: true,
                    intersect: false,
                    mode: 'nearest',
                    bodySpacing: 5,
                    yPadding: 10,
                    xPadding: 10,
                    caretPadding: 0,
                    displayColors: false,
                    backgroundColor: KTApp.getStateColor('brand'),
                    titleFontColor: '#ffffff',
                    cornerRadius: 4,
                    footerSpacing: 0,
                    titleSpacing: 0
                }
            }
        };

        var ctx = document.getElementById('kt_widget_technologies_chart').getContext('2d');
        var myDoughnut = new Chart(ctx, config);
    }
    return {
        init: function() {
            widgetTechnologiesChart();
        }
    };
}();

jQuery(document).ready(function() {
    KTDashboard.init();
});
