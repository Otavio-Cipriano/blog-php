<h1>Personal Blog</h1>

<?php
/** @var $posts
 * @var $post Post
 * @var $page int
 * */
?>
<hr/>
<div class="mt-5">
    <?php foreach ($posts as $post): ?>
        <a href="/post/<?= $post->slug ?>" class="article-link">
            <article class="row mb-4 mt-4 pt-2 pb-2">
                <div class="col-lg-10 col-md-9">
                    <h3><?= $post->title ?></h3>
                </div>
                <div class="col-lg-2 col-md-3 text-end">
                    <span><?= DateTime::createFromFormat('Y-m-d H:i:s', $post->publishedAt)->format('F j, Y') ?></span>
                </div>
            </article>
        </a>
    <?php endforeach; ?>
</div>
<div class="row justify-content-center">
    <div style="max-width: 100px">
        <?php if ($hasPrev): ?>
            <a href="/?page=<?= $page - 1 ?>">
                <span class="popover-arrow"><</span>
            </a>
        <?php endif; ?>
    </div>
    <div style="max-width: 100px">
        <span>
            <?= $page ?> / <?= $totalPages ?>
        </span>
    </div>
    <div style="max-width: 100px">
        <?php if ($hasNext): ?>
            <a href="/?page=<?= $page + 1 ?>">
                <span class="popover-arrow">></span>
            </a>
        <?php endif; ?>
    </div>
</div>