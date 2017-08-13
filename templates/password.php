<div class="password model password-model">
    <span class="fa fa-close" onclick="app.closeModel()"></span>
    <div class="model-head"></div>
    <div class="model-body">
        <form id="password-form">
            <input type="password" name="password" placeholder="ပက်စ်ဝပ်သစ်">
            <div class="error-message password-password-error">ပက်စ်ဝပ်သစ်ခပ်ရှည်ရှည်ပေးပါ</div>
            <input type="password" name="password_again" placeholder="ပက်စ်ဝပ်သစ်နောက်တစ်ကြိမ်">
            <div class="error-message password-again-error">ပက်စ်ဝပ်နှစ်ကြိမ်တူအောင်ပေးပါ</div>
            <button type="button" onclick="app.updatePassword()">ပက်စ်ဝပ်ပြောင်း</button>
        </form>
    </div>
</div>
<script type="text/x-template" id="password-head-template">
    <div class="profile-pic" style="cursor: default; background-image:url(media/profile/{{photo}})">
    </div>
    <div class="model-title user-name">
        {{author}}
    </div>
</script>
