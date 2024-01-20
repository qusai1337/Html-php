<?php
require_once 'dbconfig.in.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';
    switch ($operation) {
        case 'insert':
            $requiredFields = [
                'newStudentId',
                'newFirstName',
                'newLastName',
                'newGender',
                'newDateOfBirth',
                'newAddress',
                'newCity',
                'newCountry',
                'newTel',
                'newDepartment',
                'newAverage',
                'newEmail',
            ];

            $allFieldsSet = true;

            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field])) {
                    $allFieldsSet = false;
                    break;
                }
            }

            if ($allFieldsSet) {
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                   
                    $photoData = file_get_contents($_FILES['photo']['tmp_name']);

                    $newStudent = new Student(
                        $pdo,
                        $_POST['newStudentId'],
                        $_POST['newFirstName'],
                        $_POST['newLastName'],
                        $_POST['newGender'],
                        $_POST['newDateOfBirth'],
                        $_POST['newAddress'],
                        $_POST['newCity'],
                        $_POST['newCountry'],
                        $_POST['newTel'],
                        $_POST['newDepartment'],
                        $_POST['newAverage'],
                        $_POST['newEmail'],
                        $photoData 
                    );

                    $result = $newStudent->insert();

                    if ($result) {
                        echo "<p>Student inserted successfully with photo!</p>";
                    } else {
                        echo "<p>Error: Student insertion failed!</p>";
                    }
                } else {
                    echo "<p>No photo selected</p>";
                }
            } else {
                echo "<p>Error: Required fields are not set in \$_POST.</p>";
            }
            break;
    }
}



class Student {
    public $studentId;
    public $firstName;
    public $lastName;
    public $gender;
    public $dateOfBirth;
    public $address;
    public $city;
    public $country;
    public $tel;
    public $Department; 
    public $Avarage;   
    public $email;    
    public $photoData; // Changed from $photoFile

    public function __construct(
        $pdo,
        $studentId,
        $firstName,
        $lastName,
        $gender,
        $dateOfBirth,
        $address,
        $city,
        $country,
        $tel,
        $Department,
        $Avarage,
        $email,
        $photoData // Changed from $photoPath
    ) {

        $this->pdo = $pdo; 
        $this->studentId = $studentId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->dateOfBirth = $dateOfBirth;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->tel = $tel;
        $this->Department = $Department; 
        $this->Avarage = $Avarage;
        $this->email = $email;
        $this->photoData = $photoData; // Store the photo data in the class
    }

    public function insert() {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO students (student_id, first_name, last_name, gender, date_of_birth, address, city, country, tel, department, average, email, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $this->studentId,
                $this->firstName,
                $this->lastName,
                $this->gender,
                $this->dateOfBirth,
                $this->address,
                $this->city,
                $this->country,
                $this->tel,
                $this->Department,
                $this->Avarage,
                $this->email,
                $this->photoData, // Insert the photo data into the database
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

?>
