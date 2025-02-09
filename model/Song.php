<?php 
class Song {
    private $id;
    private $title;
    private $artistId;
    private $albumId;
    private $duration;
    private $filePath;
    private $genre;
    
    public function __construct($id, $title, $artistId, $albumId, $duration, $filePath, $genre = null) {
        $this->id = $id;
        $this->title = $title;
        $this->artistId = $artistId;
        $this->albumId = $albumId;
        $this->duration = $duration;
        $this->filePath = $filePath;
        $this->genre = $genre;
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getArtistId() { return $this->artistId; }
    public function getAlbumId() { return $this->albumId; }
    public function getDuration() { return $this->duration; }
    public function getFilePath() { return $this->filePath; }
    public function getGenre() { return $this->genre; }
}