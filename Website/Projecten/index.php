<html lang='nl'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel='stylesheet' href='css/master.css'>
  <title>Summa College - Projecten</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <img src="../img/logo.png" height="30" class="d-inline-block align-top" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">Home </a>
        </li>
        <?php
          session_start();
          if (isset($_SESSION['user'])) {
          $userid = $_SESSION['user'];
          $connection = mysqli_connect("localhost", "root", "", "summaprojecten");
          $query = "SELECT * FROM lid where `lidid` = '$userid';";
          $resultaat = mysqli_query($connection, $query);
          }

          if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
            echo '<li class="nav-item active"><a class="nav-link" href="#">Bekijk projecten <span class="sr-only">(current)</span></a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="../uitloggen.php">Uitloggen</a></li>';
            echo '</ul>';
            if (mysqli_num_rows($resultaat) > 0)
            {
              while($row = mysqli_fetch_array($resultaat, MYSQLI_ASSOC))
              {
                if ($_SESSION['docent'] == 1) {
                  echo '<a href="../Projecten/maakproject.php"><button type="button" class="btn btn-primary" style="margin-right:10px;">Maak Project</button></a>';
                  echo '<a href="../Projecten/gebruiker.php"><button type="button" class="btn btn-danger" style="margin-right:10px;">Verwijder gebruikers</button></a>';
                }
                echo '<span class="navbar-text">Welkom, ' . $row['lidnaam']  . '!</span>';
              }
            }
          }
          else {
            $url = '../login.php';
            header( "Location: $url" );
          }
        ?>
    </div>
  </nav>
        
  <main>
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Projectnaam</th>
      <th scope="col">Omschrijving</th>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($_SESSION['docent'] == 1) {
      $query = "SELECT * FROM `project`;";
      $resultaat = mysqli_query($connection, $query);
      $i = 1;
      if (mysqli_num_rows($resultaat) > 0) {
        while($row = mysqli_fetch_array($resultaat, MYSQLI_ASSOC)) {
          echo '<tr>';
          echo '<th scope="row">' . $i . '</th>';
          echo '<td>' . $row['projectnaam'] . '</td>';
          echo '<td>' . $row['projectomschrijving'] . '</td>';
          echo '<td><a href="../Projecten/project.php?project=' . $row['projectid'] . '"><button type="button" class="btn btn-dark">Openen</button></a></td>';
          echo '<td><a href="../Projecten/machtiging.php?project=' . $row['projectid'] . '"><button type="button" class="btn btn-primary">Machtiging</button></a></td>';
          echo '<td><a href="../Projecten/verwijderproject.php?project=' . $row['projectid'] . '"><button type="button" class="btn btn-danger">Verwijder</button></a></td>';
          echo '</tr>';
          $i++;
        }
      }  
      else {
        echo 'Projecten konden niet laden. Probeer opnieuw.';
      }
    }
    else {    
      $query = "SELECT * FROM `project` INNER JOIN `projectlid` on project.projectid = projectlid.projectid where `lidid` = '$userid';";
      $resultaat = mysqli_query($connection, $query);
      $i = 1;
      if (mysqli_num_rows($resultaat) > 0) {
        while($row = mysqli_fetch_array($resultaat, MYSQLI_ASSOC)) {
          echo '<tr>';
          echo '<th scope="row">' . $i . '</th>';
          echo '<td>' . $row['projectnaam'] . '</td>';
          echo '<td>' . $row['projectomschrijving'] . '</td>';
          echo '<td><a href="../Projecten/project.php?project=' . $row['projectid'] . '"><button type="button" class="btn btn-dark">Openen</button></a></td>';
          echo '</tr>';
          $i++;
        }
      }  
      else {
        echo 'Projecten konden niet laden. Probeer opnieuw.';
      }
    }
    ?>   
    
  </tbody>
  </table>
  </main>    
    
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>