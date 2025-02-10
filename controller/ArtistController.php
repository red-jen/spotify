<?php
// controller/ArtistController.php
class ArtistController {
    private $songRepository;
    private $albumRepository;
    
    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->songRepository = new SongRepository($db);
        $this->albumRepository = new AlbumRepository($db);
    }
    
    public function createSong() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include 'views/artist/create-song.php';
            return;
        }
        
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verify artist is logged in
        if (!isset($_SESSION['user']) ) {//|| $_SESSION['role'] !== 'artist'
            header('Location: /login');
            exit;
        }else{
            $teacher = unserialize($_SESSION['user']);
           if($teacher->getRole()!== 'artist') {
            echo 'your not him ';
            include 'views/home.php';

        }

        
        // Handle file upload
        $uploadDir = 'uploads/songs/';
        $audioFile = $_FILES['audio_file'] ?? null;
        
        if (!$audioFile || $audioFile['error'] !== UPLOAD_ERR_OK) {
            $error = 'Error uploading file';
            include 'views/artist/create-song.php';
            return;
        }
        
        // Process the upload
        $filePath = $uploadDir . uniqid() . '_' . basename($audioFile['name']);
        if (!move_uploaded_file($audioFile['tmp_name'], $filePath)) {
            $error = 'Failed to save file';
            include 'views/artist/create-song.php';
            return;
        }
        
        try {
            $song = $this->songRepository->createSong(
                $_POST['title'],
                $teacher->getId(),
                $_POST['duration'],
                $filePath
            );
            
            header('Location: /artist/songs');
            exit;
        } catch (Exception $e) {
            $error = 'Failed to create song: ' . $e->getMessage();
            include 'views/artist/create-song.php';
        }
    }}
    
    public function createAlbum() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include 'views/artist/create-album.php';
            return;
        }
        
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verify artist is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
            header('Location: /login');
            exit;
        }
        
        // Handle cover image upload
        $uploadDir = 'uploads/covers/';
        $coverImage = $_FILES['cover_image'] ?? null;
        $coverPath = null;
        
        if ($coverImage && $coverImage['error'] === UPLOAD_ERR_OK) {
            $coverPath = $uploadDir . uniqid() . '_' . basename($coverImage['name']);
            if (!move_uploaded_file($coverImage['tmp_name'], $coverPath)) {
                $error = 'Failed to save cover image';
                include 'views/artist/create-album.php';
                return;
            }
        }
        
        try {
            $album = $this->albumRepository->createAlbum(
                $_POST['title'],
                $_SESSION['user_id'],
                $_POST['release_date'],
                $coverPath
            );
            
            header('Location: /artist/albums');
            exit;
        } catch (Exception $e) {
            $error = 'Failed to create album: ' . $e->getMessage();
            include 'views/artist/create-album.php';
        }
    }
}