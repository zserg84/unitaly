<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 23.06.15
 * Time: 13:21
 */
use yii\bootstrap\Modal;
use modules\themes\Module as ThemeModule;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Helper\Places\AutocompleteHelper;
use yii\bootstrap\Html;

$mapHelper = new MapHelper();
$autocompleteHelper = new AutocompleteHelper();

echo Html::button(
    Yii::t('html', ThemeModule::t('themes-admin', 'POINT_ON_MAP')),
    [
        'id' => 'modalButton'
    ]);
Modal::begin([
    'id' => 'map-modal',
    'footer' => Html::button(
        'Сохр',
        [
            'class' => 'btn btn-primary btn-large map-ok'
        ]
    ),
    'size' => Modal::SIZE_LARGE
]);

?>
    <div id="panel" class="row">
        <div class="col-sm-8">
            <div class="form-group field-cafeform-translationname-1 has-success">
                <?= $autocompleteHelper->renderHtmlContainer($autocomplete);?>
                <input type="button" value="Geocode" onclick="codeAddress()">
            </div>
        </div>
    </div>
<?
echo $mapHelper->renderHtmlContainer($map);
echo $mapHelper->renderJavascripts($map);
echo $mapHelper->renderStylesheets($map);

echo $autocompleteHelper->renderJavascripts($autocomplete);
Modal::end();

$this->registerJS("
    $('#modalButton').click(function (){
        $('#map-modal').modal('show');
        resizeMap();
    });

    $('.map-ok').click(function(){
        if(markers['userMarker'] != undefined){
            var marker = markers['userMarker'];
            var latitude = marker.position.A;
            var longitude = marker.position.F;
            $('#".$id_latitude."').val(latitude);
            $('#".$id_longitude."').val(longitude);
        }
        $('#map-modal').modal('hide');
    });

    function resizeMap() {
       setTimeout( function(){resizingMap();} , 200);
    }

    function resizingMap() {
        var map = ".$map->getJavascriptVariable().";
        if(typeof map =='undefined') return;
        var center = map.getCenter();
        google.maps.event.trigger(map, 'resize');
        map.setCenter(center);
    }

    function codeAddress(){
        var map = ".$map->getJavascriptVariable().";

        var geocoder = new google.maps.Geocoder();
        var address = document.getElementById('place_input').value;
        geocoder.geocode({'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addMarker(map, results[0].geometry.location);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });

    }
", \yii\web\View::POS_END);