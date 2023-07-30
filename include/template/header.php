<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Happy Paw</title>
<link rel="icon" type="image/svg+xml" href="img/favicon.png">
<link rel="icon" type="image/png" href="img/favicon.svg">
<meta name="description" content="Página web Happy Paws">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- normalize -->
<link rel="preload" href="css/normalize.css" as="style">
<link rel="stylesheet" href="css/normalize.css">

<!-- Fonts -->
<link rel="preload"
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Staatliches&display=swap"
    crossorigin="crossorigin" as="font">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Staatliches&display=swap"
    rel="stylesheet">

<!-- Icons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- Styles -->
<link rel="preload" href="<?php echo $rutaCSS ?? 'css/styles.css'; ?>" as="style">
<link rel="stylesheet" href="<?php echo $rutaCSS ?? 'css/styles.css'; ?>">