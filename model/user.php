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

// class User {
//     protected int $id;
//     protected string $name;
//     protected string $email;
//     protected string $password;
//     protected string $role;

//     public function __construct(int $id, string $name, string $email, string $password, string $role) {
//         $this->id = $id;
//         $this->name = $name;
//         $this->email = $email;
//         $this->password = password_hash($password, PASSWORD_BCRYPT);
//         $this->role = $role;
//     }

//     public function login(): void {
   
//         session_start();
//         $_SESSION['user_id'] = $this->id;
//         $_SESSION['role'] = $this->role;
//     }

//     public function logout(): void {
//         session_destroy();
//     }

//     public function register( $username,$email,$password_hash,$role) {
//         $sql = "INSERT INTO users (username, email, password_hash, role) 
//         VALUES (:username, :email, :password_hash, :role)";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([
//     ':username' => $username,
//     ':email' => $email,
//     ':password_hash' => $password_hash,
//     ':role' => $role]);
    
//     }

//     public function getId(): int {
//         return $this->id;
//     }

//     public function getName(): string {
//         return $this->name;
//     }


// }

