<?php
session_start();
require_once 'dbconfig.in.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $studentId = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM students WHERE student_id = ?");
        $stmt->execute([$studentId]);

        header("Location: student.php");
        exit;
    } catch (PDOException $e) {
        die("Error while deleting record: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>
