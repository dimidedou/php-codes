<?php
echo '<link rel="stylesheet" href="donwload-github.css">';
echo '<h1>Donwload GitHub</h1>';
echo '<form method="POST">
            URL GitHub <br><br> <input class="myforms" type="text" name="zip_url" required> <br><br>
            <input type="submit" class="submint" value="Κατέβασμα και εξαγωγή">
          </form>';

// Ελέγξτε αν υπάρχει υποβλημένο URL από τη φόρμα
if (isset($_POST['zip_url'])) {
    // Λάβετε το URL από την υποβολή φόρμας
    $githubZipUrl = $_POST['zip_url'];

    // Το όνομα του τοπικού αρχείου ZIP που θα κατεβάσουμε
    $zipFilePath = 'repository.zip';

    // Το όνομα του φακέλου στον οποίο θα εξαγάγουμε τα αρχεία
    $extractFolderName = '.'; // Μπορείτε να το αλλάξετε σε όποιο όνομα φακέλου επιθυμείτε

    // Κατέβασμα του αρχείου ZIP
    file_put_contents($zipFilePath, file_get_contents($githubZipUrl));

    // Δημιουργήστε τον φάκελο στον οποίο θα εξαγάγετε τα αρχεία
    if (!is_dir($extractFolderName)) {
        mkdir($extractFolderName, 0777, true);
    }

    // Ελέγξτε αν το αρχείο ZIP κατέβηκε επιτυχώς
    if (file_exists($zipFilePath)) {
        // Δημιουργία αντικειμένου ZipArchive
        $zip = new ZipArchive();
        
        // Άνοιγμα του αρχείου ZIP
        if ($zip->open($zipFilePath) === true) {
            // Εξαγωγή των αρχείων στο επιθυμητό μονοπάτι (στον φάκελο με το καθορισμένο όνομα)
            $zip->extractTo($extractFolderName);
            
            // Κλείσιμο του αρχείου ZIP
            $zip->close();
            
            echo "Τα αρχεία εξήχθησαν με επιτυχία στο: " . $extractFolderName;
        } else {
            echo "Δεν μπόρεσα να ανοίξω το αρχείο ZIP.";
        }
    } else {
        echo "Δεν μπόρεσα να κατεβάσω το αρχείο ZIP.";
    }

    // Μετά την εξαγωγή του περιεχομένου, διαγράψτε το αρχείο ZIP
    unlink($zipFilePath);
} 
?>
