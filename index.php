<?php

// Verbindung zur Datenbank herstellen
$conn = new mysqli("localhost", "root", "", "onlineshop");

//Überprüfen ob die verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}
// Produkt anlegen
if(isset($_POST['product-name'])  && isset($_POST['set-product-id']) && isset($_POST['product-description']) && isset($_POST['product-price'])) {
    $setProductId = $_POST['set-product-id'];
    $productName = $_POST['product-name'];
    $productDescription = $_POST['product-description'];
    $productPrice = $_POST['product-price'];

    $sql = "INSERT INTO Produkt (Name, bechreibung, Preis) VALUES ('$productName', '$productDescription', '$productPrice')";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt erfolgreich angelegt.";
    } else {
        echo "Fehler beim Anlegen des Produkts: " . $conn->error;
    }
}

// Produkt bearbeiten
if(isset($_POST['edit-product-id']) && isset($_POST['edit-product-name']) && isset($_POST['edit-product-description']) && isset($_POST['edit-product-price'])) {
    $editProductId = $_POST['edit-product-id'];
    $editProductName = $_POST['edit-product-name'];
    $editProductDescription = $_POST['edit-product-description'];
    $editProductPrice = $_POST['edit-product-price'];

    $sql = "UPDATE Produkt SET Name='$editProductName', bechreibung='$editProductDescription', Preis='$editProductPrice' WHERE ID='$editProductId'";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt erfolgreich bearbeitet.";

        // Das aktualisierte Produkt anzeigen
        echo "<h3>Aktualisiertes Produkt</h3>";
        echo "<p>ID: " . $editProductId . "</p>";
        echo "<p>Name: " . $editProductName . "</p>";
        echo "<p>Beschreibung: " . $editProductDescription . "</p>";
        echo "<p>Preis: " . $editProductPrice . "</p>";

        // Vorheriger Zustand des Produkts anzeigen, falls die Abfrage erfolgreich war
        $previousQuery = "SELECT * FROM Produkt WHERE ID='$editProductId'";
        $previousResult = $conn->query($previousQuery);

        if ($previousResult->num_rows > 0) {
            $previousProduct = $previousResult->fetch_assoc();
            
            echo "<h3>Vorheriger Zustand des Produkts</h3>";
            echo "<p>ID: " . $previousProduct['ID'] . "</p>";
            echo "<p>Name: " . $previousProduct['Name'] . "</p>";
            echo "<p>Beschreibung: " . $previousProduct['bechreibung'] . "</p>";
            echo "<p>Preis: " . $previousProduct['Preis'] . "</p>";
        } else {
            echo "Übersicht von geänderten Produkt.";
        }
    } else {
        echo "Fehler beim Bearbeiten des Produkts: " . $conn->error;
    }
}

// Alle Produkte aus der Datenbank abrufen
$productsQuery = "SELECT * FROM Produkt";
$productsResult = $conn->query($productsQuery);

if ($productsResult->num_rows > 0) {
    echo "<h3>Alle Produkte</h3>";
    while ($row = $productsResult->fetch_assoc()) {
        echo "<div class='product'>";
        // Überprüfen, ob die Felder existieren, bevor sie verwendet werden
        echo "<h4>ID: " . ($row['ID'] ?? '') . "</h4>";
        echo "<p>Name: " . ($row['Name'] ?? '') . "</p>";
        echo "<p>Beschreibung: " . ($row['bechreibung'] ?? '') . "</p>";
        echo "<p>Preis: " . ($row['Preis'] ?? '') . "</p>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' name='buy-product-id' value='" . ($row['ID'] ?? '') . "'>";
        echo "<input type='submit' value='Kaufen'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "Keine Produkte gefunden.";
}

// Produkt kaufen
if(isset($_POST['buy-product-id'])) {
    $buyProductId = $_POST['buy-product-id'];
    // Hier können Sie den Kaufprozess implementieren, z.B. eine Bestellung erstellen oder ähnliches.
    echo "<p>Vielen Dank für Ihren Einkauf!</p>";
}


    // db schliessen
    $conn->close();

?>