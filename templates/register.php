<div class="register model register-model">
    <span class="fa fa-close" onclick="app.closeModel()"></span>
    <div class="model-head">
        <img src="img/logo.png" alt="">
        <div class="model-title">
            Mediumy
        </div>
    </div>
    <div class="model-body">
        <form id="register-form">
            <input type="text" name="author" placeholder="အမည်">
            <div class="error-message register-author-error">အမည်ထည့်သွင်းပေးပါ</div>
            <input type="text" name="email" placeholder="အီးလ်မေး">
            <div class="error-message register-email-error">အီးလ်မေးလိပ်စာမှန်အောင်ပေးပါ</div>
            <input type="password" name="password" placeholder="ပက်စ်ဝပ်">
            <div class="error-message register-password-error">ပက်စ်ဝပ်ခပ်ရှည်ရှည်ပေးပါ</div>
            <input type="password" name="password_again" placeholder="ပက်စ်ဝပ်နောက်တစ်ကြိမ်">
            <div class="error-message register-password-again-error">ပက်စ်ဝပ်နှစ်ကြိမ်တူအောင်ပေးပါ</div>
            <button type="button" onclick="app.register()">အကောင့်ဆောက်</button>
        </form>
    </div>
</div>
