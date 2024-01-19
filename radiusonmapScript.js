var myMap;
var circle;

ymaps.ready(init);

function init() {
   
    var latitude = parseFloat(localStorage.getItem("latitude"));
    var longitude = parseFloat(localStorage.getItem("longitude"));
    var radius = parseFloat(localStorage.getItem("radius"));
    console.log('Latitude:', latitude);
    console.log('Longitude:', longitude);
    console.log('Radius:', radius);
    if(radius>1){
        radius*=13;
    }
    else{
        radius*=13*4;
    }

   

  

    var map = new ymaps.Map('map-test', {
        center: [latitude, longitude],
        zoom: radius,
    });



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
            }
        ],
        clusterIconContentLayout: null
    });

    map.geoObjects.add(clusterer);

    var clickListener = null;

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
                    balloonContent += '</div>';

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
