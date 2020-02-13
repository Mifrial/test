function GetV(s)
{
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getVal.php', false);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.send("val=" + s);

    if (xhr.status != 200) // если не 200 - ошибка
    {
        document.getElementById("LogMesPanel").innerHTML = "Просизошла ошибка " + xhr.status + ': ' + xhr.statusText;
    } else
    {
        return xhr.responseText;
    }
    return false;
}

function Cl()
{
    let dval = document.getElementById('IEdit1').value;
    dval = dval[8]+dval[9]+'/'+dval[5]+dval[6]+'/'+dval[0]+dval[1]+dval[2]+dval[3];
    if (dval === '') 
    {
        alert('В первом поле отсутствует дата');
        return 0;
    }

    let res1 = GetV(dval).replace(',', '.');
    document.getElementById('IL21').innerHTML = 'Курс евро: ' + res1;

    dval = document.getElementById('IEdit2').value;
    dval = dval[8]+dval[9]+'/'+dval[5]+dval[6]+'/'+dval[0]+dval[1]+dval[2]+dval[3];
    if (dval === '') 
    {
        alert('Во втором поле отсутствует дата');
        return 0;
    }
    let res2 = GetV(dval).replace(',', '.');
    document.getElementById('IL22').innerHTML = 'Курс евро: ' + res2;
    
    document.getElementById('IL23').innerHTML = 'Разница курса: ' + (parseFloat(res2) - parseFloat(res1)).toFixed(4);

    return 0;
}