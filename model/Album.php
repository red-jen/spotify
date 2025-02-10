<?php
// model/Album.php
class Album {
    private $id;
    private $title;
    private $artistId;
    private $releaseDate;
    private $coverImage;
    private $songs = [];
    
    public function __construct($id, $title, $artistId, $releaseDate, $coverImage = null) {
        $this->id = $id;
        $this->title = $title;
        $this->artistId = $artistId;
        $this->releaseDate = $releaseDate;
        $this->coverImage = $coverImage;
    }
    
    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getArtistId() { return $this->artistId; }
    public function getReleaseDate() { return $this->releaseDate; }
    public function getCoverImage() { return $this->coverImage; }
    public function getSongs() { return $this->songs; }
    
    public function addSong(Song $song) {
        $this->songs[] = $song;
    }
}