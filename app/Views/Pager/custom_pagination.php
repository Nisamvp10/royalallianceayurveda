<?php $pager->setSurroundCount(2); ?>

<ul class="pagination mt-0 pt-10">

<?php if ($pager->hasPrevious()): ?>
   <li class="page-item">
      <a class="page-link" href="<?= $pager->getPreviousPage() ?>">
         <i class="fa-solid fa-chevron-left"></i>
      </a>
   </li>
<?php endif; ?>

<?php foreach ($pager->links() as $link): ?>
   <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
      <a class="page-link" href="<?= $link['uri'] ?>">
         <?= $link['title'] ?>
      </a>
   </li>
<?php endforeach; ?>

<?php if ($pager->hasNext()): ?>
   <li class="page-item">
      <a class="page-link" href="<?= $pager->getNextPage() ?>">
         <i class="fa-solid fa-chevron-right"></i>
      </a>
   </li>
<?php endif; ?>

</ul>
