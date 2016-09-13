<?php
  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);

  $template['FORM_CONTENT'] = 'Pick a letter: ';
  $template['GREETING'] = 'Welcome to Hangman';

  echo PHPWS_Template::process($template, 'hangman','game.tpl');

  //fxn to run game
  function run_game($words, $letter){
    $choice = $_GET["letter"];
  }
?>
