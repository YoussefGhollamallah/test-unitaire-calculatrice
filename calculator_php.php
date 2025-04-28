<?php
// Calculator_PHP.php

require_once 'calculator.php';
session_start();

if (!isset($_SESSION['expression'])) $_SESSION['expression'] = '';
if (!isset($_SESSION['history']))    $_SESSION['history']    = [];
if (!isset($_SESSION['raw']))        $_SESSION['raw']        = '';

$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btn = $_POST['btn'];

    // Si on continue après un '=', réinitialiser
    if (strpos($_SESSION['expression'], '=') !== false
        && !in_array($btn, ['=', 'C', 'CE'])) {
        $_SESSION['expression'] = '';
        $_SESSION['raw']        = '';
    }

    if ($btn === 'C') {
        $_SESSION['expression'] = '';
        $_SESSION['raw']        = '';
    } elseif ($btn === 'CE') {
        $_SESSION['history'] = [];
    } elseif ($btn === '=') {
        $calculator = new Calculator();
        try {
            $result = $calculator->calculate($_SESSION['raw']);
            $entry  = $_SESSION['raw'] . ' = ' . $result;
            $_SESSION['expression'] = $entry;
            $_SESSION['raw']        = (string)$result;
            $_SESSION['history'][]  = $entry;
        } catch (Exception $e) {
            $entry  = $_SESSION['raw'] . ' = ' . $e->getMessage();
            $_SESSION['expression'] = $entry;
            $_SESSION['raw']        = '';
            $_SESSION['history'][]  = $entry;
        }
    } else {
        // Empêcher opérateur en début d’expression sans nombre
        if ($_SESSION['raw'] === '' && in_array($btn, ['+', '-', '*', '/'])) {
            $_SESSION['expression'] .= '0' . $btn;
            $_SESSION['raw']        .= '0' . $btn;
        } else {
            $_SESSION['expression'] .= $btn;
            $_SESSION['raw']        .= $btn;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Calculette Graphique PHP avec Historique</title>
    <style>
        body { font-family: Arial; display: flex; justify-content: center; margin-top: 30px; }
        .calculator { border: 1px solid #333; padding: 20px; border-radius: 10px; background: #f4f4f4; }
        .display { height: 40px; text-align: right; padding: 10px; font-size: 20px; background: #fff; border: 1px solid #ccc; margin-bottom: 10px; width: 220px; }
        .buttons form { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
        button { padding: 15px; font-size: 18px; cursor: pointer; }
        .history { margin-top: 20px; font-size: 14px; background: #fff; padding: 10px; border: 1px solid #ccc; height: 100px; overflow-y: auto; }
    </style>
</head>
<body>
    <div class="calculator">
        <div class="display"><?= htmlspecialchars($_SESSION['expression']) ?></div>
        <div class="buttons">
            <form method="post">
                <?php
                $buttons = ['7','8','9','/','4','5','6','*','1','2','3','-','0','.','C','+','(',')','=','CE'];
                foreach ($buttons as $b) {
                    echo '<button type="submit" name="btn" value="'.$b.'">'.$b.'</button>';
                }
                ?>
            </form>
        </div>
        <div class="history">
            <strong>Historique :</strong><br>
            <?php foreach (array_reverse($_SESSION['history']) as $line): ?>
                <?= htmlspecialchars($line) ?><br>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
    document.addEventListener('keydown', e => {
        const valid = ['0','1','2','3','4','5','6','7','8','9','.','+','-','*','/','(',')'];
        const form = document.querySelector('.buttons form');
        if (!form) return;
        let key = e.key;
        if (valid.includes(key) || key === 'Enter' || key === 'Escape') {
            const btn = document.createElement('input');
            btn.type  = 'hidden';
            btn.name  = 'btn';
            btn.value = key === 'Enter' ? '=' : (key === 'Escape' ? 'C' : key);
            form.appendChild(btn);
            form.submit();
        }
    });
    </script>
</body>
</html>
