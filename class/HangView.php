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
      $tpl['pic'] = $picture;

      return PHPWS_Template::process($tpl, self::MODULE, self::FILE);
    }
}
?>
