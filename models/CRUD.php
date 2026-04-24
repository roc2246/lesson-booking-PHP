<?php
// Lesson Management
function createLesson($lesson)
{
    try {
        // SQL
        // Create Lesson

        return [
            "message" => "Lesson created successfully",
            "details" => $lesson
        ];
    } catch (Exception $e) {
        return [
            "message" => "Failed to create lesson",
            "details" => $e
        ];
    }
}
