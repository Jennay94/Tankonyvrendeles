<?php
include 'head.php';
?>

<body style="margin-top: 8rem; ">
    <div style="margin-bottom: 35rem" class="contact-form">
        <h2>Kapcsolatfelvételi Űrlap</h2>
        <form action="" method="post">
            <label for="name">Név:</label>
            <input type="text" id="name" name="name" placeholder="Írd be a neved" required>

            <label for="email">Email cím:</label>
            <input type="email" id="email" name="email" placeholder="Írd be az email címed" required>

            <label for="message">Üzenet:</label>
            <textarea id="message" name="message" rows="4" placeholder="Írd ide az üzeneted" required></textarea>

            <button type="submit">Küldés</button>
        </form>
    </div>

    <style>
        .contact-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .contact-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .contact-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .contact-form button:hover {
            background-color: #45a049;
        }
    </style>
</body>
<?php
include 'footer.php';
?>