<?php
  class Hangman{
    private $_SESSION;
    // private $_SESSION['letterLinks'];
    // private $_SESSION['attempts'];

    //constructor
    function __construct(){
      $word_list = file(PHPWS_SOURCE_DIR . 'mod/hangman/hangwords.txt');
      $word = $word_list[array_rand($word_list, 1)];
      $word = strtolower($word);
      $word = preg_replace('/[^a-z]/', '', $word);

      $_SESSION['word'] = $word;
      $_SESSION['attempts'] = 0;
      define("PLACEHOLDER", "_ ");

      $template['FORM_CONTENT'] = 'Pick a letter: ';
      $template['GREETING'] = 'Welcome to Hangman';
      $template['IMG_SRC'] =
        "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempt']}.gif";
      $template['BLANKS_WORD'] = $this->blanks($_SESSION['word']);
      $template['ALPHABET'] = $this->alphabetList();

      echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }

    function run_game(){

        while($_SESSION['attempts'] > 0 && $_SESSION['attempts'] < 7){
          $pos = strpos($word, $_SESSION['letter']);

          if($pos === false){
              $_SESSION['attempts'] = $_SESSION['attempts'] + 1;

            $template['FORM CONTENT'] = 'Pick another letter: ';
            $template['RESPONSE'] = 'Continue your game.
              You have ' . (6 - $_SESSION['attempts']) . ' attempts left.';
            $template['IMG_SRC'] =
              "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempts']}.gif";
            $template['BLANKS_WORD'] = $blank_spaces;
            $template['GREETING'] = 'Your letter was not part of the word.';

            echo PHPWS_Template::process($template, 'hangman','game.tpl');
          }else{

            for($i = 0; $i <= strlen($word); $i++){
              if($word[$i] == $_SESSION['letter']){
                $blank_spaces[$i] = $_SESSION['letter'];
              }
            }

            $template['FORM CONTENT'] = 'Pick another letter: ';
            $template['GREETING'] = 'Continue your game.
              You have ' . (6 - $_SESSION['attempts']) . ' attempts left.';
            $template['IMG_SRC'] =
              "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempts']}.gif";
            $template['BLANKS_WORD'] = $blank_spaces;
            $template['RESPONSE'] = 'Your letter was found in the word!';

            echo PHPWS_Template::process($template, 'hangman','game.tpl');
          }
        }

        // if($pos = strpos(PLACEHOLDER, '_ ')){
        //   $template['FORM CONTENT'] = 'You lost the game!';
        //   $template['GREETING'] = 'Better luck next time.';
        //   $template['IMG_SRC'] =
        //     "http://localhost/phpwebsite/mod/hangman/img/hang6.gif";
        //   $template['BLANKS_WORD'] = word_ses;
        //   $template['RESPONSE'] = 'Click here to start a new game:
        //     <a href="/phpwebsite/index.php?module=hangman">New Game</a>';
        //
        //   echo PHPWS_Template::process($template, 'hangman','game.tpl');
        // }
      }


    //fxn to display alphabet links
    function alphabetList(){
      for ($i = 65; $i <= 90; $i++) {
        $letterLinks[] = '<a href="/phpwebsite/index.php?module=hangman&letter='.chr($i).'" class="myclass">'.chr($i).'</a>';
      }
      $_SESSION['letter'] = $letterLinks;
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
