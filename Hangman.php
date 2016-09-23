<?php
class Hangman{
    private $word;
    private $wrongAttempts;
    private $usedLetters;
    const PLACEHOLDER = "_ ";

    //constructor
    function __construct($word, $wrongAttempts, Array $usedLetters){

        $this->word = $word;
        $this->wrongAttempts = $wrongAttempts;
        $this->usedLetters = $usedLetters;
    }

    function run_game(){


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
    function blanks(){
        $place_holder = "";
        for($i = 0; $i <= strlen($_SESSION['word']); $i++){
            $place_holder .= self::PLACEHOLDER;
        }
        return $place_holder;
    }

    //function to return word
    function getWord(){
        return $this->word;
    }

    //function to return wrong attempts
    function getWrongAttempts(){
        return $this->wrongAttempts;
    }

    //function to return used letterLinks
    function getUsedLetters(){
        return $this->usedLetters;
    }

    //render function
    function render(){
        $template['FORM_CONTENT'] = 'Pick a letter: ';
        $template['GREETING'] = 'Welcome to Hangman';
        $template['IMG_SRC'] =
        "http://localhost/phpwebsite/mod/hangman/img/hang{$_SESSION['attempts']}.gif";
        $template['BLANKS_WORD'] = $this->blanks();
        $template['ALPHABET'] = $this->alphabetList();

        echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }
}
