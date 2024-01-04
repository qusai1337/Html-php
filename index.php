<?php

include_once 'Student.php';
include_once 'data.in.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    switch ($operation) {
        case 'view':
            $studentId = isset($_POST['studentId']) ? $_POST['studentId'] : '';
            if (array_key_exists($studentId, $students)) {
                $student = $students[$studentId];
                $responseData = [
                    'firstName' => $student->firstName,
                    'lastName' => $student->lastName,
                    'gender' => $student->gender,
                    'dateOfBirth' => $student->dateOfBirth,
                    'address' => $student->address,
                    'city' => $student->city,
                    'country' => $student->country,
                    'tel' => $student->tel,
                ];

                // response
                header('Content-Type: application/json');
                echo json_encode($responseData);
            } else {
                //  not found
                $errorResponse = ['error' => 'Student not found!'];
                header('Content-Type: application/json');
                echo json_encode($errorResponse);
            }
            exit;  // Terminate script after sending the response
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
</body>
</html>
