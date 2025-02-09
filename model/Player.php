<?php // Models/RegisteredUser.php



class Player extends User {
    private $likedSongs = [];
    private $playlists = [];
    
    public function __construct($id, $username, $email, $password) {
        parent::__construct($id, $username, $email, $password, 'user');
    }
    
    public function addToLikedSongs(Song $song) {
        $this->likedSongs[] = $song;
    }
    
    public function addPlaylist(Playlist $playlist) {
        $this->playlists[] = $playlist;
    }
}