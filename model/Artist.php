<?php



class Artist extends User {
    private $songs = [];
    
    public function __construct($id, $username, $email, $password) {
        parent::__construct($id, $username, $email, $password, 'artist');
    }
    
    public function getSongs() {
        return $this->songs;
    }
    
    public function addSong(Song $song) {
        $this->songs[] = $song;
    }
}