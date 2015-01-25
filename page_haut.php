<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Checkeur</title>
<script type="text/javascript">
function mettre_maintenant()
{
    var maintenant = new Date();
    document.getElementById('moment').value = maintenant.getFullYear() + "-" + (maintenant.getMonth()+1) + "-" + maintenant.getDate() + " " + maintenant.getHours() + ":" + maintenant.getMinutes() + ":" + maintenant.getSeconds();
}
</script>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    <meta name="viewport" content="width=device-width" />
    </head>
    <body>
<header><a href="index.php">Checkeur</a></header>