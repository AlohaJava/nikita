<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отсчет до Дня Рождения Никиты</title>
    <style>
        body {
            background: linear-gradient(to right, #ffcc33, #ff66cc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 3em;
            margin-bottom: 0.5em;
        }
        .countdown {
            font-size: 2em;
        }
        .comments {
            margin-top: 20px;
            text-align: left;
        }
        .comment {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .comment h4, .comment p {
            margin: 0;
        }
        .comment h4 {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>До Дня Рождения Никиты осталось:</h1>
        <div id="countdown" class="countdown"></div>

        <div class="comments">
            <h2>Комментарии:</h2>
            <?php
            session_start();
            if (!isset($_SESSION['comments'])) {
                $_SESSION['comments'] = [];
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['comment'])) {
                $comment = [
                    'name' => htmlspecialchars($_POST['name']),
                    'text' => htmlspecialchars($_POST['comment']),
                    'time' => date('Y-m-d H:i:s')
                ];
                $_SESSION['comments'][] = $comment;
            }
            ?>

            <form method="POST">
                <input type="text" name="name" placeholder="Ваше имя" required><br>
                <textarea name="comment" placeholder="Ваш комментарий" required></textarea><br>
                <button type="submit">Отправить</button>
            </form>

            <?php
            if (!empty($_SESSION['comments'])) {
                foreach ($_SESSION['comments'] as $comment) {
                    echo "<div class='comment'><h4>{$comment['name']} ({$comment['time']})</h4><p>{$comment['text']}</p></div>";
                }
            }
            ?>
        </div>
    </div>
    <script>
        function updateCountdown() {
            const now = new Date();
            let year = now.getFullYear();
            const birthday = new Date(year, 5, 11);
            if (now > birthday) {
                birthday.setFullYear(year + 1);
            }
            const diff = birthday - now;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            const milliseconds = Math.floor((diff % 1000) / 1);

            document.getElementById('countdown').innerHTML =
                days + "д " + hours + "ч " + minutes + "м " + seconds + "с " + milliseconds + "мс";
        }

        setInterval(updateCountdown, 1);
    </script>
</body>
</html>
