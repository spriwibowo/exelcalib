<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
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
    
    <!-- Select2 -->
    <?php
    $this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css");
    $this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js", ['depends' => [\yii\web\JqueryAsset::class]]);
    ?>


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

    <script>
        // Set tema dari localStorage saat page load
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

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
            <?= $content ?>
        </div>
    </div>
</div>


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



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
