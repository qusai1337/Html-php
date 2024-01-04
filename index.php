<?php

// Include the Student class
include_once 'Student.php';

// Include the student data
include_once 'data.in.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    switch ($operation) {
        case 'view':
            $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
            if (array_key_exists($studentId, $students)) {
                // Return HTML form filled with student's details
                $student = $students[$studentId];
                echo "<h3>Student Details</h3>";
                echo "<p>Student ID: $student->studentId</p>";
                echo "<p>First Name: $student->firstName</p>";
                echo "<p>Last Name: $student->lastName</p>";
                echo "<p>Gender: $student->gender</p>";
                echo "<p>Date of Birth: $student->dateOfBirth</p>";
                echo "<p>Address: $student->address</p>";
                echo "<p>City: $student->city</p>";
                echo "<p>Country: $student->country</p>";
                echo "<p>Tel: $student->tel</p>";
            } else {
                echo "<p>Student not found!</p>";
            }
            break;

        case 'insert':
            // Handle Insert operation
            $newStudentId = isset($_POST['newStudentId']) ? $_POST['newStudentId'] : '';
            if (!array_key_exists($newStudentId, $students)) {
                // Student not stored, insert a new student object into the $students array
                $newStudent = new Student(
                    $newStudentId,
                    $_POST['newFirstName'],
                    $_POST['newLastName'],
                    $_POST['newGender'],
                    $_POST['newDateOfBirth'],
                    $_POST['newAddress'],
                    $_POST['newCity'],
                    $_POST['newCountry'],
                    $_POST['newTel']
                );
                $students[$newStudentId] = $newStudent;

                // Update the data.in.php file
                file_put_contents('data.in.php', '<?php $students = ' . var_export($students, true) . ';', LOCK_EX);

                echo "<p>Student inserted successfully!</p>";
            } else {
                echo "<p>Error: Student already exists!</p>";
            }
            break;

        case 'update':
            // Handle Update operation
            $studentIdToUpdate = isset($_POST['studentIdToUpdate']) ? $_POST['studentIdToUpdate'] : '';
            if (array_key_exists($studentIdToUpdate, $students)) {
                // Update the student information in the $students array
                $students[$studentIdToUpdate]->firstName = $_POST['updatedFirstName'];
                $students[$studentIdToUpdate]->lastName = $_POST['updatedLastName'];
                $students[$studentIdToUpdate]->gender = $_POST['updatedGender'];
                $students[$studentIdToUpdate]->dateOfBirth = $_POST['updatedDateOfBirth'];
                $students[$studentIdToUpdate]->address = $_POST['updatedAddress'];
                $students[$studentIdToUpdate]->city = $_POST['updatedCity'];
                $students[$studentIdToUpdate]->country = $_POST['updatedCountry'];
                $students[$studentIdToUpdate]->tel = $_POST['updatedTel'];
                
                // Update the data.in.php file
                file_put_contents('data.in.php', '<?php $students = ' . var_export($students, true) . ';', LOCK_EX);

                echo "<p>Student updated successfully!</p>";
            } else {
                echo "<p>Error: Student not found!</p>";
            }
            break;

        default:
            echo "<p>Invalid operation!</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body>
    <h2>Student Profile</h2>

    <!-- View Section -->
    <form action="index.php" method="post">
        <h3>View Student</h3>
        <label for="studentId">Enter Student ID:</label>
        <input type="text" id="studentId" name="studentId">
        <input type="hidden" name="operation" value="view">
        <button type="submit">View</button>
    </form>

    <!-- Insert Section -->
    <form action="index.php" method="post">
        <h3>Insert Student</h3>
        <label for="newStudentId">Student ID:</label>
        <input type="text" id="newStudentId" name="newStudentId" required>
        <label for="newFirstName">First Name:</label>
        <input type="text" id="newFirstName" name="newFirstName" required>
        <label for="newLastName">Last Name:</label>
        <input type="text" id="newLastName" name="newLastName" required>
        <label for="newGender">Gender:</label>
        <input type="text" id="newGender" name="newGender" required>
        <label for="newDateOfBirth">Date of Birth:</label>
        <input type="text" id="newDateOfBirth" name="newDateOfBirth" required>
        <label for="newAddress">Address:</label>
        <input type="text" id="newAddress" name="newAddress" required>
        <label for="newCity">City:</label>
        <input type="text" id="newCity" name="newCity" required>
        <label for="newCountry">Country:</label>
        <input type="text" id="newCountry" name="newCountry" required>
        <label for="newTel">Tel:</label>
        <input type="text" id="newTel" name="newTel" required>
        <input type="hidden" name="operation" value="insert">
        <button type="submit">Insert</button>
    </form>

    <!-- Update Section -->
    <form action="index.php" method="POST">
        <h3>Update Student</h3>
        <label for="studentIdToUpdate">Student ID to Update:</label>
        <input type="text" id="studentIdToUpdate" name="studentIdToUpdate" required>
        <label for="updatedFirstName">Updated First Name:</label>
        <input type="text" id="updatedFirstName" name="updatedFirstName" required>
        <label for="updatedLastName">Updated Last Name:</label>
        <input type="text" id="updatedLastName" name="updatedLastName" required>
        <label for="updatedGender">Updated Gender:</label>
        <input type="text" id="updatedGender" name="updatedGender" required>
        <label for="updatedDateOfBirth">Updated Date of Birth:</label>
        <input type="text" id="updatedDateOfBirth" name="updatedDateOfBirth" required>
        <label for="updatedAddress">Updated Address:</label>
        <input type="text" id="updatedAddress" name="updatedAddress" required>
        <label for="updatedCity">Updated City:</label>
        <input type="text" id="updatedCity" name="updatedCity" required>
        <label for="updatedCountry">Updated Country:</label>
        <input type="text" id="updatedCountry" name="updatedCountry" required>
        <label for="updatedTel">Updated Tel:</label>
        <input type="text" id="updatedTel" name="updatedTel" required>
        <input type="hidden" name="operation" value="update">
        <button type="submit">Update</button>
    </form>

</body>
</html>
