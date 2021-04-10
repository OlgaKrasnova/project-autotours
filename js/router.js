ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
            center: [55.5555, 20.2020],
            zoom: 4
        });
        
    ymaps.route(cities).then(function (route) {
        myMap.geoObjects.add(route);
        
    }, function (error) {
        alert('Возникла ошибка: ' + error.message);
    });
}