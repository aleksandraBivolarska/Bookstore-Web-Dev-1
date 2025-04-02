<?php

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../models/user.php';

class UserRepository extends BaseRepository{

    function getAllUsers() {
        try{
            $stmt = $this->connection->prepare("SELECT * FROM user");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'user');
            $users = $stmt->fetchAll();

            return $users;
        } catch(PDOException $e){
            echo $e;
        }
    }

    function getUserById($user_id){
        $stmt = $this->connection->prepare("SELECT * FROM `user` WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'user');
        $user = $stmt->fetch();

        return $user;
    }

    function validateUser($email, $password)
{
    try {
        // Prepare and execute the query to fetch the user by email
        $stmt = $this->connection->prepare("SELECT user_id, first_name, last_name, email, role, password FROM `user` WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the user data as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if user exists first
        if (!$user) {
            return null;
        }
        // Now safely check the password
        if ($this->isPasswordValid($password , $user['password'])) {
        return $user;
        } else {
            // Invalid credentials
            return null;
        }
    } catch (PDOException $e) {
        echo $e;
        return null;
    }
}

    // Method to fetch the user by email
    public function getUserByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT user_id, first_name, last_name, email, role, password FROM `user` WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $stmt->fetch();
    }

    // Method to verify the password
    private function isPasswordValid($inputPassword, $storedPassword)
    {
        return password_verify($inputPassword, $storedPassword);
    }





}