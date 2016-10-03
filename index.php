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
  if(isset($_GET['LINK'])){
      unset($_REQUEST['letter']);
      $game->makeGame();
      $game->initial();
  }
  else {
      $game = makeGame();
  }

  if(isset($_REQUEST['letter'])){
      $game->run_game();
  }
  else{
      $game->initital();
  }
  saveGame($game);
  $game->render();

  function makeGame(){
      if(!isset($_REQUEST['letter'])){
          $word = chooseWord();
          $_SESSION['word'] = $word;
          $_SESSION['wrongAttempts'] = 0;
          $wrongAttempts = $_SESSION['wrongAttempts'];
          $_SESSION['usedLetters'] = array();
          $usedLetters = $_SESSION['usedLetters'];
          $_SESSION['places'] = [];
          $place_holder = $_SESSION['places'];
      }
      else if(isset($_SESSION['word'])){
          $word = $_SESSION['word'];
          $wrongAttempts = $_SESSION['wrongAttempts'];
          $usedLetters = $_SESSION['usedLetters'];
          $place_holder = $_SESSION['places'];
      }
      else{
          $word = chooseWord();
          $_SESSION['word'] = $word;
          $_SESSION['wrongAttempts'] = 0;
          $wrongAttempts = $_SESSION['wrongAttempts'];
          $_SESSION['usedLetters'] = array();
          $usedLetters = $_SESSION['usedLetters'];
          $_SESSION['places'] = [];
          $place_holder = $_SESSION['places'];
      }
      return new Hangman($word, $wrongAttempts, $usedLetters, $place_holder);

  }

  function saveGame(Hangman $obj){
      $_SESSION['word'] = $obj->getWord();
      $_SESSION['wrongAttempts'] = $obj->getWrongAttempts();
      $_SESSION['usedLetters'] = $obj->getUsedLetters();
      $_SESSION['places'] = $obj->getPlaces();

  }

  function chooseWord(){
      $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
      $word = $word_list[array_rand($word_list, 1)];
      $word = strtolower($word);
      $word = preg_replace('/[^a-z]/', '', $word);

      return $word;
  }
