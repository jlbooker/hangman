<?php
  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);
  $_SESSION['word_ses'] = $word;
  $attempts = 0;
  $place_holder = "_ ";

  //fxn to display alphabet links
  function alphabet_list(){
    for ($i = 65; $i <= 90; $i++) {
    printf('<a href="/phpwebsite/index.php?module=hangman&letter=%1$s" class="myclass">%1$s</a> ', chr($i));
    global $_SESSION['letter'] = chr($i);
    }
  }

  $template['FORM_CONTENT'] = 'Pick a letter: ';
  $template['GREETING'] = 'Welcome to Hangman';
  $template['IMG_SRC'] = "http://localhost/phpwebsite/mod/hangman/img/hang$attempts.gif";
  $template['BLANKS_WORD'] = blanks('word_ses');
  $template['ALPHABET'] = alphabet_list();

  //$template['IMG_SRC'] = 'http://localhost/phpwebsite/mod/hangman/img/hang' . $attempts . 'gif';

  echo PHPWS_Template::process($template, 'hangman','game.tpl');

  //fxn for display of placeholder
  function blanks($word){
    for($i = 0; $i <= strlen($word); $i++){
      global $place_holder;
      $place_holder .= "_ ";
    }
    return $place_holder;
  }

  //fxn to run game
  function run_game($word){
    global $word, $attempts;
    $blank_spaces = blanks($words);

      while($attempts < 7){
        $pos = strpos($word, 'letter');

        if($pos === false){
          $attempts = $attempts + 1;

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['RESPONSE'] = 'Continue your game. You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] = "http://localhost/phpwebsite/mod/hangman/img/hang$attempts.gif";
          $template['BLANKS_WORD'] = $blank_spaces;
          $template['GREETING'] = 'Your letter was not part of the word.';

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
        else{

          for($i = 0; $i <= strlen($word); $i++){
            if($word[i] == $letter_choice){
              $blank_spaces[$i] = $letter_choice;
            }
          }

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['GREETING'] = 'Continue your game. You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] = "http://localhost/phpwebsite/mod/hangman/img/hang$attempts.gif";
          $template['BLANKS_WORD'] = $blank_spaces;
          $template['RESPONSE'] = 'Your letter was found in the word!';

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
      }
    }

run_game('word_ses');

?>
