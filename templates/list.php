<div class="post-list screen post-list-screen"></div>
<script type="text/x-template" id="post-item-template">
{{#if search}}
<h2 class="search-title">{{keyword}}</h2>
{{/if}}
{{#each items}}
    <div class="post-item">
        <a href="#/view/{{ hash }}" class="post-feature" style="background-image:url({{feature}})"></a>
        <div class="post-title">
            <a href="#/view/{{ hash }}">{{ title }}</a>
        </div>
        <div class="post-meta">
            <div class="post-author-pic" style="background-image: url(media/profile/{{photo}})">
            </div>
            <div class="post-author-info">
                <b>{{ author }}</b>
                <time>{{time created_at}}</time>
            </div>
        </div>
    </div>
{{/each}}
</script>
