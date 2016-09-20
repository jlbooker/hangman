<?php
  class Hangman{
    private $_SESSION['word'];
    private $_SESSION['letterLinks'];
    private $_SESSION['attempts'];
    define('PLACEHOLDER', "_ ");


    //constructor
    function __constructor($word, $letterLinks, $attempts){
      $_SESSION['word'] = $word;
      $_SESSION['letterLinks'] = $letterLinks;
      $_SESSION['attempts'] = $attempts;

      // $template['FORM_CONTENT'] = 'Pick a letter: ';
      // $template['GREETING'] = 'Welcome to Hangman';
      // $template['IMG_SRC'] =
      //   "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempt']}.gif";
      // $template['BLANKS_WORD'] = blanks('word_ses');
      // $template['ALPHABET'] = alphabetList();
      //
      // echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }

    //fxn to display alphabet links
    function alphabetList(){
      for ($i = 65; $i <= 90; $i++) {
        $letterLinks[] = '<a href="/phpwebsite/index.php?module=hangman&letter='.chr($i).'" class="myclass">'.chr($i).'</a>';
        }
      return implode(" ",$letterLinks);
    }

    //fxn for display of placeholder
    function blanks($word){
      $place_holder = "";
      for($i = 0; $i <= strlen($word); $i++){
        $place_holder .= PLACEHOLDER;
      }
      return $place_holder;
    }

  }
