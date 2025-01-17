<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="topics.css">
    <script type="text/javascript" src="functionsJS.js"></script>
    <title>Themenauswahl</title>
</head>

<body>
<button class="backButton" title="Back to start" onclick="location.href='startseite_dozent.html';">Back</button>
<input class="searchBar" type="text" id="searchTopic" onkeyup="searchTopic()" placeholder="Search for Topics">
<input class="searchBar" type="text" id="searchTag" onkeyup="searchTag()" placeholder="Search for Tags"><br><br>
<?php
require './functions.php';
$dir = './topics';//dieser ordner is auf der selben ebene und beinhaltet alle Objekte und Seiten der einzelnen Themen

$count = iterator_count(new FilesystemIterator($dir));
refreshPost($dir);
echo "<table ><tbody class='mainTable'></tbody></table>";
//print_r($_POST);

echo "<script>";//die ordner im htdocs ordner werden durchgegangen und basierend darauf werden objekte erstellt
echo drawTableRows($dir);//fügt die Reihen der Seite hinzu
echo drawTopics($dir, "0");//fügt der koresspondierenden Zeile die jeweiligen Themen hinzu
echo "</script>";

//abhangigkeitenliste bei jedem topic mit reinpacken, (allgemein in den files suchen und nicht in den klassen)
?>

</body>

</html>