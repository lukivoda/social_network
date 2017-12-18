<?php require 'config/config.php'; ?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Twirl Network</title>
</head>
<body>
 <h1>Welcome to Twirl Network</h1>
  <h1>Hello <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?></h1>

</body>
</html>