<? $cols = 6 ?>
<form method="post">
    <?= CSRFProtection::tokenTag(); ?>
    <? if (!empty($results)) : ?>
        <section class="contentbox">
            <header>
                <h1><?= _('Serverübersicht') ?></h1>
            </header>
            <? foreach ($results as $category_name => $servers) : ?>
                <article class="<?= ContentBoxHelper::classes(md5($category_name)) ?> open">
                    <header>
                        <h1>
                            <a href="<?= ContentBoxHelper::href(md5($category_name)) ?>">
                                <?= htmlReady($category_name) ?>
                            </a>
                        </h1>
                    </header>
                    <section>
                        <?= $this->render_partial('show/_servers.php', compact('servers', 'category_name')) ?>
                    </section>
                </article>
            <? endforeach ?>
        </section>
    <? else : ?>
        <?= MessageBox::info(_('Bisher noch keine Server eingetragen')) ?>
    <? endif ?>
</form>