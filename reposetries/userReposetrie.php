<?php

class UserRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            return $this->createUserByRole($user);
        }
        return null;
    }

    public function createUser($username, $email, $password, $role = 'user') {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password_hash, role) 
             VALUES (:username, :email, :password, :role) 
             RETURNING id, created_at"
        );
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->createUserByRole([
            'id' => $result['id'],
            'username' => $username,
            'email' => $email,
            'password_hash' => $hashedPassword,
            'role' => $role,
            'created_at' => $result['created_at']
        ]);
    }

    private function createUserByRole($userData) {
        switch ($userData['role']) {
            case 'artist':
                return new Artist(
                    $userData['id'],
                    $userData['username'],
                    $userData['email'],
                    $userData['password_hash'],
                    $userData['created_at']
                );
            default:
                return new RegisteredUser(
                    $userData['id'],
                    $userData['username'],
                    $userData['email'],
                    $userData['password_hash'],
                    $userData['created_at']
                );
        }
    }
}
