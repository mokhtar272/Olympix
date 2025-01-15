
<form enctype= "multipart/form-data" action="uploadaction.php" method = "post">
    <input type="hidden" name="MAX_FILE_SIZE"   value="1000000"/>
       envoyez ce fichier : 
    <input name="userfile" type="file"/>
    <input type="submit" value="Envoyer le fichier"/>
</form>
