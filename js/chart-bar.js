Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

document.addEventListener("DOMContentLoaded", function () {
    getChartBarData('days');
});

function getChartBarData(filter) {
    fetch('includes/get_state.php')
        .then(response => response.json())
        .then(stateData => {

            if (stateData.estado == 0 || stateData.estado == 1) {
                var chartName = (stateData.estado == 1) ? "myBarChart" : "myBarChart-n";
                fetch('includes/chart-bar-query.php') 
                    .then(response => response.json())
                    .then(chartData => {

                        if (Object.keys(chartData).length > 0) {
                            if (chartName) {
                                var ctx = document.getElementById(chartName);

                                var labels = chartData.map(data => convertDate(data.date, filter));
                                var temperatureData = chartData.map(data => data.temperature);
                                var humidityData = chartData.map(data => data.humidity);

                                var myBarChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Sensor de temperatura',
                                            backgroundColor: 'rgba(255, 129, 0, 1)', 
                                            borderColor: 'rgba(255, 255, 0, 1)',
                                            data: temperatureData,
                                        }, {
                                            label: 'Sensor de humedad',
                                            backgroundColor: 'rgba(0, 128, 0, 0.7)', 
                                            borderColor: 'rgba(0, 128, 0, 1)',
                                            data: humidityData,
                                        }],
                                    },
                                    options: {
                                        scales: {
                                            xAxes: [{
                                                time: {
                                                    unit: filter
                                                },
                                                gridLines: {
                                                    display: false
                                                },
                                                ticks: {
                                                    maxTicksLimit: Math.min(labels.length, 10),
                                                }
                                            }],
                                            yAxes: [{
                                                ticks: {
                                                    min: 0,
                                                    max: 100, 
                                                    maxTicksLimit: 6
                                                },
                                                gridLines: {
                                                    display: true
                                                }
                                            }],
                                        },
                                        legend: {
                                            display: true,
                                            onClick: function (event, legendItem) {
                                            },
                                            labels: {
                                                generateLabels: function (chart) {
                                                    return chart.data.datasets.map(function (dataset, i) {
                                                        var color = dataset.backgroundColor;
                                                        return {
                                                            text: dataset.label,
                                                            fillStyle: color,
                                                            strokeStyle: color,
                                                            lineWidth: 1,
                                                            hidden: false,
                                                            index: i
                                                        };
                                                    });
                                                }
                                            },
                                        },
                                    }
                                });

                            } else {
                                console.error("No se pudo determinar el nombre del gráfico.");
                            }
                        } else {
                            console.error("No hay datos para mostrar.");
                        }
                    })
                    .catch(error => console.error('Error en la obtención de datos del gráfico:', error));
            } else {
                console.error("Estado no válido.");
            }
        })
        .catch(error => console.error('Error en la obtención del estado:', error));
}

function convertDate(dateString, filter) {
    const date = new Date(dateString);
    switch (filter) {
        case 'days':
            return date.toLocaleDateString();
        case 'months':
            return date.toLocaleString('default', { month: 'long' });
        case 'years':
            return date.getFullYear().toString();
        default:
            return dateString;
    }
}
