<div class="row">
    <h1 class="col-10">Personal Blog - Admin</h1>

    <a class="col-2 text-end" href="/logout">Sair</a>
</div>

<?php
/** @var $posts
 * @var $post Post
 * @var $page int
 * */
?>
<hr/>
<a class="btn btn-primary" href="/post/create">Novo</a>
<div class="mt-5">
    <?php foreach ($posts as $post): ?>
        <article class="row mb-4 mt-4 pt-2 pb-2">
            <a href="/post/<?= $post->id ?>" class="article-link col-lg-10 col-md-9">
                <article>
                    <div>
                        <h3><?= $post->title ?></h3>
                    </div>
                </article>
            </a>
            <div class="col-lg-2 col-md-3 text-end">
                <a href="/update">Update</a>
                <a href="/delete">Delete</a>
            </div>
        </article>
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