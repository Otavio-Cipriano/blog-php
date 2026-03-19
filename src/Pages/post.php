<div style="max-width: 1000px; margin: auto">
    <div>
        <a href="/" style=" text-decoration: none !important;">
            <span style="font-size: 2.5rem; font-weight: bolder;">
            <
            </span>
        </a>
    </div>
    <h1><?= $post->title ?></h1>
    <span><?= DateTime::createFromFormat('Y-m-d H:i:s', $post->publishedAt)->format('F j, Y') ?></span>
    <hr/>
    <p style="font-size: 1.5rem">
        <?= $post->content ?>
    </p>
</div>