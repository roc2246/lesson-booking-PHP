<?php
require_once __DIR__ . '/../db/index.php';
require_once __DIR__ . '/../models/lessonModel.php';

// Helper: send JSON response
function sendResponse($data, $statusCode = 200)
{
    http_response_code($statusCode);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

// CREATE
function createLessonController()
{
    $pdo = getPDO();

    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        sendResponse([
            "success" => false,
            "message" => "Invalid JSON input"
        ], 400);
    }

    $result = createLesson($pdo, $input);
    sendResponse($result, $result["success"] ? 201 : 500);
}

// READ ALL
function getLessonsController()
{
    $pdo = getPDO();

    $result = getLessons($pdo);
    sendResponse($result);
}

// READ ONE
function getLessonByIdController()
{
    $pdo = getPDO();

    if (!isset($_GET['id'])) {
        sendResponse([
            "success" => false,
            "message" => "Missing lesson ID"
        ], 400);
    }

    $result = getLessonById($pdo, $_GET['id']);
    sendResponse($result, $result["success"] ? 200 : 404);
}

// UPDATE
function updateLessonController()
{
    $pdo = getPDO();

    if (!isset($_GET['id'])) {
        sendResponse([
            "success" => false,
            "message" => "Missing lesson ID"
        ], 400);
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        sendResponse([
            "success" => false,
            "message" => "Invalid JSON input"
        ], 400);
    }

    $result = updateLesson($pdo, $_GET['id'], $input);
    sendResponse($result, $result["success"] ? 200 : 404);
}

// DELETE
function deleteLessonController()
{
    $pdo = getPDO();

    if (!isset($_GET['id'])) {
        sendResponse([
            "success" => false,
            "message" => "Missing lesson ID"
        ], 400);
    }

    $result = deleteLesson($pdo, $_GET['id']);
    sendResponse($result, $result["success"] ? 200 : 404);
}
?>