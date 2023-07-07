document.addEventListener('DOMContentLoaded', function() {
    var measurements = [];
    var storedMeasurements = localStorage.getItem('measurements');
    if (storedMeasurements) {
        measurements = JSON.parse(storedMeasurements);
        updateTable();
        updateChart();
    }
    function addMeasurement(event) {
        event.preventDefault();
        var wellName = document.getElementById('wellName').value;
        var psiValue = document.getElementById('psiValue').value;
        var datetime = new Date().toLocaleString();
        measurements.push({
            
            datetime: datetime,
            wellName: wellName,
            psiValue: psiValue
        });
        saveMeasurements();
        updateTable();
        updateChart();

        document.getElementById('wellName').value = '';
        document.getElementById('psiValue').value = '';
    }
    function deleteMeasurement(index) {
        measurements.splice(index, 1);
        saveMeasurements();
        updateTable();
        updateChart();
    }
    function saveMeasurements() {
        localStorage.setItem('measurements', JSON.stringify(measurements));
    }
    function updateTable() {
        var tableBody = document.getElementById('measurementTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        measurements.forEach(function(measurement, index) {
            var row = tableBody.insertRow();
            row.innerHTML = '<td>' + measurement.datetime + '</td>' +
                            '<td>' + measurement.wellName + '</td>' +
                            '<td>' + measurement.psiValue + '</td>' +
                            '<td><button class="btn btn-danger btn-sm deleteBtn">Eliminar</button></td>';
                            
            row.querySelector('.deleteBtn').addEventListener('click', function() {
                deleteMeasurement(index);
            });
        });
    }
    function updateChart() {
        var wellNames = measurements.map(function(measurement) {
            return measurement.wellName;
        });
        var psiValues = measurements.map(function(measurement) {
            return measurement.psiValue;
        });
        var chart = Chart.getChart('chartContainer');
        if (chart) {
            chart.data.labels = wellNames;
            chart.data.datasets[0].data = psiValues;
            chart.update();
        } else {
            var ctx = document.getElementById('chartContainer').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: wellNames,
                    datasets: [{
                        label: 'Valor en PSI',
                        data: psiValues,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
    document.getElementById('measurementForm').addEventListener('submit', addMeasurement);
});
