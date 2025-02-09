# spotify
@startuml

' Déclaration des classes principales
abstract class User {
  - id: int
  - name: string
  - email: string
  - password: string
  - role: string
  + login(): void
  + logout(): void
  + Register(): void
}

class RegisteredUser {
  - likedSongs: List<Song>
  - Playlists: List<Playlist>
  
  + createPlaylist(): void
  + deletePlaylist(): void
  + likeSong(Song): void

}

class Artist {
  - songs: List<Song>
  + uploadSong(Song): void
}

class Admin {
  + banUser(User): void
  + approveSong(Song): void
}

class Playlist {
  - id: int
  - title: string
  -
  
  + addSong(Song): void
  + removeSong(Song): void
}

class Song {
  - id: int
  - title: string
  - duration: string
  - artist: Artist
  - genre: string
  + play(): void
  + pause(): void
}




' Héritage entre classes
User <|-- RegisteredUser
User <|-- Artist
User <|-- Admin

' Associations normales
RegisteredUser "1" *- "*" Playlist : owns

Artist "1" -- "*" Song : uploads

Song "0_*" -- "0_*" Playlist



@enduml

