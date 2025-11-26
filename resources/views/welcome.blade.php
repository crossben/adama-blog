{{-- resources/views/company.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Blog</title>
    <!-- Add any CSS here -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            padding: 50px;
        }

        .hero-section {
            background-color: #1e3a8a;
            color: white;
            padding: 80px 20px;
            border-radius: 10px;
            margin-bottom: 50px;
        }

        .hero-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .btn-admin {
            background-color: #065f46;
            color: white;
            padding: 15px 40px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-admin:hover {
            background-color: #064e3b;
        }

        .info-section {
            background-color: #ffffff;
            padding: 40px 20px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .info-section h2 {
            font-size: 36px;
            color: #064e3b;
            margin-bottom: 20px;
        }

        .info-section p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-section {
            margin-top: 50px;
            padding: 30px;
            background-color: #e5e7eb;
            border-radius: 8px;
        }

        .cta-section h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .cta-section a {
            background-color: #065f46;
            color: white;
            padding: 15px 35px;
            font-size: 18px;
            text-decoration: none;
            border-radius: 8px;
        }

        .cta-section.py-5 {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .cta-section a:hover {
            background-color: #064e3b;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Section d'Appel à l'Action -->
        <div class="cta-section py-5">
            <h2>Bienvenue dans Mon Monde</h2>
            <p>Ce blog est l'endroit où je partage mes pensées, projets et réflexions personnelles. Que vous soyez ici pour des idées technologiques, des histoires personnelles ou simplement pour explorer — je suis ravi que vous soyez passé. N'hésitez pas à explorer le panneau d'administration si vous aidez à maintenir le site.</p>
            <a href="/admin" class="btn-admin">Aller au Panneau d'Administration</a>
        </div>

        <!-- Section Héro -->
        <div class="hero-section">
            <h1>Bienvenue sur le Blog</h1>
            <!-- <p>Salut, je suis abciss71. Cet espace est mon coin du web où je parle des choses qui comptent pour moi — de la programmation et du design aux réflexions quotidiennes et projets créatifs.</p> -->
        </div>

        <!-- Section d'Informations -->
        <div class="info-section">
            <h2>À Propos de Moi</h2>
            <p>Je suis un esprit curieux avec une passion pour la technologie, la créativité et l'apprentissage tout au long de la vie. Ce blog sert de journal numérique et de portfolio — un endroit pour partager, se connecter et réfléchir. Que ce soit des extraits de code, des tutoriels ou des parcours personnels, je crois en le partage des connaissances et la croissance ensemble.</p>
            <p>Merci de votre visite — j'espère que vous trouverez quelque chose qui vous inspire ou vous aide. N'hésitez pas à me contacter ou à laisser un commentaire si quelque chose résonne avec vous.</p>
        </div>
    </div>

</body>

</html>
