var optionsChosen = {allow_single_deselect: true, width: '100%', placeholder_text_multiple: messages[0], placeholder_text_single: messages[0], no_results_text: messages[6], search_contains: true};
$(function () {
    $.oPageLoader({progressBarColor: '#337AB7'});
    $('.bootstrap-widget-content img').oLoader({
        waitLoad: true,
        fadeLevel: 0.9,
        backgroundColor: '#fff',
        style: 0,
        image: pathurl + '/js/oLoader/images/ownageLoader/loader5.gif'
    });
    toastr.options = {fadeIn: 300, newestOnTop: true, preventDuplicates: true, progressBar: true, fadeOut: 1000, timeOut: 5000, extendedTimeOut: 1000, positionClass: "toast-top-right", closeButton: true};
    $.fn.chosenDestroy = function () {
        $(this).show().removeClass('chzn-done');
        $(this).next().remove();
        return $(this);
    };
    if($("select").length > 0){
        $(".Ccombo, select").attr("data-placeholder", messages[0]);
        $(".Ccombo, select").chosen(optionsChosen);
        $(".Ccombo, select").show().addClass("hidden-field");
    }
    var link = window.location.pathname;
    $(".menu-left a").each(function () {
        if (link.indexOf($(this).attr("menu")) !== -1) {
            $(this).parent().addClass("active");
        }
    });
    $(".menu-barra a").each(function () {
        if (link.indexOf($(this).attr("menu")) !== -1) {
            $(this).parent().addClass("active");
        }
    });
    $("#busquedad_menu").change(function () {
        if ($(this).val() !== "") {
            window.location = pathurl + $(this).val();
        }
    });
    $("input[type=text], textarea").each(function () {
        var max = $(this).attr("maxlength");
        if (max !== undefined) {
            var obj = $(this).parent().find("label");
            $(this).parent().find("label").html($(obj).html() + " (" + messages[5] + " " + max + " )");
        }
    });
    sortTable();
});
function loading(obj) {
    var image = pathurl + 'img/preloader.gif';
    if (obj != undefined) {
        $(obj).oLoader({
            image: image
        });
    } else {
        $('body').oLoader({
            image: image
        });
    }
}
function unloading(obj) {
    if (obj != undefined) {
        $(obj).oLoader('hide');
    } else {
        $('body').oLoader('hide');
    }
}
var fixHelper = function (e, ui) {
    ui.children().each(function () {
        $(this).width($(this).width());
    });
    return ui;
};
function sortTable() {
    if ($(".sort-table-update").length > 0) {
        $('.sort-table-update table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update: function (event, ui) {
                var parent = $(ui.item).parent().parent().parent();
                serial = $(ui.item).parent().sortable('serialize', {key: 'items[]', attribute: 'class'});
                serial += "&table=" + $(parent).attr("data-table") + "&field=" + $(parent).attr("data-field");
                $.ajax({
                    'url': pathurl + 'cms/dashboard/SortTables',
                    'type': 'post',
                    'data': serial,
                    'success': function (data) {

                    },
                    'error': function (request, status, error) {
                        console.log(error);
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    }
}
function reloadGrid(id) {
    if (id != undefined) {
        $("#" + id).find("select").chosenDestroy().chosen(optionsChosen);
    }
}