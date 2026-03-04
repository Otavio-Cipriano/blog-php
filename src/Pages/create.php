

<h1>New Post</h1>

<form class="form" action="/create" method="POST">
    <div class="mt-3">
        <label for="inputTitle" class="form-label">Title</label>
        <input id="inputTitle" name="title" class="form-control" placeholder="Post Title"/>
    </div>
    <div class="mt-3">
        <label for="textareaContent">Content</label>
        <div id="editor" class="form-control"></div>
        <textarea id="textareaContent" class="form-control" placeholder="Post Content" hidden>
        </textarea>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {theme: 'snow'});
    document.querySelector('form').addEventListener('submit', () => {
        document.getElementById('content').value = quill.root.innerHTML;
    });
</script>