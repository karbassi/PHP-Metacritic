<?php
require_once 'metacritic.php';

// Retrieve the score for Rock Band for XBOX 360
$metacritic = new Metacritic('Rock Band');
$score = $metacritic->score;
$title = $metacritic->title;

echo 'Title: ', $title, "<br>\n";
echo 'Score: ', $score, "<br>\n";