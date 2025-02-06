<?php
class Artist extends User {
    private array $songs;
    private array $album;



    public function Creatsong($title,$audio){
       
        $song = new Song($this->getId(),$title,$audio);
        $song->save();

    }
     

    public function CreatAlbum($album){
       
       
    }
    public function deleteSong($title,$audio){
       
        $song = new Song($this->getId(),$title,$audio);
        $song->save();

    }



}