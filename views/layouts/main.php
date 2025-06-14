<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AppAssetLocal;

AppAsset::register($this);
AppAssetLocal::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico" type="image/x-icon">

    <?php $this->head() ?>

    <style>
        .select2-selection--single.form-control {
            height: calc(2.5rem + 2px); /* sesuaikan dengan input height kamu */
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
        }

    </style>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #212529;
            color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
            transition: width 0.3s;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }

        .sidebar .sidebar-title {
            font-size: 1.25rem;
            padding: 15px 20px;
            color: white;
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }


        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: #1d2124;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .main-content {
            padding: 20px;
            background-color: #2b3035;
            flex: 1;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
        }

        .collapsed .sidebar-text {
            display: none;
        }

        .sidebar-toggle-btn {
            color: var(--sidebar-btn-color);
            background-color: var(--sidebar-btn-bg);
            border: 2px solid var(--sidebar-btn-border);
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            opacity: 1;
        }

        .sidebar-toggle-btn:hover {
            background-color: var(--sidebar-btn-border);
            color: var(--bg-color);
        }

    </style>

    <style>
        :root[data-theme="dark"] {
            --bg-color: #212529;
            --topbar-bg: #1d2124;
            --content-bg: #2b3035;
            --text-color: #f8f9fa;
            --sidebar-bg: #343a40;
            --sidebar-hover: #495057;
            --btn-color: #f8f9fa;
            --sidebar-btn-color: #f8f9fa;
            --sidebar-btn-bg: transparent;
            --sidebar-btn-border: #f8f9fa;
        }

        :root[data-theme="light"] {
            --bg-color: #f8f9fa;
            --topbar-bg: #ffffff;
            --content-bg: #ffffff;
            --text-color: #212529;
            --sidebar-bg: #e9ecef;
            --sidebar-hover: #ced4da;
            --btn-color: #212529;
            --sidebar-btn-color: #212529;
            --sidebar-btn-bg: transparent;
            --sidebar-btn-border: #212529;
        }


        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .sidebar {
            background-color: var(--sidebar-bg);
        }

        .sidebar-text {
            color: var(--text-color);
            transition: color 0.3s;
        }


        .sidebar a {
            color: var(--text-color);
        }

        .sidebar a:hover {
            background-color: var(--sidebar-hover);
        }

        .topbar {
            background-color: var(--topbar-bg);
            color: var(--text-color);
        }

        .main-content {
            background-color: var(--content-bg);
        }

        .btn-outline-light {
            color: var(--btn-color);
            border-color: var(--btn-color);
        }

        .btn-outline-light:hover {
            background-color: var(--btn-color);
            color: var(--bg-color);
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item {
            color: var(--text-color);
            display: inline-flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb-item a:hover {
            color: var(--btn-color);
            text-decoration: underline;
        }

        .breadcrumb-separator {
            font-size: 0.8rem;
            margin-left: 0.3rem;
            margin-right: 0.3rem;
            color: var(--text-color);
            user-select: none;
        }

        .breadcrumb-item.active {
            color: var(--btn-color);
            font-weight: 600;
        }

        .breadcrumb-home i {
            margin-right: 0.25rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            content: "\f105"; /* fa-chevron-right */
            padding: 0 0.5rem;
            color: var(--text-color);
        }


    </style>

</head>
<body>
<?php $this->beginBody() ?>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column" id="sidebar">
        <div class="sidebar-title d-flex justify-content-between align-items-center">
            <span class="sidebar-text">MyApp</span>
            <button id="toggleSidebar" class="btn sidebar-toggle-btn">
                <i class="fas fa-bars"></i>
            </button>

        </div>
        <a href="<?= Url::to(['/site/index']) ?>"><i class="fas fa-home me-2"></i> <span class="sidebar-text">Dashboard</span></a>
        <a href="<?= Url::to(['/user/index']) ?>"><i class="fas fa-users me-2"></i> <span class="sidebar-text">Users</span></a>
        <a href="<?= Url::to(['/template/index']) ?>"><i class="fas fa-book me-2"></i> <span class="sidebar-text">Template MK</span></a>
        <a href="<?= Url::to(['/resume/index']) ?>"><i class="fas fa-file me-2"></i> <span class="sidebar-text">Resume Kegiatan</span></a>
        <a href="<?= Url::to(['/job/index']) ?>"><i class="fas fa-clipboard me-2"></i> <span class="sidebar-text">Kegiatan Kalibrasi</span></a>
        <!-- <a href="<?// Url::to(['/settings/index']) ?>"><i class="fas fa-cogs me-2"></i> <span class="sidebar-text">Settings</span></a> -->
    </div>

    <!-- Content -->
    <div class="content-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center">

            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
                'options' => ['class' => 'breadcrumb my-3'],
                'homeLink' => [
                    'label' => '<i class="fas fa-home"></i>',
                    'url' => ['/site/index'],
                    'encode' => false,
                ],
                'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                'activeItemTemplate' => "<li class='breadcrumb-item active' aria-current='page'>{link}</li>\n",
                'encodeLabels' => false,
            ]) ?>


            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light" id="themeToggle" title="Toggle Theme">
                    <i class="fas fa-adjust"></i>
                </button>
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                    <?= Html::submitButton('<i class="fas fa-sign-out-alt"></i> Logout', ['class' => 'btn btn-outline-light btn-sm']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>


        <!-- Main Content -->
        <div class="main-content">
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>


                
            <?= $content ?>
        </div>
    </div>
</div>






<?php $this->endBody() ?>

<script>
        // Set tema dari localStorage saat page load
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
<script>
$(document).ready(function () {
    // Theme toggle
    $('#themeToggle').on('click', function () {
        const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', current);
        localStorage.setItem('theme', current);
    });

    // Collapse sidebar on mobile
    function handleSidebarCollapse() {
        if ($(window).width() < 768) {
            $('#sidebar').addClass('collapsed');
        } else {
            $('#sidebar').removeClass('collapsed');
        }
    }

    handleSidebarCollapse();
    $(window).resize(handleSidebarCollapse);

    // ✅ FIXED: Manual toggle now works
    $('#toggleSidebar').on('click', function () {
        $('#sidebar').toggleClass('collapsed');
    });
});
</script>

</body>
</html>
<?php $this->endPage() ?>
