<form method=\"post\" action="<?= $url ?>" class="default" method="post">
    <label>
        <?= _('Von') ?>
        <input type="text" data-date-picker name="from" id="bbb-exporter-from" value="<?= date('d.m.Y', strtotime('first day of this month'))?>">
    </label>
    <label>
        <?= _('Bis') ?>
        <input type="text" data-datetime-picker name="to"  value="<?= date('d.m.Y', strtotime('last day of this month'))?>"></label>
    <footer>
        <?= \Studip\Button::createAccept(_('Exportieren')) ?>
    </footer>
</form>