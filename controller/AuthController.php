<?php


class AuthController {
    private $userRepository;

    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->userRepository = new UserRepository($db);
    }

    public function login() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // If POST request, process login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'All fields are required';
                include 'viewer/login.php';
                exit;
            }

            try {
                $user = $this->userRepository->findByEmail($email);
                
                if ($user && password_verify($password, $user->getPassword())) {
                    $_SESSION['user'] = serialize($user);

                
                    
                    // Redirect to viewer index
                    header('Location: views/home.php');
                    exit;
                }
                
                $error = 'Invalid credentials';
                include 'views/auth/login.php';
                exit;
            } catch (Exception $e) {
                $error = 'Login failed: ' . $e->getMessage();
                include 'views/auth/login.php';
                exit;
            }
        }
        
        // Show login form for GET request
        include 'views/auth/login.php';
    }

    public function register() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // If POST request, process registration
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            // Validation
            if (empty($username) || empty($email) || empty($password)) {
                $error = 'All fields are required';
                include 'viewer/register.php';
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Invalid email format';
                include 'viewer/register.php';
                exit;
            }

            try {
                $user = $this->userRepository->createUser($username, $email, $password, $role);
                
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['role'] = $user->getRole();
                
                // Redirect to viewer index
                header('Location: viewer/index.htm');
                exit;
            } catch (PDOException $e) {
                $error = (strpos($e->getMessage(), 'unique constraint')) 
                    ? 'Email or username already exists' 
                    : 'Registration failed';
                
                include 'viewer/register.php';
                exit;
            }
        }
        
        // Show registration form for GET request
        include 'viewer/register.php';
    }

    public function logout() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Destroy session
        $_SESSION = array();
        session_destroy();

        // Redirect to login
        header('Location: login');
        exit;
    }
}