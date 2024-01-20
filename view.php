<?php
session_start();
require_once 'dbconfig.in.php'; 

$studentId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$studentId) {
    die("Invalid student ID.");
}
try {
    $stmt = $pdo->prepare("SELECT *, TO_BASE64(photo) as photo_base64 FROM students WHERE student_id = ?");
    $stmt->execute([$studentId]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }
} catch (PDOException $e) {
    die("Error accessing database: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="viewStyle.css"> 

    <meta charset="UTF-8">
    <title>Student Details</title>
   
</head>
<body>
    <div class="student-detail-container">
        <h1>Student Details</h1>
        <?php if (!empty($student['photo_base64'])): ?>
            <img src="data:image/jpeg;base64,<?php echo $student['photo_base64'] ?>" alt="Student Photo" />
        <?php else: ?>
            <p>No photo available.</p>
        <?php endif; ?>
        <ul>
            <li><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></li>
            <li><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></li>
            <li><strong>Average:</strong> <?php echo htmlspecialchars($student['average']); ?></li>
            <li><strong>Department:</strong> <?php echo htmlspecialchars($student['department']); ?></li>
            <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($student['date_of_birth']); ?></li>
        </ul>
        <h2>Contact</h2>
        <p>Send Email to: <a href="mailto:<?php echo htmlspecialchars($student['email']); ?>"><?php echo htmlspecialchars($student['email']); ?></a></p>
        <p>Tel: <?php echo htmlspecialchars($student['tel']); ?></p>
        <p>Address: <?php echo htmlspecialchars($student['address']); ?></p>
    </div>
</body>
</html>


