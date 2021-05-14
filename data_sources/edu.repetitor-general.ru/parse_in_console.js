shchoolList = [];
$('table.table-striped tr').each(function() {
    schoolObj = {};
    schoolObj.number = $( this ).find('td:nth-child(1)').text().trim();
    schoolObj.name = $( this ).find('td:nth-child(2) a').text().trim();
    schoolObj.address = 'Москва ' + $( this ).find('td:nth-child(3)').text().trim();
    if (schoolObj.number) {
        shchoolList.push(schoolObj);
    }
});
console.save(shchoolList);
