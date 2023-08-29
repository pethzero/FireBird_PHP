jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "extract-date-pre": function(value) {
        var date = $(value, 'span')[0].innerHTML;
        date = date.split('/');
        return Date.parse(date[1] + '/' + date[0] + '/' + date[2])
    },
    "extract-date-asc": function(a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "extract-date-desc": function(a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});