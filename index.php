<?php
session_start();
const WIN_NUM = 78;
$numbers = range(1, 100, 1);
if (!isset($_SESSION['low'])) {
    $_SESSION['low'] = 0;
    $_SESSION['high'] = count($numbers) - 1;
    $_SESSION['mid'] = (int)(($_SESSION['low'] + $_SESSION['high']) / 2);
    $_SESSION['result'] = $numbers[$_SESSION['mid']];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['play-again'])) {
        session_destroy();
        header('Location: /');
        exit;
    } elseif (isset($_POST['check'])) {
        switch ($_POST['check']) {
            case 'higher':
                if ($_SESSION['high'] <= 1 || $_SESSION['high'] < $_SESSION['low']) {
                    $_SESSION['low'] = 0;
                    $_SESSION['high'] = count($numbers) - 1;
                } else {
                    $_SESSION['high'] = (int) $_SESSION['mid'] - 1;
                }
                break;
            case 'lower':
                if ($_SESSION['low'] >= count($numbers) - 1 || $_SESSION['high'] < $_SESSION['low']) {
                    $_SESSION['low'] = 0;
                    $_SESSION['high'] = count($numbers) - 1;
                } else {
                    $_SESSION['low'] = (int) $_SESSION['mid'] + 1;
                }
                break;
            case 'correct':
                $_SESSION['result'] = $numbers[$_SESSION['mid']] . ' is the correct number';
        }
        $_SESSION['mid'] = (int) (($_SESSION['low'] + $_SESSION['high']) / 2);
        $_SESSION['result'] = $numbers[$_SESSION['mid']];
        // var_dump($_SESSION);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <select name="check" id="check">
            <option value="higher">Higher</option>
            <option value="lower" selected>Lower</option>
            <option value="correct">Correct</option>
        </select>
        <input type="submit" value="Submit">
    </form>
    <?php if (isset($_SESSION['result'])) : ?>
        <br>
        <span><?= $_SESSION['result'] ?></span>
    <?php endif ?>
    <br>
    <br>
    <form action="" method="POST">
        <input type="submit" name="play-again" value="Play Again">
    </form>
    <script>
        document.getElementById('[name="play-again"]').addEventListener('click', (e) => {
            sessionStorage.clear();
            window.location.reload();
        })
    </script>
</body>

</html>
