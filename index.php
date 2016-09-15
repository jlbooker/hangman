<?php
  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);
  $images = [file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang0.gif'), file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang1.gif'),
    file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang2.gif'), file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang3.gif'),
    file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang4.gif'), file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang5.gif'),
    file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang6.gif')];
  $attempts = 0;
  $place_holder = "_ ";

  $template['FORM_CONTENT'] = 'Pick a letter: ';
  $template['GREETING'] = 'Welcome to Hangman';
  $template['IMG_SRC'] = $images[$attempts];

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
    $letter_choice = $_POST['letter'];
    global $word, $attempts;
    $blank_spaces = blanks($words);

    if(strlen($letter_choice) > 1){
      echo "Please, only choose 1 letter.";
      echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }
    else{
      for($i = 0; $i <= strlen($word); $i++){
        echo "_ ";
      }

      while($attempts < 7){
        $pos = strpos($word, $letter_choice);

        if($pos === false){
          echo "Your letter was not part of the word.";
          $attempts = $attempts + 1;

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['GREETING'] = 'Continue your game. You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] = $images[$attempts];
          $template['BLANKS_WORD'] = $blank_spaces;

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
        else{
          echo "Your letter was found in the word!";

          for($i = 0; $i <= strlen($word); $i++){
            if($word[i] == $letter_choice){
              $blank_spaces[$i] = $letter_choice;
            }
          }

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['GREETING'] = 'Continue your game. You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] = $images[$attempts];
          $template['BLANKS_WORD'] = $blank_spaces;

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
      }
    }
  }

  run_game($word);

?>
