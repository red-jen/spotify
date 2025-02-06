<?php

class Playlist {
    private int $id;
    private array $songs;
    private string $name;
    private string $owner;

    public function getId(){
       return  $this->id;
    }
    public function settId($id){
        $this->id = $id;
    }

    public function UploadSong(){

    }
    public function RemoveSong(){
        
    }
    public function DeletePlaylist(){

    }
    public function AddPlaylist(){
        
    }

}