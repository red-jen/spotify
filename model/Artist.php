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
// class Artist extends User {
//     private array $songs;
//     private array $album;



//     public function Creatsong($title,$audio){
       
//         $song = new Song($this->getId(),$title,$audio);
//         $song->save();

//     }
     

//     public function CreatAlbum($album){
       
       
//     }
//     public function deleteSong($title,$audio){
       
//         $song = new Song($this->getId(),$title,$audio);
//         $song->save();

//     }



// }



