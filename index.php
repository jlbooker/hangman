<?php
  $className = 'Hangman';
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);

  // $template['FORM_CONTENT'] = 'Pick a letter: ';
  // $template['GREETING'] = 'Welcome to Hangman';
  // $template['IMG_SRC'] =
  //   "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempt']}.gif";
  //$template['BLANKS_WORD'] = blanks('word_ses');
  //$template['ALPHABET'] = alphabet_list();

  //$template['IMG_SRC'] = 'http://localhost/phpwebsite/mod/hangman/img/hang' . $attempts . 'gif';

  //echo PHPWS_Template::process($template, 'hangman','game.tpl');

  // echo PHPWS_Template::process($template, 'hangman','game.tpl');
  $gameNew = new Hangman($word, 0);
  $_SESSION['game'] = $gameNew;

?>
