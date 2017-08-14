<div class="profile model profile-model"></div>
<script type="text/x-template" id="profile-template">
    <span class="fa fa-close" onclick="app.closeModel()"></span>
    <div class="model-head">
        <div class="profile-pic" style="background-image:url(media/profile/{{photo}})" onclick="app.uploadPhoto()">
            <span class="fa fa-camera"></span>
        </div>
    </div>
    <div class="model-body">
        <form id="profile-form">
            <input type="text" name="author" placeholder="အမည်" value="{{author}}">
            <div class="error-message profile-author-error">အမည်ပေးပါ</div>
            <div contenteditable="true" class="editable description" placeholder="ကိုယ်ရေးအကျဉ်း">{{description}}</div>
            <div class="error-message profile-description-error">ကိုယ်ရေးအကျဉ်းပေးပါ</div>
            <input type="text" placeholder="အီးမေးလ်" name="email" value="{{email}}">
            <div class="error-message profile-email-error">အီးမေးလ်လိပ်စာမှန်အောင်ပေးပါ</div>
            <button type="button" onclick="app.updateProfile()">ပရိုဖိုင်ပြင်</button>
        </form>

        <div class="model-action">
            <span class="link" onclick="app.showPassword()">ပက်စ်ဝပ်ပြောင်းရန်</span>
        </div>
    </div>
</script>
