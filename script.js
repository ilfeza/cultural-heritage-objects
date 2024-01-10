ymaps.ready(init);

function init() {
    var map = new ymaps.Map('map-test', {
        center: [55.755863, 37.617700],
        zoom: 10
    });
    // Удаляем ненужные элементы управления с карты
    map.controls.remove('searchControl');
    map.controls.remove('trafficControl');
    map.controls.remove('typeSelector');
    map.controls.remove('fullscreenControl');
    map.controls.remove('zoomControl');
    map.controls.remove('rulerControl');
    map.controls.remove('geolocationControl');

    var clusterer = new ymaps.Clusterer({
        clusterize: true,
        gridSize: 200,
        clusterDisableClickZoom: true,
        clusterBalloonContentLayout: 'cluster#balloonCarousel',
        clusterBalloonPanelMaxMapArea: 0
    });

    map.geoObjects.add(clusterer);

    // Добавляем круг на карту
    var circle = new ymaps.Circle([[55.755863, 37.617700], 1000], null, { draggable: true });

    circle.events.add('drag', function () {
        clusterer.getClusters().forEach(function (cluster) {
            var clusterCoords = cluster.geometry.getCoordinates();
            if (circle.geometry.contains(clusterCoords)) {
                cluster.options.set('preset', 'islands#greenClusterIcons'); // Заменяем иконку для кластера внутри круга
            } else {
                cluster.options.set('preset', 'islands#blueClusterIcons'); // Используем обычную иконку для кластера вне круга
            }
        });
    });
    circle.events.add('drag', function () {
        // Объекты, попадающие в круг, будут становиться красными.
        var objectsInsideCircle = objects.searchInside(circle);
        objectsInsideCircle.setOptions('preset', 'islands#redIcon');
        // Оставшиеся объекты - синими.
        objects.remove(objectsInsideCircle).setOptions('preset', 'islands#blueIcon');
    });

    

    map.geoObjects.add(circle);

    fetch('get_coordinates.php')
    .then(response => response.json())
    .then(data => {
        var features = data.features;

        var promises = features.map(feature => {
            var coordinates = feature.geometry.coordinates.map(parseFloat);
            var properties = feature.properties;

            return new Promise((resolve, reject) => {
                var balloonContent = '<div class="balcont"><h3>' + properties.balloonContentHeader + '</h3>';
                balloonContent += '<p>Адрес: ' + properties.balloonContentBody + '</p>';
                balloonContent += '<img src="' + properties.img.url + '" alt="' + properties.img.title + '"></div>';

                var placemark = new ymaps.Placemark(coordinates, properties, {
                    balloonContentBody: balloonContent
                });

                placemark.events.add('click', function (e) {
                    map.balloon.open(placemark.geometry.getCoordinates(), placemark.properties.get('balloonContentBody'));
                });

                if (circle.geometry.contains(placemark.geometry.getCoordinates())) {
                    // Метка находится внутри круга
                    // Действия для метки внутри круга
                    placemark.options.set('preset', 'islands#greenIcon'); // Пример изменения стиля
                }

                resolve(placemark);
            });
        });

        Promise.all(promises)
            .then(geoObjects => {
                clusterer.add(geoObjects);
            })
            .catch(error => {
                console.error('Error creating placemarks:', error);
            });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

}