Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

document.addEventListener("DOMContentLoaded", function () {
    getChartAreaData();
});

function getChartAreaData() {
    fetch('includes/get_state.php')
        .then(response => response.json())
        .then(stateData => {

            if (stateData.estado == 0 || stateData.estado == 1) {
                var chartName = (stateData.estado == 1) ? "myAreaChart" : "myAreaChart-n";
				
                fetch('includes/chart-area-query.php')
                    .then(response => response.json())
                    .then(chartAreaData => {
                        if (Object.keys(chartAreaData).length > 0) {

                            const esp8266Data = chartAreaData.esp8266;
                            const humidityData = chartAreaData.humidity;
                            const temperatureData = chartAreaData.temperature;
                            const lightData = chartAreaData.ldr_value;
                            const buzzerData = chartAreaData.buzzer;
                            const totalConsumptionData = chartAreaData.totalConsumption;							
							
                            const humidityLineData = humidityData ? humidityData.map(value => (value !== 0) ? value : 0) : [];
                            const temperatureLineData = temperatureData ? temperatureData.map(value => (value !== 0) ? value : 0) : [];
                            const lightLineData = lightData ? lightData.map(value => (value !== 0) ? value : 0) : [];
							
							const dateLabels = chartAreaData.date_time.map(date => {
								const formattedDate = new Date(date);
								const year = formattedDate.getFullYear();
								const month = (formattedDate.getMonth() + 1).toString().padStart(2, '0');
								const day = formattedDate.getDate().toString().padStart(2, '0');
								const hours = formattedDate.getHours().toString().padStart(2, '0');
								const minutes = formattedDate.getMinutes().toString().padStart(2, '0');
								const seconds = formattedDate.getSeconds().toString().padStart(2, '0');
								return `${year}-${month}-${day} `;
							});

                            var myLineChart = new Chart(chartName, {
                                type: 'line',
                                data: {
                                    labels: dateLabels,
                                    datasets: [{
                                        label: "Chip ESP8266 en mA",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(2,117,216,0.2)",
                                        borderColor: "rgba(2,117,216,1)",
                                        pointRadius: 5,
                                        pointBackgroundColor: "rgba(2,117,216,1)",
                                        pointBorderColor: "rgba(255,255,255,0.8)",
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                                        pointHitRadius: 50,
                                        pointBorderWidth: 2,
                                        data: esp8266Data,
                                    },
                                    {
                                        label: "Sensor de humedad en mA",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(255, 0, 0, 0.2)",
                                        borderColor: "rgba(255, 0, 0, 1)",
                                        pointRadius: 5,
                                        pointBackgroundColor: "rgba(255, 0, 0, 1)",
                                        pointBorderColor: "rgba(255, 255, 255, 0.8)",
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(255, 0, 0, 1)",
                                        pointHitRadius: 50,
                                        pointBorderWidth: 2,
                                        data: humidityLineData,
                                    },
                                    {
                                        label: "Sensor de temperatura en mA",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(0, 255, 0, 0.2)",
                                        borderColor: "rgba(0, 255, 0, 1)",
                                        pointRadius: 5,
                                        pointBackgroundColor: "rgba(0, 255, 0, 1)",
                                        pointBorderColor: "rgba(255, 255, 255, 0.8)",
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0, 255, 0, 1)",
                                        pointHitRadius: 50,
                                        pointBorderWidth: 2,
                                        data: temperatureLineData,
                                    },
                                    {
                                        label: "Sensor de luz en mA",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(255, 255, 0, 0.2)",
                                        borderColor: "rgba(255, 255, 0, 1)",
                                        pointRadius: 5,
                                        pointBackgroundColor: "rgba(255, 255, 0, 1)",
                                        pointBorderColor: "rgba(255, 255, 255, 0.8)",
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(255, 255, 0, 1)",
                                        pointHitRadius: 50,
                                        pointBorderWidth: 2,
                                        data: lightLineData,
                                    },
                                    {
                                        label: "Señalizador buzzer en mA",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                                        borderColor: "rgba(0, 0, 255, 1)",
                                        pointRadius: 5,
                                        pointBackgroundColor: "rgba(0, 0, 255, 1)",
                                        pointBorderColor: "rgba(255, 255, 255, 0.8)",
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0, 0, 255, 1)",
                                        pointHitRadius: 50,
                                        pointBorderWidth: 2,
                                        data: buzzerData,
                                    },
                                    {
                                        label: "Consumo total en mA",
                                        lineTension: 0.3,
                                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                                        borderColor: "rgba(0, 255, 198, 1)",
                                        pointRadius: 5,
                                        pointBackgroundColor: "rgba(0, 255, 198, 1)",
                                        pointBorderColor: "rgba(255, 255, 255, 0.8)",
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(0, 255, 198, 1)",
                                        pointHitRadius: 50,
                                        pointBorderWidth: 2,
                                        data: totalConsumptionData,
                                    }]
                                },
                                options: {
                                    scales: {
                                        xAxes: [{
                                            time: {
                                                unit: 'date'
                                            },
                                            gridLines: {
                                                display: false
                                            },
                                            ticks: {
                                                maxTicksLimit: 7
                                            }
                                        }],
                                        yAxes: [{
                                            ticks: {
                                                min: 0,
                                                max: 180000,
                                                maxTicksLimit: 10
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, .125)",
                                            }
                                        }],
                                    },
                                    legend: {
                                        onClick: function (e, legendItem) {
                                            var index = legendItem.datasetIndex;
                                            var chart = this.chart;
                                            var meta = chart.getDatasetMeta(index);

                                            meta.hidden = meta.hidden === null ? !chart.data.datasets[index].hidden : null;
                                            chart.update();
                                        }
                                    }
                                }
                            });

                        } else {
                            console.error("No hay datos para mostrar.");
                        }
                    })
                    .catch(error => console.error('Error en la obtención de datos del gráfico de área:', error));
            } else {
                console.error("Estado no válido.");
            }
        })
        .catch(error => console.error('Error en la obtención del estado:', error));
}
