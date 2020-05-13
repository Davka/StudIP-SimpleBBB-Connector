<form method="post">
    <?= CSRFProtection::tokenTag(); ?>
    <? if (!empty($results)) : ?>
        <? $counter = 0 ?>
        <? $count = count($results) ?>
        <? foreach ($results as $category_name => $data) : ?>
            <article class="studip toggle <?= ($counter == 0 || $count === 1) ? 'open' : '' ?>">
                <header>
                    <h1>
                        <a><?= htmlReady($category_name) ?></a>
                    </h1>
                    <nav>
                        <ul class="bbb-list">
                            <li><?= sprintf(_('%s TeilnehmerInnen'), $data['category_participant_count'])?></li>
                            <li><?= sprintf(_('%s Webcams'), $data['category_video_count'])?></li>
                            <li><?= sprintf(_('%s ZuhörerInnen'), $data['category_listener_count'])?></li>
                            <li><?= sprintf(_('%s Audio'), $data['category_voice_participant_count'])?></li>
                            <li><?= sprintf(_('%s ModeratorenInnen'), $data['category_moderator_count'])?></li>
                        </ul>
                    </nav>
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