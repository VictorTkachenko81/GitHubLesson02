/**
 * Created by victor on 14.10.15.
 */

$(".valueblock").dblclick(function () {
    var valueData = $(this).text();
    $(this).hide();
    $(this).parent().children("input").show();
    //alert( valueData );
});

$("input").keydown(function (event) {
    if (event.which == 13) {
        event.preventDefault();
        $(this).parent().children(".valueblock").show().text($(this).val());
        $(this).parent().children("input").hide();
        var level = 100 - $(this).val();
        $(this).parent().parent().children(".levelblock").children(".level").css("height", level + "%");
    }
});
