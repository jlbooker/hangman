<?php
class Hangman{
    private $word;
    private $wrongAttempts;
    private $usedLetters = [];
    private $greeting;
    private $blanksShow;
    private $linksList;
    private $response;
    private $place_holder = [];
    const PLACEHOLDER = "_";

    //constructor
    function __construct($word, $wrongAttempts, $usedLetters, $place_holder){

        $this->word = $word;
        $this->wrongAttempts = $wrongAttempts;
        $this->usedLetters = $usedLetters;
        $this->place_holder = $place_holder;

    }

    function initital(){
        $this->greeting = 'Welcome to Hangman';
        $this->blanksShow = implode(" ", $this->blanks());
        $this->linksList = $this->alphabetList();
        $this->response = 'Choose a letter from the list below...';
    }

    function run_game(){
        $this->usedLetters = $_REQUEST['letter'];
        //$this->wrongAttempts += 1;

        $this->greeting = 'Welcome to Hangman';
        $this->linksList = $this->alphabetList();
        $this->response = 'Choose a letter from the list below...';
        $this->blanksShow = implode(" ", $this->checkWord());
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
        for($i = 0; $i < strlen($this->word); $i++){
            $this->place_holder[] = self::PLACEHOLDER;
        }
        return $this->place_holder;
    }

    //function to compare letter to word and print respective blanks
    function checkWord(){

        $len = strlen($this->word);
        $hold = $_REQUEST['letter'];
        $pos = stripos($this->word, $hold);

        while($pos < ($len - 1) && $pos !== false){
            $this->place_holder[$pos] = $hold;
            $pos = stripos($this->word, $hold, $pos + 1);
        }

        if($pos == ($len - 1)){
            $this->place_holder[$pos] = $hold;
        }

        //var_dump($this->place_holder);
        return $this->place_holder;
    }

    //function to return placeholder
    function getPlaces(){
        return $this->place_holder;
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
        $template['GREETING'] = $this->greeting;
        $template['RESPONSE'] = $this->response;
        $template['IMG_SRC'] =
        "http://localhost/phpwebsite/mod/hangman/img/hang$this->wrongAttempts.gif";
        $template['BLANKS_WORD'] = $this->blanksShow;
        $template['ALPHABET'] = $this->linksList;

        echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }
}
