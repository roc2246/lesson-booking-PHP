<?php
require_once __DIR__ . '/db/index.php';

$pdo = getPDO();

// Login / User Management

function createUser($pdo, $user)
{
    try {
        $sql = "INSERT INTO users 
            (name, email, password) 
            VALUES (?, ?, ?)";

        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $user['name'],
            $user['email'],
            $hashedPassword
        ]);

        return [
            "success" => true,
            "message" => "User created successfully",
            "id" => $pdo->lastInsertId()
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to create user",
            "error" => $e->getMessage()
        ];
    }
}

function getUsers($pdo)
{
    try {
        $sql = "SELECT id, name, email, created_at FROM users ORDER BY id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return [
            "success" => true,
            "message" => "Users retrieved successfully",
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to retrieve users",
            "error" => $e->getMessage()
        ];
    }
}

function getUserById($pdo, $id)
{
    try {
        $sql = "SELECT id, name, email, created_at FROM users WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                "success" => false,
                "message" => "User not found"
            ];
        }

        return [
            "success" => true,
            "message" => "User retrieved successfully",
            "data" => $user
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to retrieve user",
            "error" => $e->getMessage()
        ];
    }
}

function updateUser($pdo, $id, $user)
{
    try {
        $sql = "UPDATE users SET
            name = ?,
            email = ?
            WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $user['name'],
            $user['email'],
            $id
        ]);

        if ($stmt->rowCount() === 0) {
            return [
                "success" => false,
                "message" => "User not found or no changes made"
            ];
        }

        return [
            "success" => true,
            "message" => "User updated successfully"
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to update user",
            "error" => $e->getMessage()
        ];
    }
}

function deleteUser($pdo, $id)
{
    try {
        $sql = "DELETE FROM users WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            return [
                "success" => false,
                "message" => "User not found"
            ];
        }

        return [
            "success" => true,
            "message" => "User deleted successfully"
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to delete user",
            "error" => $e->getMessage()
        ];
    }
}

function loginUser($pdo, $email, $password)
{
    try {
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                "success" => false,
                "message" => "Invalid email or password"
            ];
        }

        if (!password_verify($password, $user['password'])) {
            return [
                "success" => false,
                "message" => "Invalid email or password"
            ];
        }

        unset($user['password']);

        return [
            "success" => true,
            "message" => "Login successful",
            "data" => $user
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Login failed",
            "error" => $e->getMessage()
        ];
    }
}
?>
