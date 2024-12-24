<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Supir</title>
</head>
<body>
    <h1>Berikan Rating untuk Supir</h1>
    <form action="" method="POST">
        <div>
            <label for="id_supir">ID Supir:</label>
            <input type="number" id="id_supir" name="id_supir" required>
        </div>
        <div>
            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" step="0.1" required>
        </div>
        <button type="submit">Kirim Rating</button>
    </form>
</body>
</html>