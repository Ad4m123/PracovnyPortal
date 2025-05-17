<?php
// Kontrola, či sú nastavené potrebné premenné, inak použiť predvolené hodnoty
$pageTitle = isset($pageTitle) ? $pageTitle : 'Stránka';
$breadcrumbs = isset($breadcrumbs) ? $breadcrumbs : [
    ['title' => 'Home', 'link' => 'index.php', 'active' => false],
    ['title' => $pageTitle, 'link' => '', 'active' => true]
];
?>

<header class="site-header">
    <div class="section-overlay"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center">
                <h1 class="text-white"><?= $pageTitle ?></h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <?php foreach ($breadcrumbs as $breadcrumb): ?>
                            <?php if ($breadcrumb['active']): ?>
                                <li class="breadcrumb-item active" aria-current="page"><?= $breadcrumb['title'] ?></li>
                            <?php else: ?>
                                <li class="breadcrumb-item"><a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['title'] ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</header>