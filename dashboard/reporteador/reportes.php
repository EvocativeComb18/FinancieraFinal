<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Préstamos Activos</title>
    <style>
        /* Estilos generales */
        @import url("https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #2980b9;
            height: 100vh;
        }

        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            padding: 20px 40px;
        }

        .center h1 {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid silver;
            margin-bottom: 20px;
        }

        canvas {
            border: 1px solid #000;
            width: 100%;
            height: 200px;
            margin-top: 10px;
        }

        .role_button {
            width: 100%;
            height: 50px;
            background: #2691d9;
            border-radius: 25px;
            font-size: 18px;
            color: #e9f4fb;
            font-weight: 700;
            cursor: pointer;
            outline: none;
            transition: 0.5s;
            border: none;
            margin-top: 15px;
        }

        .role_button:hover {
            background: #1e7bbd;
        }
    </style>
    <link rel="stylesheet" href="style.css"> <!-- Puedes aplicar los estilos de tu CSS -->
</head>
<body>
    <h1>Reporte de Préstamos Activos</h1>
    <table border="1">
        <tr>
            <th>ID Cliente</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo de Préstamo</th>
            <th>Monto Solicitado</th>
            <th>Plazo</th>
            <th>Fecha de Vencimiento</th>
            <th>Saldo Restante</th>
        </tr>
        <?php
        // Iterar sobre los resultados de la consulta
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['cliente_id']}</td>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['loan_type']}</td>
                        <td>{$row['requested_amount']}</td>
                        <td>{$row['loan_term']}</td>
                        <td>{$row['due_date']}</td>
                        <td>{$row['remaining_balance']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay datos disponibles</td></tr>";
        }
        ?>
    </table>
    <a href="reporte_pdf.php" class="role_button">Descargar PDF</a>
</body>
</html>
