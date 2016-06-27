<?php

// On redirige l'utilisateur vers la page de connexion s'il essaye d'accéder à une page sans être connecté.
header('Location: ' . BASE_URL . 'utilisateurs/login');

