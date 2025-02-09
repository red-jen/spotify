<?php 


class User {
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $role;
    
    public function __construct($id, $username, $email, $password, $role) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    
    // Basic getters/setters
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }

    public function getPassword() { return $this->password; }
}



