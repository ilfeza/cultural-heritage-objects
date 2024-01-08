ymaps.ready(init);

function init() {
    var map = new ymaps.Map('map-test', {
        center: [55.755863, 37.617700],
        zoom: 10
    });

    var objectManager = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 32,
        clusterDisableClickZoom: true
    });

    map.geoObjects.add(objectManager);


    fetch('get_coordinates.php')
        .then(response => response.json())
        .then(data => {
            objectManager.add(data);
        })
        .catch(error => {
            console.error('Ошибка получения данных:', error);
        });

  
}
