<h2>Espace d'administration</h2>
<?php
$session=session();
echo $le_message;
echo $session->get('user');
//etc...
?>