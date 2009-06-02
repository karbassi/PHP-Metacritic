<?php
/**
 * Finds the score for Xbox Game sent in.
 *
 * @author Ali Karbassi
 * @version 0.2
 * @copyright Ali Karbassi, 1 June, 2008
 * @package Metacritic
 **/

/**
 * Finds the score from metacritic.com for Xbox 360 games sent in.
 *
 * @package Metacritic
 * @author Ali Karbassi
 */
class Metacritic
{
   // Time, in minutes, before checking for file again.
   private $CACHE_TIME = 10;
   
   private static $score = null;
   private static $title = null;
   private static $type = null;
   private static $error = null;
   private $last_retrieved = 0;
   
   
   // 
   private $url = null;
   
   
   private $TYPES = array(
      // Movies
      'film',
      
      // DVDs
      'video',
      
      // TV
      'tv',
      
      // Music
      'music',
      
      // Games
      'games',
      
      // Books
      'books'
   );
   
   // Game platforms
   private $PLATFORMS = array(
      // Sony Playstation
      'ps3', 'ps2', 'playstation', 'psp',
      // Microsoft Xbox
      'xbox360', 'xbox',
      // Nintendo
      'wii', 'ds', 'gba', 'gamecube', 'n64',
      // Other platforms
      'pc', 'ngage', 'dreamcast'
   );
   
   
      
      
   
   /**
    * Constructor
    *
    * @param string $title Game name
    * @param string $debug Display debug; Default: false
    * @return void
    * @author Ali Karbassi
    */
   // public function __construct($title, $type='games', $platform='xbox360',
   //    $CACHE_TIME=10)
   // {
   public function __construct($options=array())
   {
      if (empty($options)) {
         $this->error = "Options not set";
         return $this->error;
      }
      $this->title = $title;
      $this->url = 'http://www.metacritic.com/print/' . $type
         . '/platforms/' . $platform . '/'
         . preg_replace("/[^a-zA-Z0-9s]/", "", strtolower($this->title));
      $this->score = $this->parseScore($this->getPage($this->url));
   }
   
   public function getFresh()
   {
      $this->score = $this->parseScore($this->getPage($this->url));
   }
   
   
   /**
    * Returns called property
    *
    * @param string $property 
    * @return void
    * @author Ali Karbassi
    */
   public function __get($property)
   {
      return $this->$property;
   }

   /**
    * Scrapes url for parsing.
    *
    * @param string $url URL to scrape
    * @return string Page output
    * @author Ali Karbassi
    */
   private function getPage($url)
   {
      if (time() >= ($this->last_retrieved + (CACHE_TIME * 60))) {
         $ch = curl_init($url);
         curl_setopt($ch, CURLOPT_HEADER, 0);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         $this->score = curl_exec($ch);
         curl_close($ch);
         $this->last_retrieved = time();
      }
      return $this->score;
   }
   
   /**
    * Finds the score and returns it. If not found, will return 'xx'
    *
    * @param string $page Page out put
    * @return mixed Score integer or xx
    * @author Ali Karbassi
    */
   
   private function parseScore($page)
   {
      //<SPAN CLASS="metascore">XX</SPAN>
      $regexp = '/\<SPAN CLASS\="metascore"\>(.*?)<\\/SPAN>/is';
      preg_match($regexp, $page, $matches);

      if( ctype_digit( $matches[1] ) )
      {
         return (int) $matches[1];
      }
      else
      {
         return 'xx';
      }
   }
}
?>