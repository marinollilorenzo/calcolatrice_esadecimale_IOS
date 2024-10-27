<?php
    session_start();
    function checkDEC(){
        if($_SESSION['mode'] == "DEC")
            return true;
        else
            return false;
    }
    function getMode(){
        if($_SESSION['mode'] == "DEC")
            return "HEX";
        else
            return "DEC";
    }
    function checkAC(){
        if($_SESSION['out'] == "" || $_SESSION['risultato'] == true)
            $_SESSION['C'] = "AC";
        else
            $_SESSION['C'] = "<";
        }
    if (is_null($_SESSION['risultato'])) {
        $_SESSION['risultato'] = false;
    }
    if (is_null($_SESSION['mode'])) {
        $_SESSION['mode'] = "DEC";
    }
    if (is_null($_SESSION['out'])) {
        $_SESSION['out'] = "";
    }
    if(isset($_POST['b'])) {
        if($_SESSION['risultato']){
            $_SESSION['out'] = "";
            $_SESSION['risultato'] = false; 
        }
        $_SESSION['out'] = $_SESSION['out'].$_POST['b'];
    }
    if(isset($_POST['bcanc'])){
        if($_SESSION['C'] == "AC")
            $_SESSION['out'] = "";
        else{
            $str = $_SESSION['out'];
            $_SESSION['out'] = substr($str, 0, -1);
        }
    }
    if(isset($_POST['mode'])){
        $_SESSION['out'] = "";
        if($_POST['mode'] == "HEX"){
            $_SESSION['mode'] = "HEX";
        }else{
            $_SESSION['mode'] = "DEC";
        }
    }
    if(isset($_POST['bop'])){
        switch($_POST['bop']){
            case "piu":
                if(!checkDEC())
                    $_SESSION['primo'] = hexdec($_SESSION['out']);
                else
                    $_SESSION['primo'] = $_SESSION['out'];
                $_SESSION['out'] = "";
                $_SESSION['operatore'] = "+";
            break;
            case "meno":
                if(!checkDEC())
                    $_SESSION['primo'] = hexdec($_SESSION['out']);
                else
                    $_SESSION['primo'] = $_SESSION['out'];
                $_SESSION['out'] = "";
                $_SESSION['operatore'] = "-";
            break;
            case "div":
                if(!checkDEC())
                    $_SESSION['primo'] = hexdec($_SESSION['out']);
                else
                    $_SESSION['primo'] = $_SESSION['out']; 
                $_SESSION['out'] = "";
                $_SESSION['operatore'] = "/";
            break;
            case "mol":
                if(!checkDEC())
                    $_SESSION['primo'] = hexdec($_SESSION['out']);
                else
                    $_SESSION['primo'] = $_SESSION['out'];
                $_SESSION['out'] = "";
                $_SESSION['operatore'] = "*";
            break;
            case "ugual":
                if(!checkDEC())
                    $_SESSION['secondo'] = hexdec($_SESSION['out']);
                else
                    $_SESSION['secondo'] = $_SESSION['out'];                                
                switch($_SESSION['operatore']){
                    case "+":
                        $final = (int)$_SESSION['primo'] + (int)$_SESSION['secondo'];
                        break;
                    case "-":
                        $final = (int)$_SESSION['primo'] - (int)$_SESSION['secondo'];
                        break;
                    case "*":
                        $final = (int)$_SESSION['primo'] * (int)$_SESSION['secondo'];
                        break;
                    case "/":
                        if($_SESSION['secondo'] == 0)
                            $final = "IMPOSSIBILE!";
                        else
                            $final = (int)$_SESSION['primo'] / (int)$_SESSION['secondo'];
                        break;
                    case "null":
                        $final = 0;
                        break;
                }
                if(checkDEC() || $final == "NON PUOI DIVIDERE PER 0!"){
                    $_SESSION['out'] = $final;
                } else {
                    $_SESSION['out'] = dechex((int)$final);
                }
                $_SESSION['risultato'] = true;
                break;
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolatrice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <form action="" method="POST" class="calcolatrice">

            <div class="textView">
                <input type="text" value="<?php echo $_SESSION['out']; ?>"  class="text1" disabled>
            </div>
            <div class="div2">
                <div class="calc">
                    <button type="submit" name="b" value="1" class="buttonCalc">1</button>
                    <button type="submit" name="b" value="2" class="buttonCalc">2</button>
                    <button type="submit" name="b" value="3" class="buttonCalc">3</button>
                    <button type="submit" name="b" value="4" class="buttonCalc">4</button>
                    <button type="submit" name="b" value="5" class="buttonCalc">5</button>
                    <button type="submit" name="b" value="6" class="buttonCalc">6</button>
                    <button type="submit" name="b" value="7" class="buttonCalc">7</button>
                    <button type="submit" name="b" value="8" class="buttonCalc">8</button>
                    <button type="submit" name="b" value="9" class="buttonCalc">9</button>
                    <button type="submit" name="b" value="0" class="buttonCalc">0</button>
                    <button type="submit" name="b" value="A" class="buttonCalc" <?php if ($_SESSION['mode'] == "DEC") { echo 'disabled="disabled"';} ?> >A</button>
                    <button type="submit" name="b" value="B" class="buttonCalc" <?php if ($_SESSION['mode'] == "DEC") { echo 'disabled="disabled"';} ?> >B</button>
                    <button type="submit" name="b" value="C" class="buttonCalc" <?php if ($_SESSION['mode'] == "DEC") { echo 'disabled="disabled"';} ?> >C</button>
                    <button type="submit" name="b" value="D" class="buttonCalc" <?php if ($_SESSION['mode'] == "DEC") { echo 'disabled="disabled"';} ?> >D</button>
                    <button type="submit" name="b" value="E" class="buttonCalc" <?php if ($_SESSION['mode'] == "DEC") { echo 'disabled="disabled"';} ?> >E</button>
                    <button type="submit" name="bcanc" id="buttonC" value="canc" class="buttonCalc"><?php checkAC(); echo $_SESSION['C']?></button>
                    <button type="submit" name="b" value="F" class="buttonCalc" <?php if ($_SESSION['mode'] == "DEC") { echo 'disabled="disabled"';} ?> >F</button>
                    <button type="submit" name="mode" id="buttonC" class="buttonCalc" value ="<?php echo getMode();?>"><?php echo getMode();?></button>
                </div>
                <div class="operatori">
                    <button type="submit" name="bop" value="piu" class="buttonOper">+</button>
                    <button type="submit" name="bop" value="meno" class="buttonOper">-</button>
                    <button type="submit" name="bop" value="div" class="buttonOper">/</button>
                    <button type="submit" name="bop" value="mol" class="buttonOper">*</button>
                    <button type="submit" name="bop" value="ugual" class="buttonOper">=</button>
                </div>
            </div>
            <div class="canc">

            </div>
        </form>
        <div class="textMessage">
                <input type="text" value="MODALITA' CORRENTE: <?php echo $_SESSION['mode']; ?>" disabled>
        </div>
</body>
</html>