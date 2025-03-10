<?php
    session_start();
    if(isset($_SESSION['cronologiaModelli'])){
      //non fare nulla se è impostato correttamente
    }else{
      $_SESSION['cronologiaModelli'] = array();
    }
    if(isset($_SESSION['ModelloAttuale'])){
      //non fare nulla se è impostato correttamente
    }else{
      $_SESSION['ModelloAttuale'] = "";
    }
?>

<!doctype html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="bg-dark text-white">
    <h1 class="text-center">Colori Disponibili Per La Vettura selezionata</h1>
    <div class="w-50 mx-auto my-auto">
        <div class="w-50 mx-auto my-auto">
            <div class="container text-center">
                <?php
                    (include "./connessione.php");
                    $modelloScelto = $_GET['modelloScelto']; //modello scelto dall'utente nella schermata home
                    $query = mysqli_query($conn,"select colori_disponibili.codice_esadecimale, colori_disponibili.nome_colore from colori_disponibili
                    join modelli on modelli.id_modello = colori_disponibili.id_modello
                    and modelli.nome = '$modelloScelto'");
                    while($row = mysqli_fetch_assoc($query)){
                        echo '<div class="row border-bottom">';
                            echo'<div class="col">';
                                echo '<h4 class="mt-4">'. $row['nome_colore'] .'</h4>';
                            echo '</div>';
                            echo '<div class="col mb-1">';
                                //div con i colori
                                echo '<br>';
                                echo '<div class="rounded-4" style="background-color: ' . $row['codice_esadecimale'] . ';">';
                                echo '<br>';
                                echo '<img scr="./images/nothing.png">';
                                echo '<br>';
                                echo '</div>'; //fine div con i colori
                            echo '</div>';
                        echo '</div>';
                    }
                    
                ?>
            </div>
        </div>
        <br>
    </div>
    <div class="text-center mt-3">
        <button type="button" class="btn btn-success"><a class="link-light link-opacity-100-hover" href="./index.php">Torna Alla Home</a></button>
    </div>
    <?php
        // Creazione della cronologia dei modelli
        $_SESSION['ModelloAttuale'] = $modelloScelto;

        // Verifica se la cronologia esiste già nella sessione, altrimenti inizializzala come array vuoto
        if (!isset($_SESSION['cronologiaModelli'])) {
            $_SESSION['cronologiaModelli'] = [];
        }

        $cronologiaTMP = $_SESSION['cronologiaModelli'];

        for($i = 0; $i < count($cronologiaTMP); $i++) {
            // Controllo se l'auto è già presente in cronologia
            if ($cronologiaTMP[$i] == $modelloScelto) {
                // Rimuovi l'elemento dalla cronologia
                array_splice($cronologiaTMP, $i, 1);
                break;
            }
        }
        array_push($cronologiaTMP, $modelloScelto);
        $_SESSION['cronologiaModelli'] = $cronologiaTMP;
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>