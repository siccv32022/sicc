document.addEventListener( "DOMContentLoaded", () => {

    // Color variables based on css variable.
    // ----------------------------------------------
    const _body           = getComputedStyle( document.body );
    const primaryColor    = "#fff";
    const mutedColorRGB   = _body.getPropertyValue('--ton-muted-color-rgb');


    // Line Chart
    // ----------------------------------------------
    const lineData = [
        {'elapsed': '2010', 'value': 18}, {'elapsed': '2011', 'value': 24}, {'elapsed': '2012', 'value': 9}, {'elapsed': '2013', 'value': 12}, {'elapsed': '2014', 'value': 13}, {'elapsed': '2015', 'value': 22}, {'elapsed': '2016', 'value': 11}, {'elapsed': '2017', 'value': 26}, {'elapsed': '2018', 'value': 12}, {'elapsed': '2019', 'value': 19},
        {'elapsed': '2020', 'value': 18}, {'elapsed': '2021', 'value': 24}, {'elapsed': '2022', 'value': 9}, {'elapsed': '2023', 'value': 12}, {'elapsed': '2024', 'value': 13}, {'elapsed': '2025', 'value': 22}, {'elapsed': '2026', 'value': 11}, {'elapsed': '2027', 'value': 26}, {'elapsed': '2028', 'value': 12}, {'elapsed': '2029', 'value': 19}
    ];

    const lineChart = new Chart(
        document.getElementById('_dm-lineChart'), {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Recent Sales',
                        data: lineData,
                        borderWidth: 1,
                        borderColor: primaryColor,
                        backgroundColor: primaryColor,
                        parsing: {
                            xAxisKey: 'elapsed',
                            yAxisKey: 'value'
                        }
                    }
                ]
            },
            options : {
                // Tooltip mode
                interaction: {
                    intersect: false,
                },

                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    y: {
                        grid: {
                            borderWidth: 0,
                            color: `rgba( ${ mutedColorRGB }, .1 )`
                        },
                        suggestedMax: 30,
                        ticks: {
                            font : { size: 11  },
                            color : `rgb( ${ mutedColorRGB })`,
                            beginAtZero: false,
                            stepSize: 5
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

                elements: {
                    // Dot width
                    point : {
                        radius: 3,
                        hoverRadius: 5
                    },
                    // Smooth lines
                    line: {
                        tension: 0.4
                    }
                }
            }
        }
    );

});