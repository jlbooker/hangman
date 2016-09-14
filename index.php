<?php
  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);
  $attempts = 0;
  $place_holder = "_ ";

  $template['FORM_CONTENT'] = 'Pick a letter: ';
  $template['GREETING'] = 'Welcome to Hangman';
  $template['IMG_SRC'] = file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang0.gif');

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
    global $word, $place_holder, $attempts;

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
          $template['IMG_SRC'] = file(PHPWS_SOURCE_DIR . 'mod/hangman/img/hang1.gif'); //put imgs in array
          $template['BLANKS_WORD'] = blanks($word);

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
        else{
          echo "Your letter was found in the word!";

          for($i = 0; $i <= strlen($word); $i++){
            if($word[i] == $letter_choice){
              $plac_holder[$i] = $letter_choice;
            }
          }
        }
      }

    }
  }

?>
