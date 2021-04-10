$('td.edit').click(function(){
    //находим input внутри элемента с классом ajax и вставляем вместо input его значение
    $('.ajax').html($('.ajax input').val());
    //удаляем все классы ajax
    $('.ajax').removeClass('ajax');
    //Нажатой ячейке присваиваем класс ajax
    $(this).addClass('ajax');
    //внутри ячейки создаём input и вставляем текст из ячейки в него
    $(this).html('<input id="editbox" size="'+ $(this).text().length+'" type="text" value="' + $(this).text() + '" />');
    //устанавливаем фокус на созданном элементе
    $('#editbox').focus();
    });

    //определяем нажатие кнопки на клавиатуре
$('td.edit').keydown(function(event){
    //получаем значение класса и разбиваем на массив
    //в итоге получаем такой массив — arr[0] = edit, arr[1] = наименование столбца, arr[2] = id строки
    arr = $(this).attr('class').split( " " );
    //проверяем какая была нажата клавиша и если была нажата клавиша Enter (код 13)
    if(event.which == 13)
    {
    //получаем наименование таблицы, в которую будем вносить изменения
    var table = $('table').attr('id');
    //выполняем ajax запрос методом POST
    $.ajax({ type: "POST",
    //в файл update_cell.php
    url:"update_cell.php",
    //создаём строку для отправки запроса
    //value = введенное значение
    //id = номер строки
    //field = название столбца
    //table = собственно название таблицы
    data: "value="+$('.ajax input').val()+"&id="+arr[2]+"&field="+arr[1]+"&table="+table,
    //при удачном выполнении скрипта, производим действия
    success: function(data){
    //находим input внутри элемента с классом ajax и вставляем вместо input его значение
    $('.ajax').html($('.ajax input').val());
    //удаялем класс ajax
    $('.ajax').removeClass('ajax');
    }});
    }});

    $('#editbox').live('blur',function(){
        $('.ajax').html($('.ajax input').val());
        $('.ajax').removeClass('ajax');
        });