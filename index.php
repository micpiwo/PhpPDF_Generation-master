
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="public/css/styles.css">

    <title>TEST FPDF</title>
  </head>
  <body>
      <h1>Test de la lib fpdf</h1>
    <h1 class="text-danger">Top des ventes re test sur branche maitre</h1>
      <?php
      // Appel de la librairie FPDF
      require('FPDF/fpdf/fpdf.php');


      // Création de la class PDF
      class PDF extends FPDF {
          // Header
          function Header() {
              // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
              $this->Image('public/img/logo.png',2,8);
              // Saut de ligne 20 mm
              $this->Ln(20);

              // Titre gras (B) police Helbetica de 11
              $this->SetFont('Helvetica','B',11);
              // fond de couleur gris (valeurs en RGB)
              $this->setFillColor(230,230,230);
              // position du coin supérieur gauche par rapport à la marge gauche (mm)
              $this->SetX(60);
              // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
              $this->Cell(100,8,'JEUX VIDEO QIWOGAMES SHOP',0,1,'C',1);
              // Saut de ligne 10 mm
              $this->Ln(10);
          }
          // Footer
          function Footer() {
              // Positionnement à 1,5 cm du bas
              $this->SetY(-15);
              // Police Arial italique 8
              $this->SetFont('Helvetica','I',9);
              // Numéro de page, centré (C)
              $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
          }
      }


      function generatePDF(){
      // On active la classe une fois pour toutes les pages suivantes
      // Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
          ob_get_clean();
      $pdf = new PDF('P','mm','A4');
          // Nouvelle page PDF
          $pdf->AddPage();
          // Polices par défaut : Helvetica taille 9
          $pdf->SetFont('Helvetica', '', 11);
          // Couleur par défaut : noir
          $pdf->SetTextColor(0);
          // Compteur de pages {nb}
          $pdf->AliasNbPages();

          //DATAS
          // Titre gras (B) police Helbetica de 11
          $pdf->SetFont('Helvetica','B',11);
          // fond de couleur gris (valeurs en RGB)
          $pdf->setFillColor(230,230,230);
          // position du coin supérieur gauche par rapport à la marge gauche (mm)
          $pdf->SetX(60);

          // Saut de ligne 10 mm
          $pdf->Ln(0);
          //Appel de la connexion PDO

          $user = "root";
          $pass = "";
          $db = new PDO("mysql:host=localhost; dbname=phpmvc; charset=utf8", $user, $pass);
          //Boucle de lecture
          foreach($db->query('SELECT * from mixedgames') as $row) {

              $pdf->setFillColor(255,255,255);
              $pdf->MultiCell(0,10,utf8_decode("TITRE : " .$row['title']),1,1,'L');
              //Cellule vide pour creer un espace
              $pdf->Cell(0,10,"",0,1,'C');
              $pdf->Cell(0,10, $pdf->Image($row["imgurl"]),0,2,'C');
              $pdf->MultiCell(0,10,utf8_decode("PRIX : " .$row['price']. " EUROS"),1,1,'L');
              $pdf->Cell(0,10,"",0,1,'C');
              $pdf->MultiCell(0,10,utf8_decode("DESCRIPTION : " .$row['description']),1,2,'L');
              $pdf->Cell(0,10,"",0,1,'C');
              $pdf->MultiCell(0,10,utf8_decode("En stock : " .$row['stock']),1,2,'L');
              $pdf->Cell(0,10,"",0,1,'C');
              $pdf->MultiCell(0,10,utf8_decode("Date dépot: " .$row['date_depot']),1,2,'L');
          }


          $pdf->Output('public/PDF/jeuxvideo.pdf', 'I'); // affichage à l'écran
          // Ou export sur le serveur
          // $pdf->Output('F', '../test.pdf');
}
      ?>
    <a href="games.php">Generer le PDF</a>
  </body>
</html>

