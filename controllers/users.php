<?php
// Include the users.php file to access user-related functions
require_once __DIR__ . '/../models/index.php';
require_once __DIR__ . '/db/index.php';

// Handle user-related HTTP requests
class UsersController
{
    // Handle user login
    public function login()
    {
        $pdo = getPDO();

        // Get input data from POST request
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        // Validate input
        if (!$email || !$password) {
            echo json_encode([
                "success" => false,
                "message" => "Email and password are required"
            ]);
            return;
        }

        // Call the login function from users.php
        $result = loginUser($pdo, $email, $password);

        // Return the result as JSON
        echo json_encode($result);
    }

    // Handle user registration
    public function register()
    {
        $pdo = getPDO();

        // Get input data from POST request
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        // Validate input
        if (!$name || !$email || !$password) {
            echo json_encode([
                "success" => false,
                "message" => "Name, email, and password are required"
            ]);
            return;
        }

        // Call the register function from users.php
        $result = createUser($pdo, [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        // Return the result as JSON
        echo json_encode($result);
    }
}

// Example usage
// Instantiate the controller and call the appropriate method based on the request
$controller = new UsersController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'login') {
        $controller->login();
    } elseif ($action === 'register') {
        $controller->register();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid action"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);
}
