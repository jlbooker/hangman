<?php
class Hangman{
    private $word;
    private $wrongAttempts;

    private $usedLetters = [];
    private $usedList;
    private $used_header;

    private $greeting;
    private $blanksShow;
    private $linksList;
    private $response;

    //new game variables
    private $link;
    private $pt1;
    private $pt2;

    private $place_holder = [];
    const PLACEHOLDER = "_";

    //constructor
    function __construct($word, $wrongAttempts, $usedLetters, $place_holder){

        $this->word = $word;
        $this->wrongAttempts = $wrongAttempts;
        $this->usedLetters = $usedLetters;
        $this->place_holder = $place_holder;

    }

    //initial rendering info
    function initital(){
        $this->greeting = 'Welcome to Hangman';
        $this->blanksShow = implode(" ", $this->blanks());
        $this->linksList = $this->alphabetList();
        $this->response = 'Choose a letter from the list below...';
    }

    //to run the game
    function run_game(){
        $hold = $_REQUEST['letter'];


        //$this->wrongAttempts += 1;
        if(strcasecmp(implode("", $this->checkWord()), $this->word) !== 0 && $this->wrongAttempts === 6){
            $this->greeting = 'You lost the game!';
            //$this->linksList = $this->alphabetList();
            $this->response = "The hidden word was: $this->word";
            // $this->blanksShow = implode("", $this->checkWord());
            $this->used_header = 'Here are the letters you tried: ';
            $this->usedLetters[] = $hold;
            $this->usedList = implode(" ", $this->usedLetters);
            //newGame
            $this->pt1 = 'Wanna play again? Click here! >>> ';
            $this->link = "LET'S DO THIS";
            $this->pt2 = ' <<<';
            $this->wrongAttempts;
        }

        else if(stripos($this->word, $hold) !== false && $this->wrongAttempts < 6
        && strcasecmp(implode("", $this->checkWord()), $this->word) !== 0){
            if(in_array($hold, $this->usedLetters)){
                $this->greeting = 'You have already chose that letter!';
                $this->linksList = $this->alphabetList();
                $this->response = 'Choose another letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedList = implode(" ", $this->usedLetters);
            }
            else{
                $this->greeting = 'The letter you chose was found in the word!';
                $this->linksList = $this->alphabetList();
                $this->response = 'Choose another letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedLetters[] = $hold;

                $this->usedList = implode(" ", $this->usedLetters);

            }
        }

        else if($this->wrongAttempts < 6 && strcasecmp(implode("", $this->checkWord()), $this->word) !== 0){
            if(in_array($hold, $this->usedLetters)){
                $this->greeting = 'You have already chose that letter!';
                $this->linksList = $this->alphabetList();
                $this->response = 'Choose another letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedList = implode(" ", $this->usedLetters);
            }
            else {
                $this->greeting = 'The letter you chose was not found. Try again!';
                $this->linksList = $this->alphabetList();
                $this->response = 'Choose a letter from the list below...';
                $this->blanksShow = implode(" ", $this->checkWord());
                $this->used_header = 'Here are the letters you have tried so far: ';
                $this->usedLetters[] = $hold;

                $this->usedList = implode(" ", $this->usedLetters);

                $this->wrongAttempts += 1;
            }
        }

        else{
            $this->greeting = 'You won!';
            //$this->linksList = $this->alphabetList();
            $this->response = 'The hidden word is shown above.';
            $this->blanksShow = implode(" ", $this->checkWord());
            $this->used_header = "Here are the letters you tried: ";
            $this->usedLetters[] = $hold;

            $this->usedList = implode(" ", $this->usedLetters);
            //newGame
            $this->pt1 = 'Wanna play again? Click here! >>> ';
            $this->link = "LET'S DO THIS";
            $this->pt2 = ' <<<';
        }

        // var_dump($hold);
        // var_dump($this->wrongAttempts);
        // var_dump(in_array($hold, $this->usedLetters));
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
        $template['USED'] = $this->usedList;
        $template['USED_HEADER'] = $this->used_header;
        $template['LINK'] = $this->link;
        $template['PT1'] = $this->pt1;
        $template['PT2'] = $this->pt2;

        echo PHPWS_Template::process($template, 'hangman','game.tpl');
    }
}
