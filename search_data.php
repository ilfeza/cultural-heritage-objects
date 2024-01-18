<?php

include "Objects_DB_Acess.php";
$conn = new Objects_DB_Acess;

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    $query = "SELECT `Номер в реестре`, `Объект`, `id` FROM course WHERE `Объект` LIKE N'%$searchTerm%' LIMIT 100";
    $conn->issue_query($query);

    if ($conn->num_rows > 0) {
        while ($row = $conn->fetch_array()) {
            echo '<p><a href="search_details.php?id=' . $row['Номер в реестре'] . '">' . $row['Объект'] . '</a></p>';
        }
    } else {
        echo '<p>Не найдены результаты поиска</p>';
    }
}
$conn->close();

?>
