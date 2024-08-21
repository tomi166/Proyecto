Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

function getChartData() {
    fetch('includes/get_state.php')
        .then(response => response.json())
        .then(stateData => {

            if (stateData.estado == 0 || stateData.estado == 1) {
                var chartName = (stateData.estado == 1) ? "myPieChart" : "myPieChart-n";
				var checked = (stateData.estado == 1) ? "filterHours" : "filterHours1";

                fetch('includes/chart-pie-query.php')
                    .then(response => response.json())
                    .then(chartData => {

                        if (Object.keys(chartData).length > 0) {

                            if (chartName) {
                                var ctx = document.getElementById(chartName);

                                var labels = chartData.map(data => data.status);
                                var values = chartData.map(data => data.value);
                                var backgroundColors = chartData.map(data => data.color);

                                var conversionText = '';

								values = values.map(value => {
									conversionText = 'Traducido a horas: ';
									return value / (60 * 60);
								});

                                var myPieChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            data: values,
                                            backgroundColor: backgroundColors,
                                        }],
                                    },
								options: {
									legend: {
										display: true,
										onClick: function (event, legendItem) {
                                        },
										labels: {
											generateLabels: function (chart) {
												return chart.data.labels.map(function (label, i) {
													var color = chart.data.datasets[0].backgroundColor[i];
													return {
														text: label == 'Luz encendida' ? 'Sensor de lúz (encendido)' : 'Sensor de lúz (apagado)',
														fillStyle: color,
														strokeStyle: color,
														lineWidth: 1,
														hidden: false,
														index: i
													};
												});
											},
										},
									},
									tooltips: {
										callbacks: {
											label: function (tooltipItem, data) {
												var value = data.datasets[0].data[tooltipItem.index];
												return conversionText + ': ' + (value.toFixed ? value.toFixed(2) : value);
											}
										}
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