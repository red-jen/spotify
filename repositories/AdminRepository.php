<?php
class AdminRepository {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function banUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET status = 'banned' WHERE id = :id");
        return $stmt->execute(['id' => $userId]);
    }
    
    public function approveSong($songId) {
        $stmt = $this->pdo->prepare("UPDATE songs SET status = 'approved' WHERE id = :id");
        return $stmt->execute(['id' => $songId]);
    }
}