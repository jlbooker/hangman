<?php
  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);
  $_SESSION['word_ses'] = $word;
  $_SESSION['attempt'] = 0;
  define('PLACEHOLDER', "_ ");

  //fxn to display alphabet links
  function alphabet_list(){
    for ($i = 65; $i <= 90; $i++) {
      $letterLinks[] = '<a href="/phpwebsite/index.php?module=hangman&letter='.chr($i).'" class="myclass">'.chr($i).'</a>';
      }
    return implode(" ",$letterLinks);
  }

  $template['FORM_CONTENT'] = 'Pick a letter: ';
  $template['GREETING'] = 'Welcome to Hangman';
  $template['IMG_SRC'] =
    "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempt']}.gif";
  $template['BLANKS_WORD'] = blanks('word_ses');
  $template['ALPHABET'] = alphabet_list();

  //$template['IMG_SRC'] = 'http://localhost/phpwebsite/mod/hangman/img/hang' . $attempts . 'gif';

  echo PHPWS_Template::process($template, 'hangman','game.tpl');

  //fxn for display of placeholder
  function blanks($word){
    $place_holder = "";
    for($i = 0; $i <= strlen($word); $i++){
      $place_holder .= PLACEHOLDER;
    }
    return $place_holder;
  }

  //fxn to run game
  function run_game($word){
    $word = $_SESSION['word_ses'];
    $attempts = $_SESSION['attempt'];
    $blank_spaces = blanks($word);

      while($attempts > 0 && $attempts < 7){
        $pos = strpos($word, $_GET['letter']);

        if($pos === false){
          $attempts = $attempts + 1;

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['RESPONSE'] = 'Continue your game.
            You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] =
            "http://localhost/phpwebsite/mod/hangman/img/hang$attempts.gif";
          $template['BLANKS_WORD'] = $blank_spaces;
          $template['GREETING'] = 'Your letter was not part of the word.';

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }else{

          for($i = 0; $i <= strlen($word); $i++){
            if($word[$i] == $_GET['letter']){
              $blank_spaces[$i] = $_GET['letter'];
            }
          }

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['GREETING'] = 'Continue your game.
            You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] =
            "http://localhost/phpwebsite/mod/hangman/img/hang$attempts.gif";
          $template['BLANKS_WORD'] = $blank_spaces;
          $template['RESPONSE'] = 'Your letter was found in the word!';

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
      }

      if($pos = strpos($blank_spaces, '_ ')){
        $template['FORM CONTENT'] = 'You lost the game!';
        $template['GREETING'] = 'Better luck next time.';
        $template['IMG_SRC'] =
          "http://localhost/phpwebsite/mod/hangman/img/hang6.gif";
        $template['BLANKS_WORD'] = word_ses;
        $template['RESPONSE'] = 'Click here to start a new game:
          <a href="/phpwebsite/index.php?module=hangman">New Game</a>';

        echo PHPWS_Template::process($template, 'hangman','game.tpl');
      }
    }

run_game('word_ses');

?>
