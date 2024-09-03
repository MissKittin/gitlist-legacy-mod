$(function () {
    $('.dropdown-toggle').dropdown();

    if ($('#sourcecode').length) {
        var value = $('#sourcecode').text();
        var mode = $('#sourcecode').attr('language');
        var pre = $('#sourcecode').get(0);
        var viewer = CodeMirror(function(elt) {
            pre.parentNode.replaceChild(elt, pre);
        }, {
            value: value,
            lineNumbers: true,
            matchBrackets: true,
            lineWrapping: true,
            readOnly: true,
            mode: mode,
            lineNumberFormatter: function(ln) {
                return '<a name="L'+ ln +'"></a><a href="#L'+ ln +'">'+ ln +'</a>';
            }
        });

        document.getElementsByClassName('source-header')[0].children[1].innerHTML += '<a href="#" class="btn btn-default btn-sm"><span class="fa fa-list"></span> Expand source</a>';
        document.getElementsByClassName('source-header')[0].children[1].children[4].addEventListener('click', function() {
            viewer.execCommand('goDocEnd');
        }, false);
    }

    if ($('#md-content').length) {
        var converter = new showdown.Converter({
            tables: true,
            strikethrough: true,
            ghCompatibleHeaderId: true
        });
        $('#md-content').html(converter.makeHtml($('#md-content').text()));
    }

    var clonePopup = $('#clone-popup')
    var cloneButtonShow = $('#clone-button-show');
    var cloneButtonHide = $('#clone-button-hide');
    var cloneButtonSSH = $('#clone-button-ssh');
    var cloneButtonHTTP = $('#clone-button-http');
    var cloneInputSSH = $('#clone-input-ssh');
    var cloneInputHTTP = $('#clone-input-http');

    cloneButtonShow.click(function()
    {
        clonePopup.fadeIn();
    });

    cloneButtonHide.click(function()
    {
        clonePopup.fadeOut();
    });

    cloneButtonSSH.click(function()
    {
        if(cloneButtonSSH.hasClass('active'))
            return;

        cloneButtonSSH.addClass('active');
        cloneInputSSH.show();

        cloneButtonHTTP.removeClass('active');
        cloneInputHTTP.hide();
    });

    cloneButtonHTTP.click(function()
    {
        if(cloneButtonHTTP.hasClass('active'))
            return;

        cloneButtonHTTP.addClass('active');
        cloneInputHTTP.show();

        cloneButtonSSH.removeClass('active');
        cloneInputSSH.hide();
    });

    function paginate() {
        var $pager = $('.pager');

        $pager.find('.next a').one('click', function (e) {
            e.preventDefault();
            $.get(this.href, function (html) {
                $pager.after(html);
                $pager.remove();
                paginate();
            });
        });

        $pager.find('.previous').remove();
    }
    paginate();
});
