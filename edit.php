<?php
session_start();
require_once 'dbconfig.in.php';

$studentId = isset($_GET['id']) ? $_GET['id'] : null;
$student = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $average = $_POST['average'] ?? '';
    $department = $_POST['department'] ?? '';
    $gender =  $_POST['gender'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $country = $_POST['country'] ?? '';
    $tel = $_POST['tel'] ?? '';
    $email = $_POST['email'] ?? '';


    try {
        $updateStmt = $pdo->prepare("UPDATE students SET first_name = ?, last_name = ?, average = ?, department = ? WHERE student_id = ?");
        $updateStmt->execute([$firstName, $lastName, $average, $department, $studentId]);

        header("Location: student.php");
        exit;
    } catch (PDOException $e) {
        die("Error updating database: " . $e->getMessage());
    }
} elseif ($studentId) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            die("Student not found.");
        }
    } catch (PDOException $e) {
        die("Error accessing database: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="editStyle.css"> 

    <meta charset="UTF-8">
    <title>Edit Student</title>
</head>
<body>
    <?php if ($studentId && !$isPostRequest): ?>
        <div class="student-edit-container">
            <h1>Edit Student</h1>
            <form action="edit.php?id=<?php echo $studentId; ?>" method="post">
                <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>">
                
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>">
                
                <label for="gender">gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($student['gender'] ?? ''); ?>" required>

                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($student['department'] ?? ''); ?>" required>

                <label for="average">Average:</label>
                <input type="text" id="average" name="average" value="<?php echo htmlspecialchars($student['average'] ?? ''); ?>" required>

                <label for="date_of_birth">date of birth:</label>
                <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?>" required>

                <label for="email">email:</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>" required>

                <label for="country">country:</label>
                <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($student['country'] ?? ''); ?>" required>

                <label for="city">city:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($student['city'] ?? ''); ?>" required>

                <label for="address">  address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($student['address'] ?? ''); ?>" required>
                
                <input type="submit" name="update_student" value="Update">
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
