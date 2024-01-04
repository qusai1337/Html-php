<?php

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

    public function __construct(
        $studentId,
        $firstName,
        $lastName,
        $gender,
        $dateOfBirth,
        $address,
        $city,
        $country,
        $tel
    ) {
        $this->studentId = $studentId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->dateOfBirth = $dateOfBirth;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->tel = $tel;
    }

    public static function __set_state($data) {
        $obj = new self(
            $data['studentId'],
            $data['firstName'],
            $data['lastName'],
            $data['gender'],
            $data['dateOfBirth'],
            $data['address'],
            $data['city'],
            $data['country'],
            $data['tel']
        );
        return $obj;
    }
}

?>
