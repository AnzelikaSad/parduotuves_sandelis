<?php

session_start();

$database = mysqli_connect('localhost', 'root', '', 'parduotuves_sandelis');

if (!$database) {
    die("Connection failed: " . mysqli_connect_error());
}

$action = $_REQUEST['action'] ?? null;

if ($action === 'registracija') {

    if (isset($_POST['pastas'])) {
        $pastas = $_POST['pastas'];
        $slaptazodis = $_POST['slaptazodis'];
        $vardas = $_POST['vardas'];
        $pareigybe = $_POST['pareigybe'];

        $sql = "insert into darbuotojai (pareigybe, vardas, pastas, slaptazodis) value ('$pareigybe','$vardas', '$pastas', '$slaptazodis' )";

        $result = mysqli_query($database, $sql);
    }

}


if ($action === 'prisijungimas') {

    if (isset($_POST['pastas'])) {
        $pastas = $_POST['pastas'];
        $slaptazodis = $_POST['slaptazodis'];

        $errors = [];

        $prisijungimas = mysqli_query($database, 'select * from darbuotojai where pastas = "' . $pastas . '" and slaptazodis = "' . $slaptazodis . '"');
        $prisijungimas = mysqli_fetch_row($prisijungimas);


        if ($prisijungimas == null) {
            $errors[] = 'Blogi prisijungimo duomenys';
        } else {
            echo 'Pavyko prisijungti';
        }

        if (empty($errors)) {
            $_SESSION['pastas'] = $pastas;
            header('Location: index.php');
        }

    }

}


?>

<!DOCTYPE html>
<html>
<body>


<form action="index.php?action=registracija" method="post">
    <fieLdset>
        <legend><b>Registracija:</b></legend>
        Vardas:<input type="text" name="vardas"><br><br>
        Pareigybe:<input type="text" name="pareigybe"><br><br>
        Pastas:<input type="email" name="pastas"><br><br>
        Slaptazodis:<input type="password" name="slaptazodis"><br><br>
        <input type="submit" value="Issaugoti">

    </fieLdset>
</form>


<form action="index.php?action=prisijungimas" method="post">
    <fieLdset>
        <legend><b>Prisijungimas:</b></legend>
        Pastas:<input type="email" name="pastas" value="<?php echo $_GET['pastas'] ?? null ?>"><br><br>
        Slaptazodis:<input type="password" name="slaptazodis"
                           value="<?php echo $_GET['slaptazodis'] ?? null ?>"><br><br>
        <input type="submit" value="Prisijungti">
    </fieLdset>
    <ul>
        <?php
        if (isset($errors)) {
            foreach ($errors as $error) {
                ?>
                <li>
                    <?php echo $error ?>
                </li>
            <?php }
        } ?>
    </ul>
</form>


</body>
</html>