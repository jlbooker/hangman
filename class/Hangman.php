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
    private $count;
    #The current action.
    private $action;

    public function __construct()
    {

    }

    /*
    Fetches a random word from hangwords.txt. Stores the
    word as a character array in $_Session["word"]
    */
    public function fetchWord()
    {

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
      //default
      return true;
    }

    /*
    Determines if the user won or lost.
    */
    public function isWinner()
    {
      //default
      return true;
    }
  }
?>
