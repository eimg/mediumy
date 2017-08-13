# Autolist Extension for [Medium Editor](https://github.com/yabwe/medium-editor)
### Simple implementation
**Installation**
```
bower install medium-editor-autolist --save
```

**Import the javascript**

```
<script src="bower_components/medium-editor/dist/js/medium-editor.js"></script>
<script src="/bower_components/medium-editor-autolist/dist/autolist.js"></script>
```
**Add the extension**

```
var autolist = new AutoList();
var editor = new MediumEditor('.editable', {
    buttonLabels: 'fontawesome',
    extensions: {
        'autolist': autolist
    }, 
    toolbar: {
        buttons: ['h1', 'h2', 'bold', 'italic', 'quote', 'pre', 'unorderedlist','orderedlist']
    }
}),
```


