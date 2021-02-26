let init_select2 = (event) => {
    $('select.select2').map((index, item) => {
        console.log(event, item, getComputedStyle(item).width);
        $(item).select2({
            closeOnSelect: item.getAttribute('multiple') === "",
            tags: item.classList.contains('tags')
        });
    });
};

$(document).on('DOMContentLoaded load ready turbolinks:load', init_select2);
