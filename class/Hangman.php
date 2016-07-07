<?php
  class Hangman
  {
    #Word to guess as a character array, associated
    #with a boolean to determine if a particular char
    #should be revealed.
    private $word;
    #Bank of letters to guess as character array.
    private $bank;
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
          $bankLetters = 'abcdefghijklmnopqrstuvwxyz';
          $this->bank = str_split($bankLetters);
          var_dump($this->bank);
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
      $randWord = strtolower($words[rand(0,count($words))]);
      $letters = str_split($randWord);
      var_dump($letters);
      for($x = 0; $x < count($letters); $x++)
      {
        $this->word[$letters[$x]] = false;
      }
    }

    /*
    Sets global variables to match super global variables.
    */
    public function updateSession()
    {
      $_SESSION['word'] = $this->word;
      $_SESSION['hangCount'] = $this->hangCount;
      $_SESSION['bank'] = $this->bank;
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
      unset($_SESSION['word']);
      unset($_SESSION['hangCount']);
      unset($_SESSION['bank']);
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
      if(array_search($letter))
      {
        unset($this->bank[$letter]);
      }
    }

    /*
    Checks to see if a letter is in the word to guess.
    */
    public function checkLetter($letter)
    {
      if (array_key_exists($letter, $this->word))
      {
        revealLetter($letter);
      }
    }

    /*
    Updates $word to indicate that the input letter
    has been revealed.
    */
    public function revealLetter($letter)
    {
      $this->word[$letter] = true;
    }

    /*
    Sets all of $word to true, revealing the whole word.
    */
    public function revealWord()
    {
      foreach($this->word as $letter => $reveal)
      {
        $reveal = true;
      }

      $this->hangCount = 6;
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
      foreach($this->word as $letter => $reveal)
      {
        if(!$reveal)
        {
          return false;
        }
      }

      return true;
    }

    public function getHangCount()
    {
      return $this->hangCount;
    }

    public function getWord()
    {
      return $this->word;
    }

    public function getBank()
    {
      return $this->bank;
    }
  }
?>
