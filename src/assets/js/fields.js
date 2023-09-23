jQuery(function ($) {
    console.log('fields JS loaded');
    if ($(".tan-color-picker").length > 0) $(".tan-color-picker").wpColorPicker();
    if ($(".tan-select2").length > 0) $(".tan-select2").select2({ width: "100%" });
    if ($(".tan-chosen").length > 0) $(".tan-chosen").chosen({ width: "100%" });
    if (localStorage.getItem("active_tan_tab") == "undefined" || localStorage.getItem("active_tan_tab") == null || $(localStorage.getItem("active_tan_tab")).length <= 0) {
        localStorage.setItem("active_tan_tab", $(".tan-nav-tab:first-child a").attr("href"));
    }
    if (typeof localStorage != "undefined") {
        active_tan_tab = localStorage.getItem("active_tan_tab");
    }
    if (window.location.hash) {
        active_tan_tab = window.location.hash;
        if (typeof localStorage != "undefined") {
            localStorage.setItem("active_tan_tab", active_tan_tab);
        }
    }
    $(".tan-section").hide();
    $(".tan-nav-tab").removeClass("tan-active-tab");
    $('[href="' + localStorage.getItem("active_tan_tab") + '"]')
        .parent()
        .addClass("tan-active-tab");
    $(localStorage.getItem("active_tan_tab")).show();
    $(".tan-nav-tab").click(function (e) {
        e.preventDefault();
        $(".tan-section").hide();
        $(".tan-nav-tab").css("background", "inherit").removeClass("tan-active-tab");
        $(this).addClass("tan-active-tab").css("background", $(this).data("color"));
        $(".tan-nav-tab a").removeClass("tan-active-tab");
        $(".tan-nav-tab a").each(function (e) {
            $(this).css("color", $(this).parent().data("color"));
        });
        $("a", this).css("color", "#fff");
        var target = $("a", this).attr("href");
        $(target).show();
        localStorage.setItem("active_tan_tab", target);
    });
    $(".tan-form").submit(function (e) {
        e.preventDefault();
        if (typeof tinyMCE != "undefined") tinyMCE.triggerSave();
        var $form = $(this);
        var $submit = $(".tan-submit", $form);
        var $overlay = $('#tan-overlay');
        $submit.attr("disabled", !0);
        $(".tan-message", $form).hide();
        $overlay.show();
        $.ajax({
            url: ajaxurl,
            data: $form.serialize(),
            type: "POST",
            dataType: "JSON",
            success: function (ret) {
                if (ret.status == 1 || ret.status == 0) {
                    $(".tan-message p", $form).text(ret.message);
                    $(".tan-message", $form).show().fadeOut(3000);
                }
                $submit.attr("disabled", !1);
                if (ret.page_load == 1)
                    setTimeout(function () {
                        window.location.href = "";
                    }, 1000);
                $overlay.hide();
            },
            erorr: function (ret) {
                $submit.attr("disabled", !1);
                $overlay.hide();
            },
        });
    });
    $(".tan-reset-button").click(function (e) {
        var $this = $(this);
        var $option_name = $this.data("option_name");
        var $_nonce = $this.data("_nonce");
        $this.attr("disabled", !0);
        $("#tan-message-" + $option_name).hide();
        var $overlay = $('#tan-overlay');
        $overlay.show();
        $.ajax({
            url: ajaxurl,
            data: { action: "tan-reset", option_name: $option_name, _wpnonce: $_nonce },
            type: "POST",
            dataType: "JSON",
            success: function (ret) {
                $("#tan-message-" + $option_name + ' p').text(ret.message);
                $("#tan-message-" + $option_name).show();
                $overlay.hide();
                setTimeout(function () {
                    window.location.href = "";
                }, 1000);
            },
            erorr: function (ret) {
                $this.attr("disabled", !1);
                $overlay.hide();
            },
        });
    });
    $(".tan-browse").on("click", function (event) {
        event.preventDefault();
        var self = $(this);
        var parent = $(this).parent()
        var file_frame = (wp.media.frames.file_frame = wp.media({ title: self.data("title"), button: { text: self.data("select-text") }, multiple: !1 }));
        file_frame.on("select", function () {
            attachment = file_frame.state().get("selection").first().toJSON();
            $(".tan-file", parent).val(attachment.url);
            $(".supports-drag-drop").hide();
        });
        file_frame.open();
    });
    $("#tan-submit-top").click(function (e) {
        $(".tan-message").hide();
        $(".tan-form:visible").submit();
    });
    $("#tan-reset-top").click(function (e) {
        $(".tan-form:visible .tan-reset-button").click();
    });
    $('a[href="' + localStorage.active_tan_tab + '"]').click();

    $('.tan-tab').click(function(e){
        var target = $(this).data('target')
        var par = $(this).closest('.tan-field-wrap')
        $('.tan-tab-content',par).hide()
        $('.tan-tab',par).removeClass('tan-tab-active')
        $(this).addClass('tan-tab-active')
        $('#'+target).show()
    })

    $(document).on('click', '.tan-repeater-add', function(e){
        $(this).parent().before($(this).parent().clone()).find('input,select,textarea').val('')
    })

    $(document).on('click', '.tan-repeater-remove', function(e){
        if($('.tan-repeatable').length <= 1 ) return;
        $(this).closest('.tan-repeatable').remove()
    })
});