<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hangman</title>
    <meta name="description" content="Play hangman">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <h1>Welcome to Hangman</h1>
    <img id="hangmanLogo" src="hangman.png" />

    <form action="./game.php" method="POST">
        <input type="submit" name="randomWord" value="Play with a random word.">
    </form>
    <p> OR </p>
    <form action="./chooseWord.php" method="POST">
        <input type="submit" name="chooseWord" value="Choose your own word.">
    </form>
</body>

</html>
