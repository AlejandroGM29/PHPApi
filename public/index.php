<?php
// index.php

// Cargar el archivo de autoloading de Composer para cargar las clases automáticamente
require __DIR__ . '/../vendor/autoload.php';

// Inicializar la sesión (si es necesario)
session_start();

use Controller\authController;

// Obtener la ruta de la solicitud actual
$requestUri = $_SERVER['REQUEST_URI'];

// Eliminar cualquier parámetro de consulta de la URL
$uriParts = explode('?', $requestUri);
$uri = $uriParts[0];

// Definir las rutas y los controladores correspondientes
$routes = [
    '/register' => 'register',
    '/login' => 'login'
];

// Verificar si la ruta solicitada está definida en las rutas
if (array_key_exists($uri, $routes)) {
    // Crear una instancia del controlador de autenticación
    $authController = new AuthController();

    // Llamar al método correspondiente según la ruta
    if ($routes[$uri] == 'register') {
        // Manejar la solicitud de registro (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            // Devolver un error para las solicitudes que no sean POST
            http_response_code(405); // Método no permitido
            echo json_encode(['error' => 'Method Not Allowed']);
        }
    } elseif ($routes[$uri] == 'login') {
        // Manejar la solicitud de inicio de sesión (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            // Devolver un error para las solicitudes que no sean POST
            http_response_code(405); // Método no permitido
            echo json_encode(['error' => 'Method Not Allowed']);
        }
    }
} else {
    // Devolver un error para rutas no encontradas
    http_response_code(404); // No encontrado
    echo json_encode(['error' => 'Not Found']);
}
