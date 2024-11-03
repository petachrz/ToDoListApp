<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
   
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial black, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            background-color: #2ebbc0;
            color: white;
            text-align: center;
            padding: 15px;
            width: 100%;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .welcome-text {
            text-align: center;
            margin-top: 40px;
            font-size: 18px;
        }

        .download-button {
            margin-top: 20px;
            padding: 30px 60px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .image-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 300px;
            width: 100%;
        }

        .left-image,
        .right-image {
            width: 350px;
            margin-right: 10px;
            margin-left: 10px;
        }
        .login-button {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: #2ebbc0;
            color: white;
            text-decoration: none;
            font-size: 18px;
            cursor: pointer;
            padding: 10px 20px;
            border: 6px solid #fff;
            border-radius: 5px;
        }
    </style>

</head>
<body>

<div class="header">
    <h1>To-Do List</h1>
    <a href="prihlaseni.php" class="login-button">Přihlášení</a>
</div>

<div class="welcome-text">
    <h1>Vítejte v aplikaci To-Do List!</h1>
    <p>Zde si můžete stáhnout uživatelský manuál!</p>
</div>

<a href="/todolist/manual/todolist_manual.pdf" download="todolist_manual.pdf" class="download-button">Stáhnout</a>

<div class="image-container">
    <img src="images/todolistobrazek.png" alt="Image 1" class="left-image">
    <img src="images/todolistobrazek.png" alt="Image 2" class="right-image">
</div>

</body>
</html>
