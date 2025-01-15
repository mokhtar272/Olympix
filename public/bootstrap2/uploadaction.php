<?php
//$uploaddir = '/home/2024DIFAL3/e22406953/public_html/gabarit/documents/';

$mysqli = new mysqli('localhost', 'e22406953sql', 'mWeRpRD&', 'e22406953_db2');
if ($mysqli->connect_errno) {
    echo "Échec lors de la connexion à MySQL : " . $mysqli->connect_error;
    exit();
}

$uploaddir = __DIR__. '/documents/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo $uploadfile;
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
echo "Le fichier est valide, et a été téléchargé
avec succès. Voici plus d'informations :\n";
$nom_fichier = $mysqli->real_escape_string(basename($_FILES['userfile']['name']));


// reauete insert into table document
$requete = "INSERT INTO T_DOCUMENT_dcm (dcm_nom, cnd_idT_CANDIDATURE_cnd ) VALUES ('$nom_fichier',2)";

if ($mysqli->query($requete)) {
    echo "Nom du fichier inséré dans la base de données.\n";
} else {
    echo "Erreur lors de l'insertion du fichier dans la base de données : " . $mysqli->error;
}
} else {
echo "Le fichier n’a pas été téléchargé. Il y a eu un problème !\n";
}
echo 'Voici quelques informations sur le téléversement :';
print_r($_FILES);
$mysqli->close();
?>