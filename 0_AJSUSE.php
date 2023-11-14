function ProcesssMatchData(data) {
    const target_list = [{
        "id": 0,
        "text": 'เลือก',
        "value": "0",
        "title": ""
    }];
    const mappedData = data.map((item) => {
        return {
            id: item.RECNO,
            value: item.RECNO,
            text: item.EMPNO,
            title: item.EMPNAME
        };
    });
    const combinedData = target_list.concat(mappedData);
    return combinedData;
}