<?php
class AdminController {
    private $adminRepository;
    
    public function __construct($pdo) {
        $this->adminRepository = new AdminRepository($pdo);
    }
    
    public function banUser() {
        if (!$this->isAdmin()) {
            header('HTTP/1.1 403 Forbidden');
            return ['error' => 'Unauthorized'];
        }
        
        $userId = $_POST['user_id'] ?? null;
        if (!$userId) {
            return ['error' => 'User ID required'];
        }
        
        try {
            $this->adminRepository->banUser($userId);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => 'Failed to ban user'];
        }
    }
    
    public function approveSong() {
        if (!$this->isAdmin()) {
            header('HTTP/1.1 403 Forbidden');
            return ['error' => 'Unauthorized'];
        }
        
        $songId = $_POST['song_id'] ?? null;
        if (!$songId) {
            return ['error' => 'Song ID required'];
        }
        
        try {
            $this->adminRepository->approveSong($songId);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => 'Failed to approve song'];
        }
    }
    
    private function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}
