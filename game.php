<?php
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hangman - Playing!</title>
    <meta name="description" content="Play hangman">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <?php
        // You can replace this with any random words of choice, in case you want to go for a theme etc.
        $randomWords = array("cruelty", "essential", "allowance", "appendix", "hostage", "negative", "accident", "expansion", "mixture", "infrastructure", "nonremittal", "collect", "registration", "rubbish", "composer", "article", "paradox", "dramatic", "stadium", "forestry", "feminist", "auditor", "company", "welcome", "recording", "trustee", "machinery", "concession", "staircase", "communist", "factory", "evolution", "proclaim", "nervous", "standard", "minimize", "explain");
        $word = "undefined"; // Shouldn't ever be undefined. 
        $wordHint = "";
    
    if (isset($_POST['randomWord'])) {
        $mtr = mt_rand(0, count($randomWords) - 1);
        $woord = $randomWords[$mtr];
        $_SESSION['word'] = strtoupper(trim($woord));
    } else if (!isset($_SESSION['word'])) {
        if (!isset($_POST['chosenWord'])) {
            session_destroy();
            header('Location: index.php');
            exit();
        }
        $woord = $_POST['chosenWord'];
        $_SESSION['word'] = preg_replace('/[^a-z\- ]/i', '', strtoupper(trim($woord)));      
    }
    
    if (!isset($_SESSION['wrongLetters'])) {
        $_SESSION['wrongLetters'] = array();
    }

    if (!isset($_SESSION['rightLetters'])) {
        $_SESSION['rightLetters'] = array("-", " ");
    }
    
    if (isset($_POST['playerGuess'])) {
        if (stripos($_SESSION['word'], $_POST['playerGuess'][0]) === false) {
            array_push($_SESSION['wrongLetters'], $_POST['playerGuess'][0]); 
        } else {
            array_push($_SESSION['rightLetters'], $_POST['playerGuess'][0]); 
        }
    }

    for ($i = 0; $i < strlen($_SESSION['word']); $i++) {
        $wordHint .= in_array(substr($_SESSION['word'], $i, 1), $_SESSION['rightLetters']) ? substr($_SESSION['word'], $i, 1) : " _ ";
    }
    ?>
    <h1>Hangman</h1>
    <?php 
    $chances = 7 - count($_SESSION['wrongLetters']);
    echo '<p> The word is: ' . $wordHint .  '</p>';
    echo '<p id="chances"> You have ' . strval($chances) .  ' chances left. </p>'; 
    echo '<img src="hang' . count($_SESSION['wrongLetters']) . '.png" \>';
    ?>

    <?php 
if ($chances <= 0) {
    echo '<h1>YOU DIED!</h1>';
    echo 'The word was: ' . $_SESSION['word'];
    session_destroy();
}

if ($_SESSION['word'] == $wordHint) {
    echo '<h1>You did it!</h1>';
    echo 'You guessed the word correctly.';
    ?> <script>
    var count = 200;
    var defaults = {
        origin: {
            y: 0.7
        }
    };

    function fire(particleRatio, opts) {
        confetti(Object.assign({}, defaults, opts, {
            particleCount: Math.floor(count * particleRatio)
        }));
    }

    fire(0.25, {
        spread: 26,
        startVelocity: 55,
    });
    fire(0.2, {
        spread: 60,
    });
    fire(0.35, {
        spread: 100,
        decay: 0.91,
        scalar: 0.8
    });
    fire(0.1, {
        spread: 120,
        startVelocity: 25,
        decay: 0.92,
        scalar: 1.2
    });
    fire(0.1, {
        spread: 120,
        startVelocity: 45,
    });
    </script> <?php
    session_destroy();
}
?>

    <form action="destroy.php" method="post">
        <input type="submit" value="Reset the game and return to main menu." />
    </form>
    <form method="POST">
        <?php
        echo '<p> Letters left: </p>';

            $alphabet = range("A", "Z");
        foreach ($alphabet as $letter) {
            if (!in_array($letter, $_SESSION['rightLetters']) && !in_array($letter, $_SESSION['wrongLetters'])) {
                ?>
        <input name="playerGuess[]" id="<?php echo $letter?>" type="submit" value="<?php echo $letter?>"
            class="letterbutton" />
        <?php
            }
        }
        ?>
    </form>



</body>

</html>