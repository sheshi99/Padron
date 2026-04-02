<?php

require 'vendor/autoload.php';

use MongoDB\Client;

// Leer la ruta
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$partes = array_values(array_filter(explode('/', $path)));

// Ruta esperada:
// http://localhost:8000/cedula/101240037

if (isset($partes[0]) && $partes[0] === 'cedula' && isset($partes[1])) {
    $cedula = $partes[1];

    // Validar exactamente 9 dígitos
    if (!preg_match('/^\d{9}$/', $cedula)) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "mensaje" => "Número de cédula debe ser de nueve dígitos"
        ]);
        exit;
    }

    try {
        // Conectar a MongoDB
        $client = new Client("mongodb://127.0.0.1:27017");

        // Seleccionar base y colección
        $collection = $client->padron->personas;

        // Buscar por cédula
        $info = $collection->findOne([
            "CEDULA" => (int)$cedula
        ]);

        if ($info) {
            $result = [
                "cedula" => $info["CEDULA"] ?? null,
                "nombre" => $info["NOMBRE"] ?? null,
                "apellidoPaterno" => $info["PAPELLIDO"] ?? null,
                "apellidoMaterno" => $info["SAPELLIDO"] ?? null
            ];

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($result);
        } else {
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "mensaje" => "No encontrado"
            ]);
        }

    } catch (Exception $e) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "mensaje" => "Error al consultar MongoDB",
            "error" => $e->getMessage()
        ]);
    }

} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Uso:\nhttp://localhost:8000/cedula/101240037";
}