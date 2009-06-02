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
   private static $score = null;
   private static $title = null;
   private static $type  = null;
   
   /**
    * Constructor
    *
    * @param string $title Game name
    * @param string $debug Display debug; Default: false
    * @return void
    * @author Ali Karbassi
    */
   public function __construct($title)
   {
      $this->title = $title;
      $url = 'http://www.metacritic.com/print/games/platforms/xbox360/'
         . preg_replace("/[^a-zA-Z0-9s]/", "", strtolower($title));
      $this->score = $this->parseScore($this->getPage($url));
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
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $score = curl_exec($ch);
      curl_close($ch);
      return $score;
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