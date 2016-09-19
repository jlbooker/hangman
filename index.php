<?php
  $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
  $word = $word_list[array_rand($word_list, 1)];
  $word = strtolower($word);
  $word = preg_replace('/[^a-z]/', '', $word);
  $attempts = 0;
  $place_holder = "_ ";

  $template['FORM_CONTENT'] = 'Pick a letter: ';
  $template['GREETING'] = 'Welcome to Hangman';
  $template['IMG_SRC'] = "http://localhost/phpwebsite/mod/hangman/img/hang$attempts.gif";

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
    if(isset($_POST['submit'])){

    $letter_choice = $_POST['letter'];
    global $word, $attempts;
    $blank_spaces = blanks($words);

    if(strlen($letter_choice) > 1){
      $template['REPONSE'] = 'Please, only choose 1 letter.';

      echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }
    else{
      for($i = 0; $i <= strlen($word); $i++){
        echo "_ ";
      }

      while($attempts < 7){
        $pos = strpos($word, $letter_choice);

        if($pos === false){
          $attempts = $attempts + 1;

          $template['FORM CONTENT'] = 'Pick another letter: ';
          $template['RESPONSE'] = 'Continue your game. You have ' . (6 - $attempts) . ' attempts left.';
          $template['IMG_SRC'] = $images[$attempts];
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
          $template['IMG_SRC'] = $images[$attempts];
          $template['BLANKS_WORD'] = $blank_spaces;
          $template['RESPONSE'] = 'Your letter was found in the word!';

          echo PHPWS_Template::process($template, 'hangman','game.tpl');
        }
      }
    }
  }
}

run_game($word);

?>
