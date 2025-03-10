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
    <title>Allenamento Compito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="bg-dark text-white">
  <div style="background-image: url('./images/bg1.png'); background-position: center; height: 100vh;" class="w-100 d-flex flex-column justify-content-center text-center text-black">
  <div class="w-50 mx-auto my-auto bg-light text-center p-4 rounded-3">
    <h1 class="text-center">-- Sito Di Auto --</h1>
  </div>
  <div class="w-50 mx-auto my-auto bg-light rounded-3 p-2">
  <h1 class="text-center">Ricerca La Tua Auto!</h1>
      <hr>
      <form action="./action.php">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label"><h5>Nazione Del Marchio: </h5></label>
          <input type="text" class="form-control" id="nazioneM" name="nazioneM">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label"><h5>Velocità Massima Desiderata: </h5></label>
          <input type="number" class="form-control" id="vMax" name="vMax">
        </div>
        <div class="text-center mt-3">
          <button type="submit" class="btn btn-outline-success">CERCA</button>
        </div>
      </form>
    </div>
</div>


    <br>
    <h1 class="text-center">Configuratore</h1>
    <h5 class="text-center">Seleziona Un Modello e Visualizza i colori disponibili</h5>
    <div class="w-25 mx-auto my-auto">
      <hr>
      <form action="./colori.php">
        <select class="form-select" name="modelloScelto">
        <option selected>Seleziona Un Modello</option>
        <?php
          (include "./connessione.php");
          $query = mysqli_query($conn,"SELECT marchi.nome as marca, modelli.nome from modelli
          join marchi on marchi.id_marchio = modelli.id_marchio;");
          while($row = mysqli_fetch_assoc($query)){
            echo '<option value="'.$row['nome'].'">' . $row['marca']. " " . $row['nome'] . '</option>';
          }
        ?>
        </select>
        <div class="text-center mt-3">
          <button type="submit" class="btn btn-outline-success mt-5">VAI</button>
        </div>
      </form>
    </div>
    <br>
    <br>
    <br>
    <h1 class="text-center">CRONOLOGIA</h1>
    <DIv class="w-25 mx-auto my-auto  text-center">
    <table class="table table-hover table-dark">
        <tr>
        <th><p>Modelli Visualizzati In Precedenza</p><th>
        </tr>
    <?php
      $arrayModels = $_SESSION['cronologiaModelli'];
      if(empty($arrayModels)){
        echo '<tr>';
        echo '<td>';
        echo 'Non hai ancora visualizzato nessun modello';
        echo '</td>';
        echo '</tr>';
      }else{
        for($i=0;$i<count($arrayModels);$i++){
          echo '<tr>';
          echo '<td>';
          echo $arrayModels[$i];
          echo '</td>';
          echo '</tr>';
        }
      }
    ?>
    </DIv>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>