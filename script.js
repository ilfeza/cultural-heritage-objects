ymaps.ready(init);

function init() {
    var map = new ymaps.Map('map-test', {
        center: [55.755863, 37.617700],
        zoom: 10
    });
    map.controls.remove('searchControl'); // удаляем поиск
    map.controls.remove('trafficControl'); // удаляем контроль трафика
    map.controls.remove('typeSelector'); // удаляем тип
    map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
    map.controls.remove('zoomControl'); // удаляем контрол зуммирования
    map.controls.remove('rulerControl'); // удаляем контрол правил
    map.controls.remove('geolocationControl'); // удаляем геолокац

    var clusterer = new ymaps.Clusterer({
        clusterize: true,
        gridSize: 200,
        clusterDisableClickZoom: true,
        clusterBalloonContentLayout: 'cluster#balloonCarousel',
        clusterBalloonPanelMaxMapArea: 0,
        clusterIcons: [
            {
                href: 'images/marker.svg',
                size: [40, 40],
                offset: [-20, -20]
            },
            {
                href: 'images/marker.svg',
                size: [60, 60],
                offset: [-30, -30]
            }],
            clusterIconContentLayout: null
        
    });

    map.geoObjects.add(clusterer);

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
                        balloonContentBody: balloonContent,
                        iconLayout: 'default#image',
                        iconImageHref: 'images/marker.svg',
                        iconImageSize: [40, 40],
                        iconImageOffset: [-19, -44]
                    });

                    placemark.events.add('click', function (e) {
                        map.balloon.open(placemark.geometry.getCoordinates(), placemark.properties.get('balloonContentBody'));
                    });

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
