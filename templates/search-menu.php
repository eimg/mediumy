<script type="text/x-template" id="search-menu-template">
    {{#if auth}}
        {{#if list}}
            <li class="mobile-primary"><a href="#/new" class="primary">ဆောင်းပါးသစ်</a></li>
        {{/if}}
        {{#if new}}
            {{#if blank}}
                <li class="mobile-primary"><span class="link" onclick="$('.editable-title').focus()">စတင်ရေးသားပါ</span></li>
            {{else}}
                <li class="mobile-primary"><span class="link primary" onclick="app.add()">လွှင့်တင်</span></li>
            {{/if}}
        {{/if}}
        {{#if view}}
            {{#if blank}}
                <li class="mobile-primary"><span class="link" onclick="$('.editable-title').focus()">ရေးသားပါ</span></li>
            {{else}}
                {{#if hasPermit}}
                    {{#if saved}}
                        <li class="mobile-primary"><span class="link">သိမ်းပြီး</span></li>
                    {{else}}
                        <li class="mobile-primary"><span class="link primary" onclick="app.save()">ပြင်ဆင်မှုကိုသိမ်း</span></li>
                    {{/if}}
                {{/if}}
            {{/if}}
        {{/if}}
    {{/if}}
    <li>
        <span class="fa fa-search mobile-search-trigger" onclick="$('.mobile-search').show();$('.mobile-search input').focus()"></span>
        <span class="fa fa-search desktop-search-trigger" onclick="$(this).next().toggle().focus()"></span>
        <input type="text" id="search-input" placeholder="ရှာရန်" onkeydown="app.search(this, event)">
    </li>
    <li>
        <span class="link desktop-menu-trigger"><span class="fa fa-angle-down"></span></span>
        <span class="link mobile-menu-trigger" onclick="app.toggleSubMenu(this)"><span class="fa fa-angle-down"></span></span>
        <ul class="sub-menu">
            {{#if auth}}
            <li><span class="link" onclick="app.showProfile()">ပရိုဖိုင်ပြင်ဆင်</span></li>
            <li><span class="link" onclick="app.logout()">လော့ဂ်အောက်ထွက်</span></li>
            {{else}}
            <li><span class="link" onclick="app.showLogin()">လော့ဂ်အင်ဝင်</span></li>
                {{#if allow_reg}}
                    <li><span class="link" onclick="app.showRegister()">အကောင့်ဆောက်</span></li>
                {{/if}}
            {{/if}}

        </ul>
    </li>
</script>
