<?php
// views/artist/create-song.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Song</title>
</head>
<body>
    <h1>Upload New Song</h1>
    
    <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" action="/artist/create-song">
        <div>
            <label>Title:</label>
            <input type="text" name="title" required>
        </div>
        
        <div>
            <label>Audio File:</label>
            <input type="file" name="audio_file" accept="audio/*" required>
        </div>
        
        <div>
            <label>Duration (seconds):</label>
            <input type="number" name="duration" required>
        </div>
        
        <!-- <div>
            <label>Genre:</label>
            <input type="text" name="genre">
        </div>
        
        <div>
            <label>Album:</label>
            <select name="album_id">
                <option value="">No Album</option>
                <!-- Add PHP code to populate albums -->
            </select>
        </div> -->
        
        <button type="submit">Upload Song</button>
    </form>
</body>
</html>

<?php
// views/artist/create-album.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Album</title>
</head>
<body>
    <h1>Create New Album</h1>
    
    <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label>Title:</label>
            <input type="text" name="title" required>
        </div>
        
        <div>
            <label>Release Date:</label>
            <input type="date" name="release_date" required>
        </div>
        
        <div>
            <label>Cover Image:</label>
            <input type="file" name="cover_image" accept="image/*">
        </div>
        
        <button type="submit">Create Album</button>
    </form>
</body>
</html>