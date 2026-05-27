<div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap">
    <?php if($pager->hasPreviousPage()): ?>
        <a href="<?= $pager->getPreviousPage() ?>" class="btn btn-secondary btn-sm">‹</a>
    <?php else: ?>
        <span class="btn btn-secondary btn-sm" style="opacity:.35;cursor:default">‹</span>
    <?php endif; ?>

    <?php foreach($pager->links() as $link): ?>
        <?php if($link['active']): ?>
            <span class="btn btn-primary btn-sm"><?= $link['title'] ?></span>
        <?php else: ?>
            <a href="<?= $link['uri'] ?>" class="btn btn-secondary btn-sm"><?= $link['title'] ?></a>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if($pager->hasNextPage()): ?>
        <a href="<?= $pager->getNextPage() ?>" class="btn btn-secondary btn-sm">›</a>
    <?php else: ?>
        <span class="btn btn-secondary btn-sm" style="opacity:.35;cursor:default">›</span>
    <?php endif; ?>
</div>
