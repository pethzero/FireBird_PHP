class DataProcessor {
    constructor() { }
    process(data, idProperty, titleProperty, textProperty) {
        const itemzero = [{
            id: 0,
            value: "0",
            text: 'เลือก',
            title: ""
        }];
        const matchData = data.map((item) => {
            return {
                id: item[idProperty],
                value: item[idProperty],
                text: item[textProperty],
                title: item[titleProperty]
            };
        });
        const combinedData = itemzero.concat(matchData);
        return combinedData;
    }

    process_new(data, idProperty, titleProperty, textProperty) {
        const itemzero = [{
            id: 0,
            value: "0",
            text: 'เลือก',
            title: ""
        }];
        const matchData = data.map((item) => {
            return {
                id: parseInt(item[idProperty]),
                // value: String(item[idProperty]),
                value: String(item[idProperty]),
                text: item[textProperty],
                title: item[titleProperty]
            };
        });
        const combinedData = itemzero.concat(matchData);
        // console.log(combinedData)
        return combinedData;
    }
}


class Select2Creator {
    constructor() { }
    matchCustomAjax(params, data) {
        if ($.trim(params.term) === '') {
            return data;
        }
        var inputText = params.term.toLowerCase().replace(/\s/g, '');
        var optionText = data.text.toLowerCase().replace(/\s/g, '');
        var optionTitle = data.title.toLowerCase().replace(/\s/g, '');

        if (typeof data.value === 'string') {
            var optionValue = data.value.toLowerCase().replace(/\s/g, '');
            if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
                return data;
            }
        } else {
            if (optionText.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
                return data;
            }
        }
        return null;
    }

    matchCustomAjaxNew(params, data) {
        if ($.trim(params.term) === '') {
            return data;
        }
        var inputText = params.term.toLowerCase().replace(/\s/g, '');

        var optionText;
        if (data.text) {
            optionText = data.text.toLowerCase().replace(/\s/g, '');
        } else {
            optionText = '';
        }

        var optionTitle;
        if (data.title) {
            optionTitle = data.title.toLowerCase().replace(/\s/g, '');
        } else {
            optionTitle = ''; // หรือค่าอื่น ๆ ที่คุณต้องการกำหนด
        }

        if (typeof data.value === 'string') {
            var optionValue = data.value.toLowerCase().replace(/\s/g, '');
            if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
                return data;
            }
        } else {
            if (optionText.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
                return data;
            }
        }
        return null;
    }


    createSelect2(selector, data, text_select, myModal) {
        const select2Options = {
            data: data,
            theme: 'bootstrap-5',
            matcher: this.matchCustomAjax,
            templateSelection: (selected) => {
                if (selected.id !== '') {
                    if (selected.id == 0) {
                        return text_select;
                    }
                    return selected.text;
                }
                return '';
            },
            templateResult: (result) => {
                if (!result.id) {
                    return result.text;
                }
                var $result = $('<span></span>');
                $result.text("รหัส" + result.title + ":" + result.text);
                if (result.id == 0) {
                    $result.text(text_select);
                    return $result;
                } else {
                    return $result;
                }
            }
        };

        // เพิ่มเงื่อนไขตรวจสอบว่ามี #myModal หรือไม่
        if (myModal) {
            select2Options.dropdownParent = $('#myModal  .modal-content');
        }
        return $(selector).select2(select2Options);
    }

    SL2matchSearch(params, data, additionalCondition) {
        if ($.trim(params.term) === '') {
            return data;
        }
        var inputText = params.term.toLowerCase().replace(/\s/g, '');

        var optionText = (data.text || '').toLowerCase().replace(/\s/g, '');
        var optionTitle = (data.title || '').toLowerCase().replace(/\s/g, '');
        var optionValue = (data.value || '').toLowerCase().replace(/\s/g, '');

        var isMatch = optionText.includes(inputText) ||
            optionTitle.includes(inputText) ||
            optionValue.includes(inputText);

        // if (additionalCondition) {
        //     console.log('Testเงื่อนไข')
        // }else{
        //     console.log('ไม่Testเงื่อนไข')
        // }
        return isMatch ? data : null;
    }


    CreateSLC2(selector, data, text_select, head_text, myModal) {
        const select2Options = {
            data: data,
            theme: 'bootstrap-5',
            // matcher: this.SL2matchSearch,
            matcher: (params, data) => this.SL2matchSearch(params, data, false),
            templateSelection: (selected) => {
                if (selected.id !== '') {
                    if (selected.id == 0) {
                        return text_select;
                    }
                    return selected.text;
                }
                return '';
            },
            templateResult: (result) => {
                if (!result.id) {
                    return result.text;
                }
                var $result = $('<span></span>');
                $result.text(head_text + result.title + ":" + result.text);
                if (result.id == 0) {
                    $result.text(text_select);
                    return $result;
                } else {
                    return $result;
                }
            }
        };

        // เพิ่มเงื่อนไขตรวจสอบว่ามี #myModal หรือไม่
        if (myModal) {
            select2Options.dropdownParent = $('#myModal  .modal-content');
        }

        return $(selector).select2(select2Options);
    }
}