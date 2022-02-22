document.addEventListener( "DOMContentLoaded", () => {

    // Color variables based on css variable.
    // ----------------------------------------------
    const _body           = getComputedStyle( document.body );
    const primaryColor    = _body.getPropertyValue('--ton-comp-active-bg');
    const mutedColorRGB   = _body.getPropertyValue('--ton-muted-color-rgb');
    const grayColor       = `rgba( ${_body.getPropertyValue('--bs-light-rgb')}, .55)`;



    // Area Chart
    // ----------------------------------------------
    const areaData = [
        {period: "Oct-12", dl: 24, up:2},
        {period: "Oct-13", dl: 34, up:22},
        {period: "Oct-14", dl: 33, up:7},
        {period: "Oct-15", dl: 22, up:6},
        {period: "Oct-16", dl: 28, up:17},
        {period: "Oct-17", dl: 60, up:15},
        {period: "Oct-18", dl: 60, up:17},
        {period: "Oct-19", dl: 70, up:7},
        {period: "Oct-20", dl: 67, up:18},
        {period: "Oct-21", dl: 86, up: 18},
        {period: "Oct-22", dl: 86, up: 18},
        {period: "Oct-23", dl: 113, up: 29},
        {period: "Oct-24", dl: 130, up: 23},
        {period: "Oct-25", dl: 114, up:10},
        {period: "Oct-26", dl: 80, up:22},
        {period: "Oct-27", dl: 109, up:7},
        {period: "Oct-28", dl: 100, up:6},
        {period: "Oct-29", dl: 105, up:17},
        {period: "Oct-30", dl: 110, up:15},
        {period: "Oct-31", dl: 102, up:17},
        {period: "Nov-01", dl: 107, up:7},
        {period: "Nov-02", dl: 60, up:18},
        {period: "Nov-03", dl: 67, up: 18},
        {period: "Nov-04", dl: 76, up: 18},
        {period: "Nov-05", dl: 73, up: 29},
        {period: "Nov-06", dl: 94, up: 13},
        {period: "Nov-07", dl: 135, up:2},
        {period: "Nov-08", dl: 154, up:22},
        {period: "Nov-09", dl: 120, up:7},
        {period: "Nov-10", dl: 100, up:6},
        {period: "Nov-11", dl: 130, up:17},
        {period: "Nov-12", dl: 100, up:15},
        {period: "Nov-13", dl: 60, up:17},
        {period: "Nov-14", dl: 70, up:7},
        {period: "Nov-15", dl: 67, up:18},
        {period: "Nov-16", dl: 86, up: 18},
        {period: "Nov-17", dl: 86, up: 18},
        {period: "Nov-18", dl: 113, up: 29},
        {period: "Nov-19", dl: 130, up: 23},
        {period: "Nov-20", dl: 114, up:10},
        {period: "Nov-21", dl: 80, up:22},
        {period: "Nov-22", dl: 109, up:7},
        {period: "Nov-23", dl: 100, up:6},
        {period: "Nov-24", dl: 105, up:17},
        {period: "Nov-25", dl: 110, up:15},
        {period: "Nov-26", dl: 102, up:17},
        {period: "Nov-27", dl: 107, up:7},
        {period: "Nov-28", dl: 60, up:18},
        {period: "Nov-29", dl: 67, up: 18},
        {period: "Nov-30", dl: 76, up: 18},
        {period: "Des-01", dl: 73, up: 29},
        {period: "Des-02", dl: 94, up: 13},
        {period: "Des-03", dl: 79, up: 24}
    ];
    const areaChart = new Chart(
        document.getElementById('_dm-areaChart'), {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Upload Speed',
                        data: areaData,
                        borderColor: primaryColor,
                        backgroundColor: primaryColor,
                        fill: "start",
                        parsing: {
                            xAxisKey: 'period',
                            yAxisKey: 'up'
                        }
                    },
                    {
                        label: 'Download Speed',
                        data: areaData,
                        borderColor: "transparent",
                        backgroundColor: grayColor,
                        fill: "start",
                        parsing: {
                            xAxisKey: 'period',
                            yAxisKey: 'dl'
                        }
                    },
                ]
            },
            options : {

                interaction: {
                    mode : 'index',
                    intersect: false,
                },

                scales: {
                    y: {
                        grid: {
                            borderWidth: 0,
                            color: `rgba( ${ mutedColorRGB }, .1 )`
                        },
                        suggestedMax: 200,
                        ticks: {
                            font : { size: 11  },
                            color : `rgb( ${ mutedColorRGB })`,
                            beginAtZero: false,
                            stepSize: 50
                        }
                    },
                    x: {
                        grid: {
                            borderWidth: 0,
                            drawOnChartArea: false
                        },
                        ticks: {
                            font : { size: 11  },
                            color : `rgb( ${ mutedColorRGB })`,
                            autoSkip: true,
                            maxRotation: 0,
                            minRotation: 0,
                            maxTicksLimit: 7
                        }
                    }
                },

                // Dot width
                radius: 1,

                // Smooth lines
                elements: {
                    line: {
                        tension: 0.15
                    }
                }
            }
        }
    );

});