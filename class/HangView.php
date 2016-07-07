<?php
class HangView
{
    private $hangman;
    const MODULE = 'hangman';
    const FILE = 'hangview.tpl';

    public function __contruct(Hangman $hangman)
    {
      $this->hangman = $hangman;
    }

    /*
    Sets up the PHPWS_Template by filling in $tpl fields.
    */
    public function display()
    {
      //$tpl refers to lowercase comment tag names in hangview.tpl
      $tpl['pic'] = $this->getImage();
      $tpl['bank'] = $this->getLetterBank();
      $tpl['panel'] = $this->getLetterPanel();
      $tpl['form'] = $this->getGuessForm();
      $tpl['wlgame'] = $this->getWinLose();
      $tpl['ngame'] = $this->getNewGame();

      return PHPWS_Template::process($tpl, self::MODULE, self::FILE);
    }

    /*
    Determines the hangman image based on $hangman's $count.
    */
    public function getImage()
    {
      //default

      $pic = 'mod/hangman/img/hang6.gif';
      $picture[] = array('PICTURE' => "<img src=" . $pic . " />");
      return $picture;
    }

    /*
    Determines the letter panel display based on which
    letters have been correctly guessed.
    */
    public function getLetterPanel()
    {
      $letter = "Test Letter Panel";
      $letterPanel[] = array('LETTER_PANEL' => "<p>" . $letter . "</p>");
      return $letterPanel;
    }

    /*
    Determines how to display the guess form.
    */
    public function getGuessForm()
    {
      $guess = "Test Guess Form";
      $guessForm[] = array('GUESS_FORM' => "<p>" . $guess . "</p>");
      return $guessForm;
    }

    /*
    Determines how to display the letter bank.
    */
    public function getLetterBank()
    {
      //default
      //Module link takes text to display, module name, and an array of URL attributes to access with $_GET
      //$available needs the name of the desired template holder and content to place
      $bank = PHPWS_Text::moduleLink('a','hangman',array('action'=>'guess','letter'=>'a'));
      $letterBank[] = array('LETTER_BANK' => $bank);
      return $letterBank;
    }

    /*
    Determines whether to display a win/lose message.
    */
    public function getWinLose()
    {
      $win = "Test Win Lose";
      $winLose[] = array('WIN_LOSE' => "<p>" . $win . "</p>");
      return $winLose;
    }

    /*
    Determines how to display the new game button.
    */
    public function getNewGame()
    {
      $new = "Test New Game";
      $newGame[] = array('NEW_GAME' => "<p>" . $new . "</p>");
      return $newGame;
    }
}
?>
