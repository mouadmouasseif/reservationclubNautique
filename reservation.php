<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$nomBaseDeDonnees = "reservations";

$connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

// Vérifier la connexion
if (!$connexion) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$date = $_POST['date'];
$heure = $_POST['heure'];
$activite = $_POST['activite'];
$nombrePersonnes = $_POST['nombre_personnes'];
$prixUnitaire = 0;
$duree = "";

// Récupérer le prix unitaire et la durée de l'activité
switch ($activite) {
    case 'kayak':
        $prixUnitaire = 50;
        $duree = '2 heure';
        break;
    case 'paddel':
        $prixUnitaire = 100;
        $duree = '2 heure';
        break;
    case 'catamaran':
        $prixUnitaire = 200;
        $duree = '1 heures';
        break;
    case 'surf':
        $prixUnitaire = 150;
        $duree = '2 heures';
        break;
}

// Calculer le prix total
$prixTotal = $prixUnitaire * $nombrePersonnes;

// Insérer les données dans la base de données
$sql = "INSERT INTO reservations (nom, prenom, telephone, email, date, heure, activite, nombre_personnes, prix_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $connexion->prepare($sql);
$stmt->bind_param("sssssssid", $nom, $prenom, $telephone, $email, $date, $heure, $activite, $nombrePersonnes, $prixTotal);

if ($stmt->execute()) {
    // Générer le PDF avec les données du formulaire
    require('fpdf.php');

    class PDF extends FPDF
    {
        function Header()
        {
            $this->Image('logo.png', 10, 6, 30);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(80);
            $this->Cell(30, 10, 'Club Nautique Plage de Rabat', 1, 0, 'C');
            $this->Cell(30, 10, 'recue de Reservation', 1, 0, 'C');
            $this->Ln(20);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);

            $this->Cell(0, 10, 'Suivez-nous sur Instagram :', 0, 0, 'L');
            $this->Cell(0, 10, 'https://www.instagram.com/cnpr.rabat/?igshid=MzRlODBiNWFlZA%3D%3D', 0, 1, 'L', false, 'https://www.instagram.com/cnpr.rabat/?igshid=MzRlODBiNWFlZA%3D%3D');

            $this->Cell(0, 10, 'Nous trouver sur Google Maps :', 0, 0, 'L');
            $this->Cell(0, 10, 'Adresse : Votre adresse', 0, 1, 'L', false, 'https://goo.gl/maps/tsADYxbNifbMLm4Z6');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();

    // Contenu du PDF
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Nous vous informons que votre réservation a été bien enregistrée.', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nom : ' . $nom, 0, 1);
    $pdf->Cell(0, 10, 'Prénom : ' . $prenom, 0, 1);
    $pdf->Cell(0, 10, 'Téléphone : ' . $telephone, 0, 1);
    $pdf->Cell(0, 10, 'Email : ' . $email, 0, 1);
    $pdf->Cell(0, 10, 'Date de réservation : ' . $date, 0, 1);
    $pdf->Cell(0, 10, 'Heure de réservation : ' . $heure, 0, 1);
    $pdf->Cell(0, 10, 'Activité : ' . $activite, 0, 1);
    $pdf->Cell(0, 10, 'Nombre de personnes : ' . $nombrePersonnes, 0, 1);
    $pdf->Cell(0, 10, 'Prix total : ' . $prixTotal . 'dh', 0, 1);

    // Générer le fichier PDF et le télécharger
    $pdf->Output('reservation.pdf', 'D');

    // Fermer la déclaration de la requête
    $stmt->close();
    
    // Fermer la connexion à la base de données
    mysqli_close($connexion);

    // Rediriger l'utilisateur vers une page de confirmation
    header("Location: confirmation.php");
} else {
    echo "Erreur lors de l'insertion des données : " . $stmt->error;
    // Fermer la déclaration de la requête
    $stmt->close();
    
    // Fermer la connexion à la base de données
    mysqli_close($connexion);
}
?>
