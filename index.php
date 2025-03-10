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
      <table class="table mx-auto my-auto table-hover table-dark">
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
      </table>
      </DIv>
    <br>
    <div class="w-50 mx-auto my-auto text-center">
    <h1 class="text-center">-- Catalogo Dei Modelli --</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; //PER INVIARE I DATI ALLA STESSA PAGINA DEL FORM?>">
      <div class="container w-25 mx-auto my-auto text-center">
        <div class="row">
          <div class="col">
            <h6>Prezzo Min</h6>
            <input type="number" class="form-control" id="filtroPrezzoMin" name="filtroPrezzoMin">
          </div>
          <div class="col">
            <h6>Prezzo Max</h6>
            <input type="number" class="form-control" id="filtroPrezzoMax" name="filtroPrezzoMax">
          </div>
        </div>
      </div>
      <br>
      <button type="submit" class="btn btn-success">Cerca Nel Catalogo</button>
    </form>
    <br>
      <?php
          echo '<table class="table table-bordered">';
          echo '<tr>';
            echo '<th>MODELLO</th>';
            echo '<th>MARCA</th>';
            echo '<th>PREZZO</th>';
          echo '</tr>';
          if (!empty($_GET['filtroPrezzoMin']) && !empty($_GET['filtroPrezzoMax'])) { 
            // Se si applicano entrambi i filtri
            $query = mysqli_query($conn, "SELECT modelli.nome, marchi.nome as nMarca, modelli.prezzo_base 
                FROM modelli 
                JOIN marchi ON marchi.id_marchio = modelli.id_marchio 
                WHERE prezzo_base >= " . $_GET['filtroPrezzoMin'] . " AND prezzo_base <= " . $_GET['filtroPrezzoMax']);
        } else if (!empty($_GET['filtroPrezzoMin'])) { 
            // Se si applica solo il filtro del prezzo minimo
            $query = mysqli_query($conn, "SELECT modelli.nome, marchi.nome as nMarca, modelli.prezzo_base 
                FROM modelli 
                JOIN marchi ON marchi.id_marchio = modelli.id_marchio 
                WHERE prezzo_base >= " . $_GET['filtroPrezzoMin']);
        } else if (!empty($_GET['filtroPrezzoMax'])) { 
            // Se si applica solo il filtro del prezzo massimo
            $query = mysqli_query($conn, "SELECT modelli.nome, marchi.nome as nMarca, modelli.prezzo_base 
                FROM modelli 
                JOIN marchi ON marchi.id_marchio = modelli.id_marchio 
                WHERE prezzo_base <= " . $_GET['filtroPrezzoMax']);
        } else { 
            // Se non si usano filtri
            $query = mysqli_query($conn, "SELECT modelli.nome, marchi.nome as nMarca, modelli.prezzo_base 
                FROM modelli 
                JOIN marchi ON marchi.id_marchio = modelli.id_marchio");
        }
          while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo '<td>' . $row['nome'] . '</td>';
            echo '<td>' . $row['nMarca'] . '</td>';
            echo '<td>' . $row['prezzo_base'] . '</td>';
            echo "</tr>";
          }
    
        echo '</table>';
      ?>

  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>