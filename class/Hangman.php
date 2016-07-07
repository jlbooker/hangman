<?php
  class Hangman
  {
    #Word to guess as a character array, associated
    #with a boolean to determine if a particular char
    #should be revealed.
    private $word;
    #Bank of letters to guess as character array.
    private $bank;
    #Correctly guessed letters, includes each instance
    #of letters that appear multiple times.
    private $correct;
    #The current hangman count. 6 = game over!
    private $hangCount;
    #The current action.
    private $action;

    public function __construct()
    {
      if(!isset($_GET['action']))
      {
          $_GET['action'] = 'game_start';
          $this->hangCount = 6;
      }

      if($_GET['action'] == 'new_game')
      {
          $this->fetchWord();
          $this->hangCount = 0;
      }



    }

    /*
    Fetches a random word from hangwords.txt. Stores the
    word as a character array in $_Session["word"]
    */
    public function fetchWord()
    {
      $myfile = file_get_contents(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
      $words = preg_split('/[\s]+/',$myfile);
      $randWord = $words[rand(0,count($words))];
      $_SESSION['word'] = (strtolower($randWord));
      $this->word = str_split($_SESSION['word']);
      var_dump($this->word);
    }

    /*
    Sets global variables to match super global variables.
    */
    public function updateSession()
    {

    }

    /*
    Uses $_GET to determine the current action
    */
    public function updateAction()
    {

    }

    /*
    Re-initializes the game. All super global variables
    cleared.
    */
    public function resetGame()
    {

    }

    /*
    Increases the hang count by one.
    */
    public function incrementHangCount()
    {
      $this->hangCount++;
    }

    /*
    Removes a letter from the letterbank.
    */
    public function bankRemoveLetter($letter)
    {

    }

    /*
    Checks to see if a letter is in the word to guess.
    */
    public function checkLetter($letter)
    {

    }

    /*
    Updates $word to indicate that the input letter
    has been revealed.
    */
    public function revealLetter($letter)
    {

    }

    /*
    Sets all of $word to true, revealing the whole word.
    */
    public function revealWord()
    {

    }

    /*
    Determines if the game is over (just checks $count)
    */
    public function isGameOver()
    {
      //works
      return $this->hangCount == 6;
    }

    /*
    Determines if the user won or lost.
    */
    public function isWinner()
    {
      //default
      return false;
    }

    public function getHangCount()
    {
      return $this->hangCount;
    }
  }
?>
