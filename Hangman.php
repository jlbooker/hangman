<?php
class Hangman{
    private $word;
    private $wrongAttempts;
    private $letterLinks = [];

    //running game temlate variables
    private $greeting;
    private $blanksShow;
    private $linksList;
    private $response;
    private $usedList;
    private $used_header;

    //new game template variables
    private $link;
    private $pt1;
    private $pt2;

    //arrays
    private $usedLetters = [];
    private $place_holder = [];

    //constants
    const PLACEHOLDER = "_";

    //constructor
    function __construct($word, $wrongAttempts, $usedLetters, $place_holder, $letterLinks){

        $this->word = $word;
        $this->wrongAttempts = $wrongAttempts;
        $this->usedLetters = $usedLetters;
        $this->place_holder = $place_holder;
        $this->letterLinks = $letterLinks;

    }

    //initial rendering info when starting a new game
    function initital(){
        $this->greeting = 'Welcome to Hangman';
        $this->blanksShow = implode(" ", $this->blanks());
        $this->linksList = implode(" ", $this->alphabetList());
        $this->response = 'Choose a letter from the list below...';
    }

    //actually runs the game
    function run_game(){
        $this->pt1 = 'Wanna start a new game? Click here! >>> ';
        $this->link = "LET'S DO THIS";
        $this->pt2 = ' <<<';

        $letter = $_REQUEST['letter'];
        if(strcasecmp(implode("", $this->checkWord()), $this->word) !== 0 && $this->wrongAttempts === 6){
            $this->greeting = 'You lost the game!';
            $this->response = "The hidden word was: $this->word";
            $this->used_header = 'Here are the letters you tried: ';
            $this->usedLetters[] = $letter;
            $this->usedList = implode(" ", $this->usedLetters);
            //newGame
            $this->pt1 = 'Wanna play again? Click here! >>> ';
            $this->link = "LET'S DO THIS";
            $this->pt2 = ' <<<';
            $this->wrongAttempts;
        }

        else if(stripos($this->word, $letter) !== false && $this->wrongAttempts < 6
        && strcasecmp(implode("", $this->checkWord()), $this->word) !== 0){
            if(in_array($letter, $this->usedLetters)){
                $this->greeting = 'You have already chose that letter!';
                $this->linksList = implode(" ", $this->destroyLink());
                $this->response = 'Choose another letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedList = implode(" ", $this->usedLetters);

            }
            else{
                $this->greeting = 'The letter you chose was found in the word!';
                $this->linksList = implode(" ", $this->destroyLink());
                $this->response = 'Choose another letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedLetters[] = $letter;
                $this->usedList = implode(" ", $this->usedLetters);

            }
        }

        else if($this->wrongAttempts < 6 && strcasecmp(implode("", $this->checkWord()), $this->word) !== 0){
            if(in_array($letter, $this->usedLetters)){
                $this->greeting = 'You have already chose that letter!';
                $this->linksList = implode(" ", $this->destroyLink());
                $this->response = 'Choose another letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedList = implode(" ", $this->usedLetters);

            }
            else {
                $this->greeting = 'The letter you chose was not found. Try again!';
                $this->linksList = implode(" ", $this->destroyLink());
                $this->response = 'Choose a letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedLetters[] = $letter;
                $this->usedList = implode(" ", $this->usedLetters);
                $this->wrongAttempts += 1;

                if(strcasecmp(implode("", $this->checkWord()), $this->word) !== 0 && $this->wrongAttempts === 6){
                    $this->greeting = 'You lost the game!';
                    $this->response = "The hidden word was: $this->word";
                    $this->used_header = 'Here are the letters you tried: ';
                    $this->usedLetters[] = $letter;
                    $this->usedList = implode(" ", $this->usedLetters);
                    //newGame
                    $this->pt1 = 'Wanna play again? Click here! >>> ';
                    $this->link = "LET'S DO THIS";
                    $this->pt2 = ' <<<';
                    $this->wrongAttempts;
                }
            }
        }

        else{
            $this->greeting = 'You won!';
            $this->response = 'The hidden word is shown above.';
            $this->blanksShow = implode(" ", $this->checkWord());
            $this->used_header = "Here are the letters you tried: ";
            $this->usedLetters[] = $letter;
            $this->usedList = implode(" ", $this->usedLetters);
            //newGame
            $this->pt1 = 'Wanna play again? Click here! >>> ';
            $this->link = "LET'S DO THIS";
            $this->pt2 = ' <<<';
        }
    }

    //fxn to create alphabet links
    function alphabetList(){
        for ($i = 65; $i <= 90; $i++) {
            $this->letterLinks[] = '<a href="/phpwebsite/index.php?module=hangman&letter='.chr($i).'">'.chr($i).'</a>';
        }
        $_SESSION['letter'] = $this->letterLinks;
        return $this->letterLinks;
    }

    //fxn for display of INITIAL placeholder
    function blanks(){
        for($i = 0; $i < strlen($this->word); $i++){
            $this->place_holder[] = self::PLACEHOLDER;
        }
        return $this->place_holder;
    }

    //function to compare letter to word and print respective placeholder
    function checkWord(){

        $len = strlen($this->word);
        $letter = $_REQUEST['letter'];
        $pos = stripos($this->word, $letter);

        while($pos < ($len - 1) && $pos !== false){
            $this->place_holder[$pos] = $letter;
            $pos = stripos($this->word, $letter, $pos + 1);
        }

        if($pos == ($len - 1)){
            $this->place_holder[$pos] = $letter;
        }

        return $this->place_holder;
    }

    //deleting links as they're chosen and recreate alphabet links list
    function destroyLink(){
        $key = array_search('<a href="/phpwebsite/index.php?module=hangman&letter='.$_REQUEST['letter'].'">'.$_REQUEST['letter'].'</a>',
        $this->letterLinks);
        $this->letterLinks[$key] = null;
        $_SESSION['letter'] = $this->letterLinks;
        return $this->letterLinks;
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

    //render the game
    function render(){
        $template['GREETING'] = $this->greeting;
        $template['RESPONSE'] = $this->response;
        $template['IMG_SRC'] =
        "http://localhost/phpwebsite/mod/hangman/img/hang$this->wrongAttempts.gif";
        $template['BLANKS_WORD'] = $this->blanksShow;
        $template['ALPHABET'] = $this->linksList;
        $template['USED'] = $this->usedList;
        $template['USED_HEADER'] = $this->used_header;
        $template['LINK'] = $this->link;
        $template['PT1'] = $this->pt1;
        $template['PT2'] = $this->pt2;

        echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }
}
