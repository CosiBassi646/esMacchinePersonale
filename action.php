<!doctype html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>action.php</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="bg-dark text-white">
    <h1 class="text-center">Marche Pertinenti Alla Vostra Ricerca</h1>
    <div class="w-50 mx-auto my-auto text-center">
        <br>
        <table class="table table-bordered table-rounded">
            <tr>
                <th class="text-danger">MARCA:</th>
                <th class="text-danger">NAZIONE:</th>
                <th class="text-danger">ANNO DI FONDAZIONE:</th>
                <th class="text-danger">MAGGIORI INFORMAZIONI:</th>
            </tr>
            <?php
                (include "./connessione.php");
                $nazioneM = $_GET['nazioneM'];
                $vMax = $_GET['vMax'];
                if($nazioneM == null && $vMax == null){
                    header("Location:./index.php");
                    exit(); //l'utente non ha selezionato niente
                }else{
                    if($nazioneM != null && $vMax == null){ //cerca solo per nazione
                        $query = mysqli_query($conn, "SELECT marchi.nome, marchi.nazione, marchi.anno_fondazione, marchi.sito_web from marchi
                        where marchi.nazione = '$nazioneM'");
                    }else
                    if($nazioneM == null && $vMax != null){ //cerca solo per velocità
                        $query = mysqli_query($conn, "SELECT marchi.nome, marchi.nazione, marchi.anno_fondazione, marchi.sito_web from marchi
                        join modelli on modelli.id_marchio = marchi.id_marchio
                        where modelli.velocita_max >= $vMax");
                    }else
                    if($nazioneM != null && $vMax != null){ //cerca per nazione e velocità
                        $query = mysqli_query($conn, "SELECT marchi.nome, marchi.nazione, marchi.anno_fondazione, marchi.sito_web from marchi
                        join modelli on modelli.id_marchio = marchi.id_marchio
                        where marchi.nazione = '$nazioneM'
                        and modelli.velocita_max >= $vMax");
                    }
                }
                //popolamento della tabella di risultati
                while($row = mysqli_fetch_assoc($query)){
                    echo '<tr>';
                    echo '<td>' . $row['nome'] . '</td>';
                    echo '<td>' . $row['nazione'] . '</td>';
                    echo '<td>' . $row['anno_fondazione'] . '</td>';
                    echo '<td><a class="link-opacity-100-hover" href="'. $row['sito_web'] .'">' . $row['sito_web'] . '</a></td>';
                    echo '</tr>';
                }
            ?>
        </table>
        <br>
        <button type="button" class="btn btn-success"><a class="link-light link-opacity-100-hover" href="./index.php">Torna Alla Home</a></button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>