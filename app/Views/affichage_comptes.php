<h2><?php echo $titre; ?></h2>
<p>Nombre total de comptes : <?php echo $total_comptes; ?></p>
<?php
if (! empty($logins) && is_array($logins))
{
foreach ($logins as $pseudos)
{
echo "<br />";
echo " -- ";
echo $pseudos["cmp_e_mail"];
echo " -- ";
echo "<br />";
}
}
else {
 echo("<h3>Aucun compte pour le moment</h3>");
}
?>