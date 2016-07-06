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

    public function display()
    {
      $pic = 'mod/hangman/img/hang6.gif';
      $picture[] = array('PICTURE' => "<img src=" . $pic . " />");

      //Module link takes text to display, module name, and an array of URL attributes to access with $_GET
      $avail = PHPWS_Text::moduleLink('a','hangman',array('action'=>'guess','letter'=>'a'));
      $available[] = array('LETTERS' => $avail);

      $tpl['pic'] = $picture;
      $tpl['letters'] = $available;
      //$tpl['cLetters'] =

      return PHPWS_Template::process($tpl, self::MODULE, self::FILE);
    }
}
?>
