<script type="text/x-template" id="comment-template">
    <div class="comment-title">
        မှတ်ချက်များ
    </div>
    <div class="comment-form">
        <div class="comment-placeholder" onclick="(function(){$('.comment-input').slideDown();$('.comment-placeholder').hide();$('#comment-form textarea').focus()})()">
            မှတ်ချက်ရေးမည်
        </div>
        <div class="comment-input">
            <form id="comment-form">
                {{#if anon}}
                    <input type="text" placeholder="သင့်အမည်" name="author_name">
                {{/if}}
                <textarea rows="3" placeholder="သင့်မှတ်ချက်" name="comment"></textarea>
                <div class="comment-action">
                    <span class="link-button" onclick="app.addComment()">မှတ်ချက်ပေး</span>
                    <label class="inline-error">မှတ်ချက်အရင်ရေးပါဦး</label>
                </div>
            </form>
        </div>
    </div>
    {{#each comments}}
    <div class="comment-item">
        <div class="comment-author">
            <div class="comment-author-pic" style="background-image:url(media/profile/{{photo}})"></div>
            <div class="comment-author-info">
                <b>{{author_name}}</b>
                <time>{{time created_at}}</time>
            </div>
            <div class="delete-comment" onclick="app.deleteComment({{id}}, this)">
                <span class="fa fa-ban"></span>
            </div>
        </div>
        <div class="comment-body">
            {{comment}}
        </div>
    </div>
    {{/each}}
</script>
