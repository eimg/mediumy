<div class="login model login-model">
    <span class="fa fa-close" onclick="app.closeModel()"></span>
    <div class="model-head">
        <img src="img/logo.png" alt="">
        <div class="model-title">
            Mediumy
        </div>
    </div>
    <div class="model-body">
        <form id="login-form">
            <input name="email" type="text" placeholder="အီးလ်မေး">
            <div class="error-message login-email-error">အီးလ်မေးလိပ်စာမှန်အောင်ပေးပါ</div>
            <input name ="password" type="password" placeholder="ပက်စ်ဝပ်">
            <div class="error-message login-password-error">ပက်စ်ဝပ်ပေးပါ</div>
            <button type="button" onclick="app.login()">လော့ဂ်အင်</button>
        </form>
        <!-- <div class="model-action">
            <span class="link">ပက်စ်ဝပ်မမှတ်မိတော့ပါ</span>
        </div> -->
    </div>
</div>
