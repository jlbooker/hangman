<?php
  $className = 'Hangman';
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

  // $template['FORM_CONTENT'] = 'Pick a letter: ';
  // $template['GREETING'] = 'Welcome to Hangman';
  // $template['IMG_SRC'] =
  //   "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempt']}.gif";
  //$template['BLANKS_WORD'] = blanks('word_ses');
  //$template['ALPHABET'] = alphabet_list();

  //$template['IMG_SRC'] = 'http://localhost/phpwebsite/mod/hangman/img/hang' . $attempts . 'gif';

  //echo PHPWS_Template::process($template, 'hangman','game.tpl');

  // echo PHPWS_Template::process($template, 'hangman','game.tpl');
  $_SESSION['game'] = new Hangman();
  $_SESSION['game']->run_game();


?>
