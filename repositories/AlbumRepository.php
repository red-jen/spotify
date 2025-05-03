<?php
class AlbumRepository {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function createAlbum($title, $artistId, $releaseDate, $coverImage = null) {
        $stmt = $this->db->prepare(
            "INSERT INTO albums (title, artist_id, release_date, cover_image) 
             VALUES (:title, :artist_id, :release_date, :cover_image)
             RETURNING id"
        );
        
        $stmt->execute([
            'title' => $title,
            'artist_id' => $artistId,
            'release_date' => $releaseDate,
            'cover_image' => $coverImage
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Album(
            $result['id'],
            $title,
            $artistId,
            $releaseDate,
            $coverImage
        );
    }
}// Added dummy PHP comment for testing
