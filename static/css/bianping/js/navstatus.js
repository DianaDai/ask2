
/*更改导航按钮状态 val是导航栏内容*/
function nav_status(val) {
    $('.app-download-btn').each(function () {
        if ($(this).text() == val) {
            $('ul li.active').removeClass('active');
            $(this).parent().addClass('active');
            return false;

        }
    });

}