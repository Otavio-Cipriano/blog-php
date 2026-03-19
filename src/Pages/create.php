

<h1>New Post</h1>

<form class="form" action="/new" method="POST">
    <div class="mt-3">
        <label for="inputTitle" class="form-label">Title</label>
        <input id="inputTitle" name="title" class="form-control" placeholder="Post Title"/>
        <?php if($errors['title']):?>
            <span class="form-text text-danger">
                <?= $errors['title'] ?>
            </span>
        <?php endif; ?>
    </div>
    <div class="mt-3">
        <label for="textareaContent">Content</label>
        <div id="editor" class="form-control"></div>
        <textarea id="textareaContent" name="content" class="form-control" placeholder="Post Content" hidden>
        </textarea>
        <?php if($errors['content']):?>
            <span class="form-text text-danger">
                <?= $errors['content'] ?>
            </span>
        <?php endif; ?>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary">
            Criar
        </button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {theme: 'snow'});
    document.querySelector('form').addEventListener('submit', (e) => {
        document.getElementById('textareaContent').value = quill.root.innerHTML;
    });
</script>