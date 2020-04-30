<? $cols = 6 ?>
<form method="post">
    <?= CSRFProtection::tokenTag(); ?>
    <? if (!empty($results)) : ?>
        <? $counter = 0 ?>
        <? $count = count($results) ?>
        <? foreach ($results as $category_name => $data) : ?>
            <article class="studip toggle <?= ($counter == 0 || $count === 1) ? 'open' : '' ?>">
                <header>
                    <h1>
                        <a><?= htmlReady($category_name) ?> - <?= sprintf(_('%s TeilnehmerInnen'), $data['category_participant_count'])?></a>
                    </h1>
                </header>
                <section>
                    <? $servers = $data['results']?>
                    <?= $this->render_partial('show/_servers.php', compact('servers', 'category_name')) ?>
                </section>
            </article>
            <? $counter++ ?>
        <? endforeach ?>
    <? else : ?>
        <?= MessageBox::info(_('Bisher noch keine Server eingetragen')) ?>
    <? endif ?>
</form>