<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use rmrevin\yii\fontawesome\CdnFreeAssetBundle;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use  common\models\AdminPage;
use  common\models\UserToPages;

AppAsset::register($this);
$pageIds = [];
$user = Yii::$app->user->identity;
$roles[] = role_id;
if ($user->other_roles) {
    foreach (explode(',', $user->other_roles) as $role){
        $roles[] = $role;
    }
}
$userPages = UserToPages::find()->where(['IN', 'role_id', $roles])->all();
if($userPages){
    foreach ($userPages as $userPage){
        $pageIds[$userPage->menu_id] = $userPage->menu_id;
        if($userPage->parent_id){
            $pageIds[$userPage->parent_id] = $userPage->parent_id;
        }
    }
}
$pages = AdminPage::find()->with('adminPages')
    ->where(['status' => 1,'on_top' => 1,'parent_id' => null])
    ->andWhere(['IN','id',$pageIds])
    ->orderBy('sort_order')->all();
CdnFreeAssetBundle::register($this);
$this->registerJs('
   var website_url = "'.website_url.'";
   var front_url = "'.config_website_url.'";
',yii\web\View::POS_HEAD);
$this->registerJs('
    $("[data-bs-toggle=\'popover\']").popover();
');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= config_website_url ?>/fav.png" type="image/x-icon">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>
<header>

    <?php
    $slug = Yii::$app->controller->id;
    $logo = config_name;
    if(config_logo){
        $logo = Html::img(config_website_url.config_logo,[
            'class' => 'img-fluid',
            'style' => 'width: 120px',
            'alt' => config_name,
            'title' => config_name,
        ]);
    }
    NavBar::begin([
        'brandLabel' => $logo,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => ['navbar-light navbar', 'bg-light sticky-top', 'navbar-expand-md']
        ],
    ]);
    $menuItems = [
        ['label' => '<i class="fas fa-home"></i>', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        if($pages){
            foreach ($pages as $page){
                $sub_pages = $page->adminPages;
                if($sub_pages){
                    $items = [];
                    foreach ($sub_pages as $sub_page){
                        if (!in_array($sub_page->id, $pageIds)) {
                            continue;
                        }
                        $name = $sub_page->config_name;
                        if($sub_page->icon){
                            $label = $sub_page->icon;
                        }else{
                            $label = $name;
                        }
                        $items [] = ['label' =>$label,
                            'active' => ($slug === $sub_page->config_value),
                            'url' => ['/'.$sub_page->config_value]
                        ];
                    }
                    $name = $page->config_name;
                    if($page->icon){
                        $label = $page->icon;
                    }else{
                        $label = $name;
                    }
                    $menuItems[] = ['label' => $label, 'url' => ['#'],'items' => $items, 'dropdownOptions' => ['class' => 'dropdown-menu-right']];
                }else{
                    $name = $page->config_name;
                    if($page->icon){
                        $label = $page->icon;
                    }else{
                        $label = $name;
                    }
                    $menuItems[] = ['label' => $label,
                        'active' => ($slug === $page->config_value),
                        'url' => ['/'.$page->config_value],
                        'options' => ['title' => $name]]
                    ;
                }
            }
        }
        $menuItems[] = ['label' => '<i class="fas fa-power-off"></i>', 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post'],'options' => ['title' => 'Logout']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <?= \lavrentiev\widgets\toastr\NotificationFlash::widget() ?>
    <div class="container">
        <div class="mt-3">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'homeLink' => ['label' => '<i class="fas fa-home"></i>','url' => ['/']],
                'encodeLabels' => false
            ]) ?>
        </div>

        <?= $content ?>
    </div>
</main>
<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="text-center fs-6">&copy; <?= Html::encode(config_name) ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
