var app = {
    // UI states
    auth: null,
    allowReg: true,
    state: null,
    editorSaved: true,
    blankEditor: true,
    hasPermit: false,

    // editors placeholder
    titleEditor: null,
    bodyEditor: null,

    // check if current session is authenticated
    verify: function(success, fail) {
        $.post("api.php", { "action": "verify" }, function(res) {
            if(!res.error) {
                app.auth = true;
                if(success) success(res);
            } else {
                app.auth = false;
                if(fail) fail(res);
            }
        }, "json");
    },

    // send email & password, get auth token
    login: function() {
        var email = $("#login-form input[name=email]").val();
        var password = $("#login-form input[name=password]").val();

        if(!email || !password) {
            if(!email) app.showError(".login-email-error");
            if(!password) app.showError(".login-password-error");

            return false;
        }

        app.showProgress();
        $.post("api.php", {
            action: "login",
            email: email,
            password: password
        }, function(res) {
            if(res.error) {
                $("#login-form input[name=email]").val('');
                $("#login-form input[name=password]").val('');
                app.showModelMessage({
                    message:"လော့ဂ်အင်မအောင်မြင်ပါ၊ အချက်အလက်များပြန်စစ်ပါ",
                    close: "နောက်တစ်ကြိမ်ပြန်ဝင်",
                    confirm: false
                });
            } else {
                app.auth = true;
                app.closeModel();
                router.refresh();
            }
            app.hideProgress();
        }, "json");
    },

    logout: function() {
        this.auth = false;
        router.refresh();
        document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        document.cookie = 'user_id=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    },

    register: function() {
        var email_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        var author = $("#register-form input[name=author]").val();
        var email = $("#register-form input[name=email]").val();
        var password = $("#register-form input[name=password]").val();
        var password_again = $("#register-form input[name=password_again]").val();

        if(!author || !email || !email_regex.test(email) || !password || !password_again) {
            if(!author) app.showError(".register-author-error");
            if(!email) app.showError(".register-email-error");
            if(!email_regex.test(email)) app.showError(".register-email-error");
            if(!password) app.showError(".register-password-error");
            if(!password_again) app.showError(".register-password-again-error");
            if(password != password_again) {
                app.showError(".register-password-error");
                app.showError(".register-password-again-error");
            }

            return false;
        }

        app.showProgress();
        $.post("api.php", {
            action: "register",
            author: author,
            email: email,
            password: password
        }, function(res) {
            if(res.error == 1) {
                $("#register-form input[name=password]").val('');
                $("#register-form input[name=password_again]").val('');
                app.showModelMessage({
                    message: res.msg,
                    close: "အကောင့်ပြန်ဆောက်",
                    confirm: false
                });
            } else {
                app.closeModel();
                app.showModelMessage({
                    message: "မှတ်ပုံတင်ခြင်းအောင်မြင်၍ လော့ဂ်အင်ဝင်နိုင်ပြီ",
                    close: "ကောင်းပြီ",
                    confirm: false
                });
            }
            app.hideProgress();
        }, "json");
    },

    updateProfile: function() {
        var author = $("#profile-form input[name=author]").val();
        var email = $("#profile-form input[name=email]").val();
        var description = $("#profile-form div.description").html();

        // cleaning up the quirk of contenteditable
        description = description.replace(/\<br\/?\>/g, "");

        if(!author || !email) {
            if(!author) app.showError(".profile-author-error");
            if(description == "") app.showError(".profile-description-error");
            if(!email) app.showError(".profile-email-error");

            return false;
        }

        app.showProgress();
        $.post("api.php", {
            action: "profile",
            author: author,
            email: email,
            description: description
        }, function(res) {
            if(res.error) {
                app.showModelMessage({
                    message: res.msg,
                    close: "ပြန်ပြင်",
                    confirm: false
                });
            } else {
                app.closeModel();
                app.showModelMessage({
                    message: "ပရိုဖိုင်ပြင်ပြီးသွားပါပြီ",
                    close: "ကောင်းပြီ",
                    confirm: false
                });
                router.refresh();
            }

            app.hideProgress();
        }, "json");
    },

    updatePassword: function() {
        var password = $("#password-form input[name=password]").val();
        var password_again = $("#password-form input[name=password_again]").val();

        if(!password || !password_again) {
            if(!password) app.showError(".password-password-error");
            if(!password_again) app.showError(".password-again-error");

            return false;
        }

        app.showProgress();
        $.post("api.php", {
            action: "password",
            password: password
        }, function(res) {
            $("#password-form input[name=password]").val("");
            $("#password-form input[name=password_again]").val("");

            if(res.error) {
                app.showModelMessage({
                    message: res.msg,
                    close: "ပြန်ပြင်",
                    confirm: false
                });
            } else {
                app.closeModel();
                app.showModelMessage({
                    message: "ပက်စ်ဝပ်ပြင်ပြီးပါပြီ",
                    close: "ကောင်းပြီ",
                    confirm: false
                });
                router.refresh();
            }

            app.hideProgress();
        }, "json");
    },

    uploadPhoto: function() {
        $("#photo-input").fileupload({
            dataType: "json",
            url: "api.php?action=photo",
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            progress: function(e, data) {
                app.showProgress();
            },
            done: function (e, res) {
                if(res.result.error) {
                    app.showModelMessage({
                        message: res.result.msg,
                        close: "ကောင်းပြီ",
                        confirm: false
                    });
                } else {
                    // Re-render Profile
                    var source = $("#profile-template").html();
                    var template = Handlebars.compile(source);
                    $(".profile-model").html(template(res.result));

                    router.refresh();
                }

                app.hideProgress();
            }
        }).trigger("click");
    },

    /* === Posts === */

    search: function(ele, e) {
        if(e.which == 13) {
            var keyword = $(ele).val();
            if(!keyword.trim()) return false;

            router.setLocation("#/search/" + keyword);
            $(ele).val('');
            $(".mobile-search").hide();
        }
    },

    // saving post
    save: function() {
        app.showProgress();
        app.verify(function() {
            var id = $("#post-id").val();

            // get clean contents from editors
            var title = app.titleEditor.serialize()['element-0'].value;
            var body = app.bodyEditor.serialize()['element-0'].value;

            // TODO: client-side Validatation

            $.post("api.php", {
                action: "update",
                id:id,
                title:title,
                body:body
            }, function(res) {
                if(res.error) {
                    app.showModelMessage({
                        message: res.msg,
                        close: "ကောင်းပြီ",
                        confirm: false
                    });
                } else {
                    app.editorSaved = true;
                    app.updateUIState(app.state);
                }
                app.hideProgress();
            }, "json");
        }, function() {
            // verification failed
            app.hideProgress();
        });
    },

    // adding post
    add: function() {
        app.showProgress();
        app.verify(function() {
            var title = app.titleEditor.serialize()['element-0'].value;
            var body = app.bodyEditor.serialize()['element-0'].value;

            // TODO: client-side validation

            $.post("api.php", {
                action: "add",
                title:title,
                body:body
            }, function(res) {
                if(res.error) {
                    app.showModelMessage({
                        message: res.msg,
                        close: "ကောင်းပြီ",
                        confirm: false
                    });
                } else {
                    app.editorSaved = true;
                    router.setLocation("#/view/" + res.hash);
                    app.updateUIState(app.state);
                }
                app.hideProgress();
            }, "json");
        }, function() {
            // verification failed
            app.hideProgress();
        });
    },

    // showing post delte confirmation
    delete: function(id) {
        app.showModelMessage({
            message: "ဖျက်မယ်ဆိုတာသေချာပြီလား",
            confirm: true,
            close: "မဖျက်တော့ဘူး",
            yes: "သေချာပြီဖျက်မယ်",
            action: "app.realDelete('" + id + "')"
        });
    },

    // deleting the post
    realDelete: function(id) {
        app.showProgress();
        app.verify(function() {
            $.post("api.php", {
                action: "delete",
                id: id
            }, function(res) {
                app.hideProgress();
                app.closeModelMessage();

                if(res.error) {
                    app.showModelMessage({
                        message: res.msg,
                        close: "ကောင်းပြီ",
                        confirm: false
                    });
                } else {
                    router.setLocation("#/");
                }
            }, "json");
        }, function() {
            // verification failed
            app.hideProgress();
            app.closeModelMessage()
        });
    },

    /* === Comments === */

    loadComments: function(afterAdd) {
        app.showProgress();
        var id = $("#post-id").val();
        $.get("api.php", {action: "comments", id: id}, function(res) {
            var source = $("#comment-template").html();
            var template = Handlebars.compile(source);
            var data = {};
            if(res.error) {
                data = {"comments": false};
            } else {
                data = {"comments": res};
            }

            data.anon = !app.auth;

            $(".comments").html(template(data));
            if(!app.auth) $(".delete-comment").remove();
            $(".comment-view").show(function() {
                if(afterAdd) {
                    $("html, body").animate({
                        scrollTop: $(document).height()
                    }, 1000);
                } else {
                    $("html, body").animate({
                        scrollTop: $('.comments').offset().top
                    }, 1000);
                }
            });
            app.hideProgress();
        }, "json");
    },

    addComment: function() {
        var comment = $("#comment-form textarea[name=comment]").val();
        if(!comment) {
            $("#comment-form .inline-error").show();
            $("#comment-form textarea[name=comment]").focus();
            setTimeout(function() {
                $("#comment-form .inline-error").fadeOut();
            }, 4000);

            return false;
        }

        var author_name = $("#comment-form input[name=author_name]").val() || "အမည်မဖော်လိုသူ";
        var post_id = $("#post-id").val();

        app.showProgress();
        $.post("api.php", {
            action: "comment",
            post_id: post_id,
            comment: comment,
            author_name: author_name
        }, function(res) {
            app.hideProgress();
            if(!res.error) {
                var count = parseInt($(".comment-count .count").attr("data-count"));
                $(".comment-count .count")
                    .attr("data-count", count + 1)
                    .html("မှတ်ချက် ("+ en2mmNums(count + 1) +") ခု");

                app.loadComments(true);
            }
        });
    },

    deleteComment: function(id, ele) {
        app.showProgress();
        $.post("api.php", {
            "action": "deleteComment",
            id: id
        }, function(res) {
            if(res.error) {
                app.showModelMessage({
                    message: res.msg,
                    confirm: false,
                    close: "ကောင်းပြီ"
                });
            } else {
                $(ele).parent().parent().fadeOut(function() {
                    $(this).remove();
                    var count = parseInt($(".comment-count .count").attr("data-count"));
                    if((count - 1) > 0) {
                        $(".comment-count .count")
                            .attr("data-count", count - 1)
                            .html("မှတ်ချက် ("+ en2mmNums(count - 1) +") ခု");
                    } else {
                        $(".comment-count .count")
                            .attr("data-count", 0)
                            .html("မှတ်ချက်မရှိသေးပါ");
                    }

                });
            }

            app.hideProgress();
        });
    },

    /* === Favorite === */

    addFavorite: function(hash, ele) {
        var count = $(".count", $(ele));
        var data = parseInt(count.attr("data-count"));
        count.attr("data-count", data + 1);
        count.html( en2mmNums(data + 1) );
        $(".fa-heart-o", $(ele)).addClass("fa-heart").removeClass("fa-heart-o");
        $(ele).attr("onclick", "app.removeFavorite('" + hash + "', this)");
        addToStore(hash);
        $.post("api.php", {action: "favorite", hash: hash});
    },

    removeFavorite: function(hash, ele) {
        var count = $(".count", $(ele));
        var data = parseInt(count.attr("data-count"));
        count.attr("data-count", data - 1);
        count.html( en2mmNums(data - 1) );
        $(".fa-heart", $(ele)).addClass("fa-heart-o").removeClass("fa-heart");
        $(ele).attr("onclick", "app.addFavorite('" + hash + "', this)");
        removeFromStore(hash);
        $.post("api.php", {action: "unfavorite", hash: hash});
    },

    /* === UI Specific === */

    loadScreen: function (screen) {
        $(".screen, .comment-view").hide();
        $(screen).show();
    },

    updateUIState: function (state) {
        app.state = state;

        var source = $("#search-menu-template").html();
        var template = Handlebars.compile(source);
        var data = {
            auth: app.auth,
            allow_reg: app.allowReg,
            saved: app.editorSaved,
            blank: app.blankEditor,
            hasPermit: app.hasPermit
        };
        data[state] = true;
        $(".search-menu").html(template(data));
    },

    showProgress: function() {
        $(".progress").show();
    },

    hideProgress: function() {
        $(".progress").hide();
    },

    toggleSubMenu: function(ele) {
        if($(ele).next(".sub-menu").is(":visible")) {
            app.unlockScroll();
            $(ele).next(".sub-menu").hide();
            $(".fa", ele).attr("class", $(".fa", ele).attr("data-class"));
        } else {
            if(app.scrollLocked) {
                $(".sub-menu").hide();
                $(".fa", ele).attr("class", $(this).attr("data-class"));
                app.unlockScroll();
            }

            app.lockScroll();
            $(".fa", ele).attr("data-class", $(".fa", ele).attr("class"));
            $(".fa", ele).attr("class", "fa fa-close");
            $(ele).next(".sub-menu").show();
        }
    },

    // store current scroll position
    // and disable the browser from scrolling
    lockScroll: function() {
        app.scrollLocked = true;

        var scrollPosition = [
          self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
          self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
        ];

        var html = jQuery('html');

        html.data('scroll-position', scrollPosition);
        html.data('previous-overflow', html.css('overflow'));
        html.css('overflow', 'hidden');
        window.scrollTo(scrollPosition[0], scrollPosition[1]);
    },

    unlockScroll: function() {
        app.scrollLocked = false;

        var html = jQuery('html');
        var scrollPosition = html.data('scroll-position');

        html.css('overflow', html.data('previous-overflow'));

        if(scrollPosition)
        window.scrollTo(scrollPosition[0], scrollPosition[1]);
    },

    // Validation messages
    showError: function(ele) {
        var timer;
        if( $(ele).is(":visible") ) {
            clearTimeout(timer);
            $(ele).css({ "transition": "color 0.5s ease", "color": "#E74C3C" });
            timer = setTimeout(function() {
                $(ele).css({ "transition": "color 5s ease", "color": "#bbb" });
            }, 1000)
        } else {
            $(ele).slideDown().css("color", "#bbb");
        }
    },

    /* === Model Dialogs === */

    showModelMessage: function(data) {
        var source = $("#model-message-template").html();
        var template = Handlebars.compile(source);
        $(".model-message").html(template(data)).show();
    },

    closeModel: function() {
        $(".overlay, .model").hide();
    },

    closeModelMessage: function() {
        $(".model-message").hide();
    },

    showLogin: function() {
        $(".overlay, .login-model").show();
        $(".login-model input").val("");
        $(".login-model input:first").focus();
    },

    showRegister: function() {
        $(".overlay, .register-model").show();
        $(".register-model input").val("");
        $(".register-model input:first").focus();
    },

    showProfile: function() {
        app.showProgress();
        app.verify(function(user) {
            // verification success
            var source = $("#profile-template").html();
            var template = Handlebars.compile(source);
            $(".profile-model").html(template(user));
            $(".overlay, .profile-model").show();
            $(".profile-model input:first").focus();
            app.hideProgress();
        }, function() {
            // verification fail
            router.setLocation("#/");
            app.hideProgress();
        });
    },

    showPassword: function() {
        $(".profile-model").hide();

        app.showProgress();
        app.verify(function(user) {
            // verification success
            var source = $("#password-head-template").html();
            var template = Handlebars.compile(source);
            $(".password-model .model-head").html(template(user));
            $(".overlay, .password-model").show();
            $(".password-model input:first").focus();
            app.hideProgress();
        }, function() {
            // verification fail
            self.redirect("#/");
            app.hideProgress();
        });
    },

    /* === Editors === */

    attachEditor: function() {
        app.titleEditor.setup();
        app.bodyEditor.setup();
    },

    detachEditor: function() {
        app.titleEditor.destroy();
        app.bodyEditor.destroy();
    },

    initEditor: function() {
        app.titleEditor = new MediumEditor(".editable-title", {
            buttonLabels: "fontawesome",
            toolbar: {
                buttons: []
            },
            placeholder: {
                text: "ခေါင်းစဉ်"
            },
            disableReturn: true
        });

        $(".editable-title").on("keydown", function(e) {
            if(e.which === 13) {
                $(".editable-body").focus();
            }
        });

        var autolist = new AutoList();
        app.bodyEditor = new MediumEditor(".editable-body", {
            buttonLabels: "fontawesome",
            extensions: {
                "autolist": autolist
            },
            toolbar: {
                buttons: ["bold", "italic", "anchor", "h2", "h3", "quote", "pre", "orderedlist", "unorderedlist"]
            },
            placeholder: {
                text: "စာကိုယ်"
            }
        });

        app.bodyEditor.subscribe("editableInput", function (event, editable) {
            if(!$(".editable-body h2:first").prev().length){
                $(".editable-body h2:first").addClass("sub-title");
            }
        });

        $(".editable-body").mediumInsert({
            editor: app.bodyEditor,
            addons: {
                images: {
                    captions: true,
                    captionPlaceholder: "ပုံညွှန်းစာ",
                    fileUploadOptions: {
                        url: "api.php?action=upload",
                        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
                    },
                    uploadCompleted: function($el, data) {},
                    uploadFailed: function(uploadErrors, data) {},
                    deleteScript: null,
                    fileDeleteOptions: {},
                    messages: {
                        acceptFileTypesError: "ပုံမဟုတ်လို့လက်မခံပါ - ",
                        maxFileSizeError: "ဖိုင်သိပ်ကြီးနေလို့လက်မခံနိုင်ပါ - "
                    }
                },
                embeds: {
                    // placeholder: 'YouTube Link သို့ Github Link',
                    // captions: true,
                    // captionPlaceholder: 'မှတ်ချက်',
                    // oembedProxy: 'http://medium.iframe.ly/api/oembed?iframe=1'
                    // oembedProxy: null
                }
            }
        });
    }
};

/* === Router === */
var router = Sammy("#main", function(context) {
    if(app.auth == null) app.verify();
    app.initEditor();

    this.notFound = function() {
        // overriding route not found to do nothing
        // instead of raising 404 into console log
    }

    this.get("#/", function() {
        app.showProgress();
        app.loadScreen(".post-list-screen");

        $.get("api.php", { action: "all" }, function(res) {
            if(!res.error) {
                var source = $("#post-item-template").html();
                var template = Handlebars.compile(source);
                $(".post-list").html(template({"items": res}));
            }

            app.updateUIState("list");
            app.hideProgress();
        }, "json");
    });

    this.get("#/search/:keyword", function() {
        app.showProgress();
        var keyword = this.params['keyword'];

        if(!keyword.trim()) {
            this.redirect("#/");
            return false;
        }

        app.loadScreen(".post-list-screen");

        $.get("api.php", { action: "all", q: keyword }, function(res) {
            var source = $("#post-item-template").html();
            var template = Handlebars.compile(source);

            $(".post-list").html(template({
                "search": true,
                "keyword": keyword,
                "items": res
            }));

            app.updateUIState("list");
            app.hideProgress();
        }, "json");
    });

    this.get("#/new", function() {
        var self = this;
        app.blankEditor = true;

        app.showProgress();
        app.verify(function() {
            // verification success
            $.get("api.php", { action: "new" }, function(res) {
                app.detachEditor();

                var source = $("#post-author-template").html();
                var template = Handlebars.compile(source);

                res.new = true;
                $(".post-view .author").html(template(res));
                $(".editable-title").html('');
                $(".editable-body").html('');
                $(".post-view .post-view-meta").html('');

                app.loadScreen(".post-view-screen");
                app.attachEditor();
                app.updateUIState("new");
                app.hideProgress();
            }, "json");
        }, function() {
            // verification fail
            self.redirect("#/");
            app.hideProgress();
        });
    });

    this.get("#/view/:hash", function() {
        app.showProgress();
        var hash = this.params['hash'];
        app.blankEditor = false;
        app.editorSaved = true;

        $.get("api.php", { action: "get", hash: hash }, function(res) {
            if(res.error) {
                router.setLocation("#/");
                return false;
            }

            // Temporarely disabled editors
            app.detachEditor();

            var source = $("#post-author-template").html();
            var template = Handlebars.compile(source);

            // Rendering user
            if(res.user_id == getCookie("user_id")) {
                app.hasPermit = true;
                res.hasPermit = true;
            } else {
                app.hasPermit = false;
                res.hasPermit = false;
            }

            $(".post-view .author").html(template(res));

            // Rendering meta
            source = $("#post-view-meta-template").html();
            template = Handlebars.compile(source);
            if(res.comments == 0) res.comments = false;
            if(checkInStore(res.hash)) res.favorite = true;
            $(".post-view .post-view-meta").html(template(res));

            // Updaing editor states manually
            $(".editable-title").html(res.title);
            $(".editable-body").html(res.body);
            $("#post-id").val(res.id);

            app.loadScreen(".post-view-screen");

            app.verify(function() {
                // Attach editor on view
                if(res.user_id == getCookie("user_id")) {
                    app.attachEditor();
                }
            });

            app.updateUIState("view");
            app.hideProgress();
        }, "json");
    });

    // Empty route: This need to be defined last
    this.get("", function() {
        this.redirect("#/");
    });
});

/* === Helpers === */

// Handlebars custom helper for relative time
Handlebars.registerHelper("time", function(time) {
    return en2mmNums(moment(time).fromNow());
});

// Handlebars custom helper to convert numbers
Handlebars.registerHelper("mm", function(str) {
    return en2mmNums(str);
});

// Burmese locale for moment.js
moment.locale('my-mm', {
    months: 'ဇန်နဝါရီ_ဖေဖော်ဝါရီ_မတ်_ဧပြီ_မေ_ဇွန်_ဇူလိုင်_သြဂုတ်_စက်တင်ဘာ_အောက်တိုဘာ_နိုဝင်ဘာ_ဒီဇင်ဘာ'.split('_'),
    monthsShort: 'ဇန်နဝါရီ_ဖေဖော်ဝါရီ_မတ်_ဧပြီ_မေ_ဇွန်_ဇူလိုင်_သြဂုတ်_စက်တင်ဘာ_အောက်တိုဘာ_နိုဝင်ဘာ_ဒီဇင်ဘာ'.split('_'),
    monthsParseExact: true,
    weekdays: 'တနင်္ဂနွေ_တနင်္လာ_အင်္ဂါ_ဗုဒ္ဓဟူး_ကြာသာပတေး_သောကြာ_စနေ'.split('_'),
    weekdaysShort: 'နွေ_လာ_ဂါ_ဟူး_တေး_ကြာ_နေ'.split('_'),
    weekdaysMin: 'နွေ_လာ_ဂါ_ဟူး_တေး_ကြာ_နေ'.split('_'),
    weekdaysParseExact: true,
    longDateFormat: {
        LT: 'HH:mm',
        LTS: 'HH:mm:ss',
        L: 'DD/MM/YYYY',
        LL: 'D MMMM YYYY',
        LLL: 'D MMMM YYYY HH:mm',
        LLLL: 'dddd D MMMM YYYY HH:mm'
    },
    calendar : {
        lastDay : '[မနေ့က] LT',
        sameDay : '[ယနေ့] LT',
        nextDay : '[မနက်ဖြန်] LT',
        lastWeek : '[လွန့်ခဲ့သည့်] dddd [နေ့] LT',
        nextWeek : 'dddd [နေ့] LT',
        sameElse : 'L'
    },
    relativeTime : {
        future: "%s အတွင်း",
        past:   "လွန်ခဲ့သည့် %s",
        s  : 'လွန်ခဲ့သည့်စက္ကန့်အနည်းငယ်',
        ss : '%d စက္ကန့်',
        m:  "တစ်မိနစ်",
        mm: "%d မိနစ်",
        h:  "တစ်နာရီ",
        hh: "%d နာရီ",
        d:  "တစ်ရက်",
        dd: "%d ရက်",
        M:  "တစ်လ",
        MM: "%d လ",
        y:  "တစ်နှစ်",
        yy: "%d နှစ်"
    },
    meridiem : function (hour, minute, isLowercase) {
        if (hour < 10) {
            return "မနက်";
        } else if (hour < 11 && minute < 30) {
            return "နေ့လည်";
        } else if (hour < 13 && minute < 30) {
            return "မွန်းတည့်";
        } else if (hour < 16) {
            return "နေ့လည်";
        } else if (hour < 18) {
            return "ညနေ";
        } else {
            return "ည";
        }
    },
    week: {
        dow: 0, // Sunday is the first day of the week.
        doy: 4 // The week with Jan 4th is the first week of the year.
    }
});

// Convert English numbers to Burmese
function en2mmNums(number) {
    number += "";
    var nums = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
    return number.replace(/([0-9])/g, function(n) {
        return nums[n] || n;
    });
}

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

// Store post favorite data into localStorage
function addToStore(data) {
    var current = JSON.parse(localStorage.getItem('medium-my-data')) || [];
    current.push(data);
    localStorage.setItem('medium-my-data', JSON.stringify(current));
}

// Remove post favorite data from localStorage
function removeFromStore(data) {
    var current = JSON.parse(localStorage.getItem('medium-my-data')) || [];
    for(var i=0; i < current.length; i++){
        if (current[i] == data) current.splice(i, 1);
    }
    localStorage.setItem('medium-my-data', JSON.stringify(current));
}

// Check if current post is already favorite
function checkInStore(data) {
    var current = JSON.parse(localStorage.getItem('medium-my-data')) || [];
    for(var i=0; i < current.length; i++) {
        if(data == current[i]) {
            return true;
        }
    }
    return false;
}

/* === Runing App === */
$(function() {
    router.run();

    // enable :active in mobile safari
    document.addEventListener("touchstart", function(){}, true);

    // Custome editor event to handle save button state
    $(".editable-title, .editable-body").keyup(function() {
        var title = app.titleEditor.serialize()['element-0'].value;
        title = title.replace(/(<([^>]+)>)/ig,"").trim();
        var body = app.bodyEditor.serialize()['element-0'].value;
        body = body.replace(/(<([^>]+)>)/ig,"").trim();

        if(title == "" || body == "") {
            app.blankEditor = true;
            app.updateUIState(app.state);
        } else {
            app.editorSaved = false;
            app.blankEditor = false;
            app.updateUIState(app.state);
        }
    });
});
