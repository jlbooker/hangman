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

  /*
  Constuctor loads/saves game state and reads action tags
  to determine what to do.
  */
  public function __construct()
  {
    if(!isset($_GET['action']))
    {
      $_GET['action'] = 'new_game';
    }

    if($_GET['action'] == 'new_game')
    {
      $this->resetGame();
      $this->fetchWord();
      $this->hangCount = 0;
      $bankLetters = 'abcdefghijklmnopqrstuvwxyz';
      $this->bank = str_split($bankLetters);
    }
    else
    {
      $this->loadSession();
      if(!$this->isGameOver() &&
        $_GET['action'] == 'guessL')
      {
          $letter = $_GET['letter'];
          var_dump($letter);
          $this->checkLetter($letter);
      }
    }
    $this->saveSession();

    //MAIN DEBUG
    //var_dump($_GET['action']);
    //var_dump($this->word);
    //var_dump($this->hangCount);
    //var_dump($this->bank);
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
    for($x = 0; $x < count($letters); $x++)
    {
      $this->word[$letters[$x]] = false;
    }
  }

  /*
  Sets session variables to global variables.
  */
  public function saveSession()
  {
    $_SESSION['word'] = $this->word;
    $_SESSION['hangCount'] = $this->hangCount;
    $_SESSION['bank'] = $this->bank;
  }

  /*
  Sets global variables to session variables.
  */
  public function loadSession()
  {
    $this->word=$_SESSION['word'];
    $this->bank=$_SESSION['bank'];
    $this->hangCount=$_SESSION['hangCount'];
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
    $index = array_search($letter, $this->bank);
    unset($this->bank[$index]);
    var_dump($index);
    return !($index === FALSE);
  }

  /*
  Checks to see if a letter is in the word to guess.
  */
  public function checkLetter($letter)
  {
    if (array_key_exists($letter, $this->word))
    {
      $this->revealLetter($letter);
      $this->bankRemoveLetter($letter);
    }
    else
    {
      if($this->bankRemoveLetter($letter))
      {
        $this->incrementHangCount();
      }
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
      $this->word[$letter] = true;
    }
    var_dump($this->word);
  }

  /*
  Determines if the game is over.
  */
  public function isGameOver()
  {
    $count = 0;
    foreach($this->word as $letter => $reveal)
    {
      if($reveal == true)
      {
        $count++;
      }
    }
    var_dump($count);

    return $this->hangCount == 6 ||
      $count == count($this->word);
  }

  /*
  Determines if the user won or lost.
  */
  public function isWinner()
  {
    return ! ($this->hangCount == 6);
  }

  /*
  Returns the current hang count.
  */
  public function getHangCount()
  {
    return $this->hangCount;
  }

  /*
  Returns the current word to guess and its
  associated boolean panel values.
  */
  public function getWord()
  {
    return $this->word;
  }

  /*
  Returns the current work bank.
  */
  public function getBank()
  {
    return $this->bank;
  }
}
?>
