<?php
session_start();
require_once 'dbconfig.in.php'; 

try {
    $stmt = $pdo->prepare("SELECT student_id, CONCAT(first_name, ' ', last_name) AS student_name, average, department, photo FROM students");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error accessing database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="studentStyle.css"> 

    <meta charset="UTF-8">
    <title>Student Table Results</title>
</head>
<body>
<div class="header">
        <p>To Register a new Student, Click on the following link: <a href="Record.html" class="register-link">Register</a></p>
        <p>or use the actions below to edit or delete student record</p>
    </div>

    <h1>Student Table Results</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Student Photo</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Average</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
            <td><img src="data:image/png;base64,<?php echo base64_encode($student['photo']); ?>" alt="Student Photo" height="50"></td>
                <td><a href="view.php?id=<?php echo $student['student_id']; ?>"><?php echo htmlspecialchars($student['student_id']); ?></a></td>
                <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                <td><?php echo htmlspecialchars($student['average']); ?></td>
                <td><?php echo htmlspecialchars($student['department']); ?></td>
                <td>
    <a href="edit.php?id=<?php echo $student['student_id']; ?>">
        <img src="edit.png" alt="Edit">
    </a>
    <a href="delete.php?id=<?php echo $student['student_id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">
        <img src="delete.png" alt="Delete">
    </a>
</td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
