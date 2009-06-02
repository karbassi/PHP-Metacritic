<?php
require_once 'metacritic.php';

// Retrieve the score for Rock Band for XBOX 360
$metacritic = new Metacritic(array('title' => 'Rock Band'));
?>
   <h1>Demo File</h1>
   
   <h2>Grabbing score #1</h2>
   <h3>Title:</h3>
   <p><?php echo $metacritic->title; ?></p>
   
   <h3>Score:</h3>
   <p><?php echo $metacritic->score; ?></p>
   
   <h3>Error:</h3>
   <p><?php echo $metacritic->error; ?></p>

<?php
$metacritic->getFresh();
?>

   <h2>Grabbing score #2</h2>
   <h3>Title:</h3>
   <p><?php echo $metacritic->title; ?></p>
   
   <h3>Score:</h3>
   <p><?php echo $metacritic->score; ?></p>
   
   <h3>Error:</h3>
   <p><?php echo $metacritic->error; ?></p>
