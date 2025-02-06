<?php
class AuthController {
    private $userRepository;

    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->userRepository = new UserRepository($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            // Validation
            if (empty($username) || empty($email) || empty($password)) {
                return ['error' => 'All fields are required'];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['error' => 'Invalid email format'];
            }

            try {
                $user = $this->userRepository->createUser($username, $email, $password, $role);
                session_start();
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['role'] = $user->getRole();
                
                header('Location: /dashboard');
                exit;
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'unique constraint')) {
                    return ['error' => 'Email or username already exists'];
                }
                return ['error' => 'Registration failed'];
            }
        }
        
        // Show registration form
        require 'views/auth/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return ['error' => 'All fields are required'];
            }

            try {
                $user = $this->userRepository->findByEmail($email);
                
                if ($user && password_verify($password, $user->getPassword())) {
                    session_start();
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['role'] = $user->getRole();
                    
                    header('Location: /dashboard');
                    exit;
                }
                
                return ['error' => 'Invalid credentials'];
            } catch (Exception $e) {
                return ['error' => 'Login failed'];
            }
        }
        
        // Show login form
        require 'views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}