
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Mediciones PSI para PDVSA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Mediciones</h1>
        <img src="/pdvsa.png" class="img-fluid" style="width: 50%" alt="...">
        <hr>
        <h2>Formulario de Registro</h2>
        <form id="measurementForm">
            <div class="mb-3">
                <label for="wellName" class="form-label">Nombre del Pozo:</label>
                <input type="text" class="form-control" id="wellName" required>
            </div>
            <div class="mb-3">
                <label for="psiValue" class="form-label">Valor en PSI:</label>
                <input type="number" class="form-control" id="psiValue" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar</button>
        </form>

        <hr>

        <h2>Historial de Registros</h2>
        <table id="measurementTable" class="table">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Nombre del Pozo</th>
                    <th>Valor en PSI</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $measurements = file_exists('measurements.txt') ? json_decode(file_get_contents('measurements.txt'), true) : [];
                foreach ($measurements as $measurement) {
                    echo '<tr>';
                    echo '<td>' . $measurement['datetime'] . '</td>';
                    echo '<td>' . $measurement['wellName'] . '</td>';
                    echo '<td>' . $measurement['psiValue'] . '</td>';
                    echo '<td><button class="btn btn-danger" onclick="deleteMeasurement(\'' . $measurement['datetime'] . '\')">Eliminar</button></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <h2>Gráfica Comparativa</h2>
          <br>
        <canvas id="chartContainer" style="height: 400px;"></canvas>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="app.js"></script>
    <script>
        function deleteMeasurement(datetime) {
            console.log('Eliminar registro:', datetime);
        }
    </script>
</body>
</html>

