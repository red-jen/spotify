<?php
// repositories/SongRepository.php
class SongRepository {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function createSong($title, $artistId, $duration, $filePath) {
        $stmt = $this->db->prepare(
            "INSERT INTO songs (title, artist_id, duration, file_path) 
             VALUES (:title, :artist_id, :duration, :file_path)
             RETURNING id"
        );
        
        $stmt->execute([
            'title' => $title,
            'artist_id' => $artistId,
          
            'duration' => $duration,
            'file_path' => $filePath
          
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Song(
            $result['id'],
            $title,
            $artistId,
      
            $duration,
            $filePath
        );
    }



    
    public function getAllSongs() {
        $query = "
            SELECT 
                songs.*, 
                users.username AS artist_name 
            FROM 
                songs 
            JOIN 
                users 
            ON 
                songs.artist_id = users.id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}