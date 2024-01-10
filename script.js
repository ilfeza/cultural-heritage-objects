ymaps.ready(init);

function init() {
    var map = new ymaps.Map('map-test', {
        center: [55.755863, 37.617700],
        zoom: 4
    });

    var objectManager = new ymaps.ObjectManager({
        clusterize: true,
        gridSize: 200,
        clusterDisableClickZoom: true,
        geoObjectOpenBalloonOnClick: true,
        clusterOpenBalloonOnClick: true,
        clusterBalloonContentLayout: 'cluster#balloonCarousel',
        clusterBalloonPanelMaxMapArea: 0
    });

    map.geoObjects.add(objectManager);

    fetch('get_coordinates.php')
        .then(response => response.json())
        .then(data => {
            // Добавляем объекты в objectManager
            objectManager.add(data, 'object');

            // Добавление обработчика клика для открытия балуна
           // ... (ваш предыдущий JavaScript код)

    objectManager.objects.events.add('click', function (e) {
        var objectId = e.get('objectId');
        var object = objectManager.objects.getById(objectId);
        objectManager.clusters.state.set('activeObject', object);

        if (object && object.properties.img) {
            var balloonContent = '<div><h3>' + object.properties.balloonContentHeader + '</h3>';
            balloonContent += '<p>Адрес: ' + object.properties.balloonContentBody + '</p>';
            balloonContent += '<img src="' + object.properties.img.url + '" alt="' + object.properties.img.title + '"></div>';

            objectManager.objects.balloon.open(objectId, balloonContent);
        } else {
            console.error('Object or img property not found');
        }
    });

// ... (остальной код)

        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}