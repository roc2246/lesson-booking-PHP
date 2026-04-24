<?php
// Lesson Management

function createLesson($pdo, $lesson)
{
    try {
        $sql = "INSERT INTO lessons 
            (type, date, start_time, duration, guest_count, assigned_to) 
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $lesson['type'],
            $lesson['date'],
            $lesson['start_time'],
            $lesson['duration'],
            $lesson['guest_count'],
            $lesson['assigned_to']
        ]);

        return [
            "success" => true,
            "message" => "Lesson created successfully",
            "id" => $pdo->lastInsertId()
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to create lesson",
            "error" => $e->getMessage()
        ];
    }
}

function getLessons($pdo)
{
    try {
        $sql = "SELECT * FROM lessons ORDER BY date, start_time";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return [
            "success" => true,
            "message" => "Lessons retrieved successfully",
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to retrieve lessons",
            "error" => $e->getMessage()
        ];
    }
}

function getLessonById($pdo, $id)
{
    try {
        $sql = "SELECT * FROM lessons WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$lesson) {
            return [
                "success" => false,
                "message" => "Lesson not found"
            ];
        }

        return [
            "success" => true,
            "message" => "Lesson retrieved successfully",
            "data" => $lesson
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to retrieve lesson",
            "error" => $e->getMessage()
        ];
    }
}

function updateLesson($pdo, $id, $lesson)
{
    try {
        $sql = "UPDATE lessons SET
            type = ?,
            date = ?,
            start_time = ?,
            duration = ?,
            guest_count = ?,
            assigned_to = ?
            WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $lesson['type'],
            $lesson['date'],
            $lesson['start_time'],
            $lesson['duration'],
            $lesson['guest_count'],
            $lesson['assigned_to'],
            $id
        ]);

        if ($stmt->rowCount() === 0) {
            return [
                "success" => false,
                "message" => "Lesson not found or no changes made"
            ];
        }

        return [
            "success" => true,
            "message" => "Lesson updated successfully"
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to update lesson",
            "error" => $e->getMessage()
        ];
    }
}

function deleteLesson($pdo, $id)
{
    try {
        $sql = "DELETE FROM lessons WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            return [
                "success" => false,
                "message" => "Lesson not found"
            ];
        }

        return [
            "success" => true,
            "message" => "Lesson deleted successfully"
        ];

    } catch (Throwable $e) {
        return [
            "success" => false,
            "message" => "Failed to delete lesson",
            "error" => $e->getMessage()
        ];
    }
}
?>