import React from 'react';
import { withScriptjs, GoogleMap, withGoogleMap, Marker } from "react-google-maps"

const Map = (props) => {
    return (
        <GoogleMap
            defaultZoom={15}
            defaultCenter={{ lat: props.position.latitud, lng: props.position.longitud }} 
        >
            {props.isMarkerShown && <Marker position={{ lat: props.position.latitud, lng: props.position.longitud }} />}
        </GoogleMap>
    );
}

export default withScriptjs(
    withGoogleMap(
        Map
    )
);