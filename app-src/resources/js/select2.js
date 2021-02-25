$('select.select2').map((index, item) => {
    console.log(item.classList.contains('tags'));
    $(item).select2({
        tags: item.classList.contains('tags')
    });
});
