<?php

require_once __DIR__ . "/../controllers/index.php";

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

$userController = new UsersController();

// --------------------
// LESSON ROUTES
// --------------------

// GET /api/lessons?id=1
if ($uri === '/api/lessons' && $method === 'GET' && isset($_GET['id'])) {
    getLessonByIdController();
    exit;
}

// GET /api/lessons
if ($uri === '/api/lessons' && $method === 'GET') {
    getLessonsController();
    exit;
}

// POST /api/lessons
if ($uri === '/api/lessons' && $method === 'POST') {
    createLessonController();
    exit;
}

// PUT /api/lessons?id=1
if ($uri === '/api/lessons' && $method === 'PUT') {
    updateLessonController();
    exit;
}

// DELETE /api/lessons?id=1
if ($uri === '/api/lessons' && $method === 'DELETE') {
    deleteLessonController();
    exit;
}


// --------------------
// USER ROUTES
// --------------------

// POST /api/register
if ($uri === '/api/register' && $method === 'POST') {
    $userController->register();
    exit;
}

// POST /api/login
if ($uri === '/api/login' && $method === 'POST') {
    $userController->login();
    exit;
}


// --------------------
// FALLBACK
// --------------------

http_response_code(404);
header("Content-Type: application/json");

echo json_encode([
    "success" => false,
    "message" => "Route not found"
]);

?>