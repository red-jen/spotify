
<?php
require_once '../config/database.php';
require_once '../model/Song.php';

// require_once 'layout/header.php';
$db = Database::getInstance()->getConnection();
$songRepository = new SongRepository($db);
$songs = $songRepository->getAllSongs();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>


<div class="maincontainer">
    <div class="sidebar">
        <!-- Keep your existing sidebar content -->
    </div>
    
    <div class="mainwindow">
        <div class="songs-container">
            <h2>All Songs</h2>
            <div class="songs-grid">
                <?php foreach ($songs as $song): ?>
                    <div class="song-card" data-song-id="<?php echo htmlspecialchars($song['id']); ?>">
                        <img src="<?php echo htmlspecialchars($song['cover_image']); ?>" 
                             alt="<?php echo htmlspecialchars($song['title']); ?>" 
                             class="song-cover">
                        <div class="song-info">
                            <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                            <p><?php echo htmlspecialchars($song['artist_name']); ?></p>
                        </div>
                        <button class="play-btn" onclick="playSong(<?php echo $song['id']; ?>)">
                            <span class="material-symbols-outlined">play_arrow</span>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="musicBar">
        <!-- Keep your existing music bar content -->
    </div>
</div>
  
</body>
</html>