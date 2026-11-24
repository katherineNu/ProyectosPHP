<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - Vuelos Disponibles</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: 90%;
            max-width: 900px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .logo-img {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            color: #1a3c5e;
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .city-badge {
            background-color: #e2e8f0;
            color: #1a3c5e;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }

        /* Estilos de la Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #1a3c5e;
            color: white;
            text-align: left;
            padding: 15px;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        tr:hover {
            background-color: #f8faff;
        }

        .rating {
            color: #f1c40f; /* Color dorado para las estrellas */
            font-weight: bold;
        }

        .price {
            font-weight: bold;
            color: #27ae60;
        }

        .btn-book {
            background-color: #1a3c5e;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.8rem;
            transition: 0.3s;
        }

        .btn-book:hover {
            background-color: #2c527a;
        }

        .back-link {
            display: block;
            margin-top: 25px;
            text-align: center;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <img src="../logo.png" alt="Global Flights" class="logo-img">
        <h1>Vuelos disponibles a <span class="city-badge">DESTINOXXX</span></h1>
    </header>
     
    <table>
        <thead>
           <tr>
                <th>Aerolínea</th>
                <th>Clase</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <!-- Tabla a genera en PHP -->
             <?php foreach($listavuelos as $vuelo) :?>
          <tr>
                <td><strong><?= $vuelo->aerolinea ?></strong></td>
                <td><?= verClase( $vuelo->clase )?></td>
                <td class="price"><?= $vuelo->precio_billete ?></td>
                <td><?= verEstado($vuelo->asientos_libres) ?></td>
                <td><a href="#" class="btn-book">RESERVAR</a></td>
            </tr>
            <?php endforeach; ?>

            <tr>
                <td><strong>LAN Airways</strong></td>
                <td>Business</td>
                <td class="price">920.00€</td>
                <td><span style="color: red; font-weight: bold;">Últimas plazas</span></td>
                <td><a href="#" class="btn-book">RESERVAR</a></td>
            </tr>

            <tr>
                <td><strong>THAI Air</strong></td>
                <td>First Class</td>
                <td class="price">1450.00€</td>
                <td>Disponible</td>
                <td><a href="#" class="btn-book">RESERVAR</a></td>
            </tr> 
        </tbody>
    </table>

    <a href="../index.php" class="back-link">← Volver al buscador</a>
</div>

</body>
</html>