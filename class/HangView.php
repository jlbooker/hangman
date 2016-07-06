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
      $pic = 'mod/hangman/img/hang6.gif';
      $picture[] = array('PICTURE' => "<img src=" . $pic . " />");

      //Module link takes text to display, module name, and an array of URL attributes to access with $_GET
      //$available needs the name of the desired template holder and content to place
      $avail = PHPWS_Text::moduleLink('a','hangman',array('action'=>'guess','letter'=>'a'));
      $available[] = array('LETTERS' => $avail);

      //$tpl refers to lowercase comment tag names in hangview.tpl
      $tpl['pic'] = $picture;
      $tpl['letters'] = $available;
      //$tpl['cLetters'] =

      return PHPWS_Template::process($tpl, self::MODULE, self::FILE);
    }

    /*
    Determines the hangman image based on $hangman's $count.
    */
    public function getImage()
    {

    }

    /*
    Determines the letter panel display based on which
    letters have been correctly guessed.
    */
    public function getLetterPanel()
    {

    }

    /*
    Determines how to display the guess form.
    */
    public function getGuessForm()
    {

    }

    /*
    Determines how to display the letter bank.
    */
    public function getLetterBank()
    {

    }
}
?>
