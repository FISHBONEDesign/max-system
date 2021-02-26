$('select.select2').map((index, item) => {
    $(item).select2({
        tags: item.classList.contains('tags')
    });
});
