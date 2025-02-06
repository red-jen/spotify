<?php // Models/RegisteredUser.php
require_once('user.php');
class Player extends User {
    private array $likedSongs;
    private array $followedPlaylists;

    public function __construct(int $id, string $name, string $email, string $password) {
        parent::__construct($id, $name, $email, $password, 'Player');
        $this->likedSongs = [];
        $this->followedPlaylists = [];
    }

    public function createPlaylist(string $title, string $visibility): Playlist {
        return new Playlist($this->id, $title, $visibility);
    }

    public function deletePlaylist(int $playlistId): void {
        // Implementation will be in PlaylistRepository
    }

    public function likeSong(Song $song): void {
        $this->likedSongs[] = $song;
    }

    public function followPlaylist(Playlist $playlist): void {
        $this->followedPlaylists[] = $playlist;
    }
}