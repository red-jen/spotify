<?php 

echo "hey there";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@NaN,300,0,0" />
  <link rel="stylesheet" href="style.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="meta/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="meta/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="meta/favicon-16x16.png">
<link rel="manifest" href="meta/site.webmanifest">
<link rel="mask-icon" href="meta/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<script src="https://kit.fontawesome.com/30ba74ff6e.js" crossorigin="anonymous"></script>
  <title>Spotify Clone-by Raghvendra Misra</title>
  
</head>

<body >
  <div class="maincontainer"  style="max-height: 100vh; overflow: hidden; " custom attribute="0">
    <div class="sidebar">
      <div class="loadingSideBar">
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>
        <div class="loadingElSidebar"></div>

      </div>
      <div class="sidebaruppersection">
        <img class="logo" src="meta/logo.png">
        <div class="icon" id="homeicon">
          <span id="homeicon-svg" class="material-symbols-rounded" >Home</span>
        <p class="icontext" id="homeicon-text">Home</p> 
        </div>
     
        <div  id="searchicon" class="icon">
          <span  id="searchicons-svg" class="fa-solid fa-magnifying-glass"></span>
          <p class="icontext" id="searchicon-text">Search</p>
        </div>
      </div>
      <div class="sidebarlowersection">
        <div class="icon" id="libraryicon">
          <span id="libraryicon-svg" class="material-symbols-outlined">library_music</span>
          <p class="icontext" id="libraryicon-text">Your Library</p>
          <span id="plusiconsvg" class="material-symbols-outlined">add</span>
          <span id="leftarrowiconsvg" class="material-symbols-outlined" >
            arrow_right_alt
          </span>
        </div>
        <div class="tagcontainer">
          <span id="crossicontag-svg" class="material-symbols-outlined">close</span>
          <span class="playlisttag" id="playlisttag1">Playlists</span>
          <span class="artisttag">Artists</span>
        </div>

        <div class="icon" id="recenticon">
          <form >
            
            <button>
              <span id="searchicons-svg2" class="material-symbols-outlined">search</span>
            </button>
            <input type="text" placeholder="Search in your library" id="searchtextfeild" name="song"
              autocomplete="off" />
            <span id="crossicon-svg" class="material-symbols-outlined">close</span>
          </form>

          <div class="recenticon-cont">
            <span class="recenticon-text">Recents</span>
            <span id="recenticon-svg" class="material-symbols-outlined">
              density_small
            </span>
          </div>
        </div>
        <div class="defaultlistings">
          <div class="playlistsideblock1">
            <img src="https://misc.scdn.co/liked-songs/liked-songs-64.png" class="playlist-thumb" />
            <div class="textforplaylist">
              <p class="playlistname">Default Songs</p>
              <p class="thumbnaillabel">Playlist &#8226; 25 songs</p>
            </div>
          </div>
         
          <div class="failedtosearch">
            <h3></h3>
            <p>Try searching again using different spelling or keyword.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="musicBar">
      <div id="loadingMusicBar"style="padding:0;  overflow: hidden;"class="loadingSideBar">
        <div class="loadingElMusicbar">
          <div class="loadingMusicbarEl"></div>
        <div class="loadingMusicbarEl"></div>
        <div class="loadingMusicbarEl"></div>
        </div>
        

      </div>
      <div class="currentSong">
        <img src="https://i.scdn.co/image/ab67616d000048512432edc97b465e6db54d356b"
        class="main-window-playlist-thumb" crossorigin="anonymous" />
        <div class="currentMusic-Player">
        <div contenteditable=""><p></p></div>
        </div>
        <span id="likeicon"
            class="material-symbols-outlined">
            favorite
          </span>
       
      </div>
      <div class="controls">
        <div class="mainControls">
          <span class="material-symbols-outlined"id="controlicon-shuffle">
            shuffle
            </span>
          <span   class="material-symbols-outlined" id="controlicon-prev">
            skip_previous
            </span>

          <span   class="material-symbols-outlined" id="controlicon-play">
            play_circle
            </span>
            <span   class="material-symbols-outlined" id="controlicon-next">
              skip_next
              </span>
              <span  class="material-symbols-outlined" id="controlicon-loop">
                laps
                </span>
        </div>
        <div class="centerControls">
          <p id="currentTime">
            1:10
          </p>
          <div class="progressBar">
            <div class="pbarTargetArea"></div>
            <div class="progressBarFill">
              <div id="progressbarBullet"></div>
            </div>
          </div>
          <p id="totalDuration">
            3:30
          </p>
          
        </div>
        

      </div>
      <div class="sideControls">
        <span id="sideControls-veiw" class="material-symbols-outlined">
          slideshow
          </span>
          <span id="sideControls-sound" class="material-symbols-outlined">
            volume_up
            </span>
        <div class="volumeBar">
          <div class="vbarTargetArea"></div>
          <div class="volumeBarFill">
            <div id="volumebarBullet"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="nowPlayingVeiw" >
      <div class="nowplayingHeader"><h3 class="NowPlaying">Now Playing</h3><span id="nowPlayingClose" class="material-symbols-outlined">
        close
        </span></div>
      <img class="nowPlayingMainImg"src="https://i.scdn.co/image/ab67616d00001e02021d7017f73387b008eab271">
       <p class="nowPlayingSongName">Satranga ( "Animal")</p>
       <p class="nowPlayingSongArtist">Arijit Singh, Shreyas Puranik</p>
       <div class="inQueueSongs">
        <h3 class="nextInQueue">Next in Queue</h3>
        <div class="inQueueSong1">
          <span id="nowPlayingPlayIcon"class="material-symbols-outlined">
            play_arrow
            </span>
            <div class="bars">
              <div class="bars__item"></div>
              <div class="bars__item"></div>
              <div class="bars__item"></div>
              <div class="bars__item"></div>
          </div>
          <img src="" >
          <div class="textForSong">
            <p class="queueSongName"></p>
            <p class="queueSongArtist"></p>
          </div>
        </div>

       </div>
    </div>
    <div class="mainwindow">
      <div class="loadingMainWindow">
       <div class="loadingNav">      
          <div class="loadingElSidebar1"></div>
          <div class="loadingElSidebar2"></div>
         </div>
        
        <div style="margin-top:20vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        <div style="margin-top:5vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        <div style="margin-top:5vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        <div style="margin-top:5vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        <div style="margin-top:5vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        <div style="margin-top:5vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        <div style="margin-top:5vh ;width:30%;" class="loadingElMainwindow"></div>
        <div class="loadingElMainwindowCardCont">
          <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div> 
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        <div class="loadingElCard"></div>
        </div>
        
      </div>
      <nav class="mainNav" style="width:102%">
        
        <nav>
          <div class="wrapperForSearchBar-Chev">
          <div class="wrapper1stInNav">
          <span id="chev1" title="Previous page" class="material-symbols-outlined">
            arrow_back_ios_new
          </span>
          <span id="chev" title="Next page" class="material-symbols-outlined">
            arrow_forward_ios
          </span>
        </div>
          <div class="mainSearchBarCont">
            <span class="fa-solid fa-magnifying-glass" id="mainSearchBtn"></span>
            <input type="text" value="" placeholder="What do you want to play?" id="mainSearchBar" autocomplete="off">
            <span class="material-symbols-rounded" id="mainSearchCancelBtn">close</span>
          </div>
        
      </div>
          <div class="wrapper2ndInNav">
          <span id="followme" style="pointer-events: all; cursor: pointer;">Follow Me!</span>
          <span id="bell-icon" class="material-symbols-outlined">
            notifications
          </span>
          <img
            src="https://lh3.googleusercontent.com/a/ACg8ocJhyjBqGFbQGs9SYJUCevspX0GwSJKbYSCdbpjUrakHr4g=s288-c-no" />
          </div>
          </nav>
        <div class="tagcontainer2">
          <span id="crossicontag-svg" class="material-symbols-outlined">close</span>
          <span class="alltag">All</span>
          <span class="musictag">Music</span>
          <span class="playlisttag">Playlists</span>
        </div>
      </nav>
      <div class="mainwindow-cont-wrapper">
      <div class="mainwindow-cont-wrapper-home">
      <div class="uppersection1-mainwindow">
        <div class="uppercard">
          <img src="https://misc.scdn.co/liked-songs/liked-songs-64.png" class="main-window-playlist-thumb" />Liked
          Songs<span id="playicon" class="material-symbols-outlined">
            play_arrow
          </span>
        </div>
        <div class="uppercard">
          <img src="https://i.scdn.co/image/ab67616d000048512432edc97b465e6db54d356b"
            class="main-window-playlist-thumb" />Phir Mohobbat (Md.Irfan, Arijit Singh)<span id="playicon"
            class="material-symbols-outlined">
            play_arrow
          </span>
        </div>
        <div class="uppercard">
          <img src="https://i.scdn.co/image/ab67616d000048517b93fd8b0ade33ceb9d536de"
            class="main-window-playlist-thumb" />Duniyaa (Akhil, Dhvani Bhanushali<span id="playicon"
            class="material-symbols-outlined">
            play_arrow
          </span>
        </div>
      </div>
      <div class="uppersection2-mainwindow">
        <div class="uppercard">
          <img src="https://i.scdn.co/image/ab67616d00004851333548f23189291acdee787d"
            class="main-window-playlist-thumb" />4:10 AM (DIVINE, Lal Chand Yamla Jatt)<span id="playicon"
            class="material-symbols-outlined">
            play_arrow
          </span>
        </div>
        <div class="uppercard">
          <img src="https://i.scdn.co/image/ab67616d00004851021d7017f73387b008eab271"
            class="main-window-playlist-thumb" />Satranga (Arijit Singh, Shreyas Puranik)<span id="playicon"
            class="material-symbols-outlined">
            play_arrow
          </span>
        </div>
        <div class="uppercard">
          <img src="https://i.scdn.co/image/ab67616d000048514cfe2d352da6d7910961377f"
            class="main-window-playlist-thumb" />Labon Ko (Pritam, KK)<span id="playicon"
            class="material-symbols-outlined">
            play_arrow
          </span>
        </div>
      </div>

      <h3 id="charts">Weekly top charts</h3>
    </div>
    <div class="mainwindow-cont-wrapper-search">
      <div class="mainWindowSearchFail" style="color:white;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1vw;display:none;padding: 10vh;border-bottom: 1px solid rgba(255, 255, 255, 0.247);">
        <h3 class="failureText"style="padding:0;"></h3>
        <p >try searching using different spelling or keyword</p>
      </div>
      <div class="mainwindow-search-results">
            <div class="labelsForResultsCont">
              <p class="labelForResults">Title</p>
              <p class="labelForResults">Duration</p>
              <p class="labelForResults">Album</p>
            </div>
        </div>
      <div class="mainwindow-search-default">
        
        </div>
      </div>
    </div>
      </div>
    </div>
  </div>
    
  </div>

  <audio id="mainAudioEl" src="" type="audio/mp3"></audio>
  <audio id="tempAudioEl" src="" type="audio/mp3"></audio>

    
    
   
<div class="headerForPlayer">
  <span id="trigger" class="material-symbols-outlined">
    expand_more
    </span>
  <div class="title"><p>ddddd</p></div>
  <span id="triggerView" class="material-symbols-outlined">
    queue_music
    </span>
</div>  <div class="tooltipwr">
  <div class="tooltipCont" style="
  
  color: white;
  font-size: 1.2vw;
  padding: 1vw;
  /* display: none; */
">
    <h4 style="
  font-weight: 800;
  font-size: 1.5vw;
">Dig Deeper</h4>
    <p style="
  margin-top: 1vw;
  font-size: 1.2vw;
">Click on <b>Now Playing Veiw</b> Button to know what's playing and what's next!</p>
    <button id="tpbtn" style="
  background-color: white;
  padding: 0.5vw 1vw;
  border-radius: 2vw;
  margin-top: 1.5vw;
  cursor: pointer;
  font-weight: 550;
">Dismiss</button>
  </div>
</div>
<script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://unpkg.com/tippy.js@6"></script>
<script src="scripts/data.js"></script>
<script src="https://cdn.jsdelivr.net/npm/colorthief@2.3.2/dist/color-thief.min.js"></script>
<script src="scripts/utility.js"></script>
<script src="scripts/app.js"></script>
<script src="scripts/music.js"></script>
<script src="scripts/navigation.js"></script>
</body>

</html>