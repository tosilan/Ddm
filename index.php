<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>短縮URLサイト</title>
</head>
<body>
    <h1>URL短縮サービス</h1>
    <form method="POST">
        <input type="text" name="url" placeholder="短縮したいURLを入力" required>
        <button type="submit">作成</button>
    </form>
    <div id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $originalUrl = $_POST['url'];
            $shortCode = generateShortCode();
            $filePath = "urls/$shortCode/index.php";
            createRedirectFile($filePath, $originalUrl);
            echo "短縮URL: <span id='short-url'>https://slink.f5.si/urls/$shortCode/</span> ";
            echo "<button onclick='copyToClipboard()'>コピー</button>";
        }

        function generateShortCode() {
            return substr(md5(uniqid(rand(), true)), 0, 6);
        }

        function createRedirectFile($filePath, $originalUrl) {
            $dir = dirname($filePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            // リダイレクト処理を記述
            $htmlContent = "<?php header('Location: $originalUrl'); exit; ?>";
            file_put_contents($filePath, $htmlContent);
        }
        ?>
    </div>
    <script>
        function copyToClipboard() {
            const shortUrl = document.getElementById('short-url').innerText;
            navigator.clipboard.writeText(shortUrl).then(() => {
                alert('短縮URLがコピーされました！');
            });
        }
    </script>
</body>
</html>
