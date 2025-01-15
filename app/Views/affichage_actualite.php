<h1><?php echo $titre;?></h1><br />
<?php
if (isset($news)){
echo $news->act_idT_ACTUALITE_act ;
echo(" -- ");
echo $news->act_texte;
}
else {
echo ("Pas d'actualité !");
}
?>