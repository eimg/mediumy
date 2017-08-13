<div class="post-view screen post-view-screen" style="display: none">
    <div class="author"></div>
    <div class="editable-title"></div>
    <div class="editable-body"></div>
    <input type="hidden" id="post-id" value="">
    <div class="post-view-meta"></div>
</div>
<div class="comment-view">
    <div class="comments"></div>
</div>

<script type="text/x-template" id="post-author-template">
    <div class="author-pic" style="background-image:url(media/profile/{{photo}})"></div>
    <div class="author-info">
        <div class="author-name">
            {{ author }}
        </div>
        <span class="author-pos">
            {{ description }}
        </span>
        {{#if new}}
            <span class="pub-time">ရေးသားဆဲ</span>
        {{else}}
            <span class="pub-time">{{time created_at}}</span>
        {{/if}}
    </div>
    <div class="clear-fix"></div>
    {{#if hash}}
        {{#if hasPermit}}
            <span class="delete" title="ဖျက်ရန်"
                  onclick="app.delete('{{id}}')"><span class="fa fa-trash"></span></span>
        {{/if}}
    {{/if}}
</script>

<script type="text/x-template" id="post-view-meta-template">
    {{#if favorite}}
        <div class="reaction-count" onclick="app.removeFavorite('{{hash}}', this)">
            <span class="fa fa-heart"></span>
            <span class="count" data-count={{reactions}}>{{mm reactions}}</span>
        </div>
    {{else}}
        <div class="reaction-count" onclick="app.addFavorite('{{hash}}', this)">
            <span class="fa fa-heart-o"></span>
            <span class="count" data-count={{reactions}}>{{mm reactions}}</span>
        </div>
    {{/if}}

    <div class="comment-count" onclick="app.loadComments()">
        <span class="fa fa-comment-o"></span>
        {{#if comments}}
            <span class="count" data-count={{comments}}>မှတ်ချက် ({{mm comments}}) ခု</span>
        {{else}}
            <span class="count">မှတ်ချက်မရှိသေးပါ</span>
        {{/if}}
    </div>
</script>
