<?php
class ArtistController {
    private $artistRepository;
    
    public function __construct($pdo) {
        $this->artistRepository = new ArtistRepository($pdo);
    }
    
    public function uploadSong() {
        if (!$this->isArtist()) {
            header('HTTP/1.1 403 Forbidden');
            return ['error' => 'Unauthorized'];
        }
        
        $title = $_POST['title'] ?? '';
        $file = $_FILES['song'] ?? null;
        
        if (empty($title) || !$file) {
            return ['error' => 'Title and song file are required'];
        }
        
        try {
            // Handle file upload
            $filePath = $this->handleFileUpload($file);
            $duration = $this->getAudioDuration($filePath);
            
            $songId = $this->artistRepository->uploadSong(
                $this->getCurrentArtist(),
                $title,
                $filePath,
                $duration
            );
            
            return ['success' => true, 'song_id' => $songId];
        } catch (Exception $e) {
            return ['error' => 'Failed to upload song'];
        }
    }
    
    private function isArtist() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'artist';
    }
    
    private function getCurrentArtist() {
        // Get current artist from session/database
    }
    
    private function handleFileUpload($file) {
        // Handle file upload logic
    }
    
    private function getAudioDuration($filePath) {
        // Get audio duration logic
    }
}