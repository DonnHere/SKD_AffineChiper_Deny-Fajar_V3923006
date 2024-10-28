<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affine Cipher</title>
    <!-- Link ke file CSS eksternal -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Affine Cipher</h2>
    <form method="post">
        <!-- Input untuk teks yang akan dienkripsi atau didekripsi -->
        <input type="text" name="text" placeholder="Masukkan teks" required>
        <!-- Input untuk kunci A -->
        <input type="number" name="a" placeholder="Masukkan kunci A" required>
        <!-- Input untuk kunci B -->
        <input type="number" name="b" placeholder="Masukkan kunci B" required>
        <!-- Tombol untuk proses enkripsi -->
        <input type="submit" name="encrypt" value="Enkripsi">
        <!-- Tombol untuk proses dekripsi -->
        <input type="submit" name="decrypt" value="Deskripsi">
    </form>
    <div class="result">
        <?php
        // Fungsi untuk enkripsi menggunakan Affine Cipher
        function affine_encrypt($text, $a, $b) {
            $result = "";
            $text = strtolower($text); // Mengubah teks menjadi huruf kecil
            for ($i = 0; $i < strlen($text); $i++) {
                $char = $text[$i];
                if (ctype_alpha($char)) { // Memeriksa apakah karakter adalah huruf
                    $result .= chr((($a * (ord($char) - 97) + $b) % 26) + 97);
                } else {
                    $result .= $char; // Menyimpan karakter non-huruf secara langsung
                }
            }
            return $result;
        }

        // Fungsi untuk dekripsi menggunakan Affine Cipher
        function affine_decrypt($text, $a, $b) {
            $result = "";
            $text = strtolower($text);
            $modInverse = modInverse($a, 26); // Mencari invers modulo dari kunci A
            for ($i = 0; $i < strlen($text); $i++) {
                $char = $text[$i];
                if (ctype_alpha($char)) {
                    $result .= chr((($modInverse * (ord($char) - 97 - $b + 26)) % 26) + 97);
                } else {
                    $result .= $char;
                }
            }
            return $result;
        }

        // Fungsi untuk menemukan invers modulo dari A
        function modInverse($a, $m) {
            for ($x = 1; $x < $m; $x++) {
                if (($a * $x) % $m == 1) {
                    return $x;
                }
            }
            return 1;
        }

        // Menangani input dari form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $text = $_POST["text"];
            $a = (int)$_POST["a"];
            $b = (int)$_POST["b"];
            
            // Mengecek apakah tombol "Encrypt" ditekan
            if (isset($_POST["encrypt"])) {
                echo "<p>Teks Enkripsi: " . affine_encrypt($text, $a, $b) . "</p>";
            }
            
            // Mengecek apakah tombol "Decrypt" ditekan
            if (isset($_POST["decrypt"])) {
                echo "<p>Teks Deskripsi: " . affine_decrypt($text, $a, $b) . "</p>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>
