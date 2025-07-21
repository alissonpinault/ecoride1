<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact - ÉcoRide</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
  <link rel="stylesheet" href="utiles/style.css">
</head>

<body>
  <?php include('utiles/header.php'); ?>

  <h1>Contactez-nous</h1>
  <form>
    <label>Nom <span style="color: red;">*</span> : <input type="text" name="nom"></label><br><br>
    <label>Email : <input type="email" name="email"></label><br><br>
    <label>Message :<br><textarea name="message" rows="5" cols="40"></textarea></label><br><br>
    <button type="submit">Envoyer</button>
  </form>
</body>

   <?php include('utiles/footer.php'); ?>


</html>
