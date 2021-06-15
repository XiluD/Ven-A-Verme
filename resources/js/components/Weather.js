import React from "react";
import useFetch from "./useFetch";

const Weather = ({position}) => {
    console.log(position.latitud);
    console.log(position.longitud);

    const { data: munProvsWeather, isPending: isPendingmunProvsWeather, error: errormunProvsWeather } = useFetch('https://www.el-tiempo.net/api/json/v2/municipios');
    if (munProvsWeather){
        const placeInfo = munProvsWeather.filter((place) => place.LATITUD_ETRS89_REGCAN95 === position.latitud && place.LONGITUD_ETRS89_REGCAN95 === position.longitud);
        const codigoProv = placeInfo[0].CODPROV;
        const codigoGeo = placeInfo[0].COD_GEO;
        fetch(`https://www.el-tiempo.net/api/json/v2/provincias/${codigoProv}/municipios/${codigoGeo}`).then(response => {
            console.log('resolved', response);
            return response.json();
        }).then(data => {
            console.log(data);
        }).catch(err => {
            console.log('rejected', err);
        });
    }

    return (
        <p>Hello there!</p>
    );
}
 
export default Weather;