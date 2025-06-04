<?php

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-theme="">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root[data-theme="dark"] {
            --bg-color: #212529;
            --content-bg: #2b3035;
            --text-color: #f8f9fa;
            --btn-color: #f8f9fa; /* tombol warna terang */
        }

        :root[data-theme="light"] {
            --bg-color: #f8f9fa;
            --content-bg: #ffffff;
            --text-color: #212529;
            --btn-color: #212529; /* tombol warna gelap */
        }


        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background-color: var(--content-bg);
            color: var(--text-color);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
        }

        .theme-toggle-btn {
            position: absolute;
            top: 20px;
            right: 20px;

            color: var(--btn-color);
            background-color: transparent;
            border: 2px solid var(--btn-color);
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            opacity: 1; /* Selalu terlihat */
        }

        .theme-toggle-btn:hover {
            background-color: var(--btn-color);
            color: var(--bg-color);
        }


        .form-control, .form-check-label {
            color: var(--text-color);
            background-color: transparent;
        }

        .form-control:focus {
            background-color: transparent;
            color: var(--text-color);
        }

        .form-label {
            color: var(--text-color);
        }
    </style>

    <script>
        // Set theme at load
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="login-wrapper">
    <div class="login-card position-relative">
        <!-- Theme toggle -->
        <button class="btn btn-sm btn-outline-light theme-toggle-btn" id="themeToggle" title="Toggle Theme">
            <i class="fas fa-adjust"></i>
        </button>

        <?= $content ?>
    </div>
</div>

<script>
    $('#themeToggle').on('click', function () {
        const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', current);
        localStorage.setItem('theme', current);
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
