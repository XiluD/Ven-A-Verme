import React, { useState } from "react";
import useFetch from "./useFetch";
import { useParams } from "react-router";
import styles from './styles/mainWindowStyle.module.css';
import CardsContainer from "./CardsContainer";
import ModalWindow from "./ModalWindow";
import Map from "./Map";
import credentials from './credentials';

const MainWindow = () => {
    const { provincia, municipio, purpose } = useParams();
    const { data: munBasic, isPending: isPendingMunBasic, error: errorMunBasic } = useFetch('http://127.0.0.1:8000/api/munBasicOf/' + municipio);
    const api_token = "28uE4Cz64VWJtqA8VDJyZqZdAjSzSqUUGKvFAcsFfE8DtTsMfhWRmRX0gzLEYCjRI8IsC9Wn7SLybtG3";
    const purposeContentEndPoint = (purpose === 'vacations') ? 'http://127.0.0.1:8000/api/trip/' + provincia + '/' + municipio + '?api_token=' + api_token :
        (purpose === 'rentSale') ? 'http://127.0.0.1:8000/api/idea/' + provincia + '/' + municipio + '?api_token=' + api_token : history.push('/');
    
    const CurrentDate = () => {
        let meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        let diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
        var f=new Date();
        return (
            <h2>{diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()]}</h2>
        );
    }

    const mapURL = `https://maps.googleapis.com/maps/api/js?v=3.exp&key=${credentials.mapsKey}`

    const { data: purposeContent, isPending: isPendingPurposeContent, error: errorPurposeContent } = useFetch(purposeContentEndPoint);
    const [isClicked, setIsClicked] = useState(false);
    const [cardLink, setCardLink] = useState(null);

    const handleCardClick = (cardLinkParam) => {
        setCardLink(cardLinkParam);
        setIsClicked(!isClicked);
    }
    const handleModalExit = () => {
        setIsClicked(!isClicked);
    }

    const MainContainer = ({ purposeContentType }) => {
        if (purposeContentType.queVisitar) {
            return (
                <div className={styles.mainInfoSection}>
                    {purposeContentType.queVisitar.length > 0 && <CardsContainer containerTypeContent={purposeContentType.queVisitar} title="Que visitar" handleCardClick={handleCardClick} />}
                    {purposeContentType.dondeComer.length > 0 && <CardsContainer containerTypeContent={purposeContentType.dondeComer} title="Donde comer" handleCardClick={handleCardClick} />}
                    {purposeContentType.alojamiento.length > 0 && <CardsContainer containerTypeContent={purposeContentType.alojamiento} title="Alojamiento" handleCardClick={handleCardClick} />}
                    {purposeContentType.otros.length > 0 && <CardsContainer containerTypeContent={purposeContentType.otros} title="Sigue el entretenimiento en" handleCardClick={handleCardClick} />}
                </div>
            );
        }
        else if (purposeContentType.onRent || purposeContentType.onSale) {
            return (
                <div className={styles.mainInfoSection}>
                    {purposeContentType.onSale.length > 0 && <CardsContainer containerTypeContent={purposeContentType.onSale} title="Casas en venta" handleCardClick={handleCardClick} />}
                    {purposeContentType.onRent.length > 0 && <CardsContainer containerTypeContent={purposeContentType.onRent} title="Casas en alquiler" handleCardClick={handleCardClick} />}
                </div>
            );
        }
    };

    /*
    const simWeather = [
        { value: 'Miercoles ⛅ 22ºC' },
        { value: 'Jueves ☀️ 23ºC' },
        { value: 'Viernes ☀️ 30ºC' },
        { value: 'Sabado ⛅ 22ºC' },
        { value: 'Domingo ⛅ 19ºC' },
        { value: 'Lunes ⛅ 20ºC' },
        { value: 'Martes ☀️ 25ºC' }
    ];*/

    return (
        <div className={styles.mainWindowContainer}>
            {isClicked && cardLink && <ModalWindow cardLink = {cardLink} handleModalExit = {handleModalExit}/>}
            <div className={styles.headInfoSection}>
                {errorMunBasic && (<div>{errorMunBasic}</div>)}
                {munBasic && (<div className={styles.headLeftSection}>
                    <div className={styles.headLeftSectionInfoContainer}>
                        <h1>{munBasic.municipio}, {munBasic.provincia}</h1>
                        <p>{munBasic.poblacion} habitantes</p>
                        <p>{(munBasic.despoblacion === 1) ? 'Municipio de la España Vaciada' : ''}</p>
                    </div>
                </div>)}
                <div className={styles.headRigthSection}>
                    <div className={styles.headRigthSectionLeftPanel}>
                        <CurrentDate/>
                        <h3>14ºC ☁ </h3>
                        <p>Poco nuboso</p>
                        {/*munBasic && <Weather 
                            position={{
                                latitud: munBasic.cLatitud,
                                longitud: munBasic.cLongitud,
                        }}/>*/}
                    </div>
                    <iframe id="iframe_aemet_id33024" className={styles.weatherFrame} name="iframe_aemet_id33024" src="https://www.aemet.es/es/eltiempo/prediccion/municipios/mostrarwidget/gijon-gijon-xixon-id33024" width="100%" height="190" frameBorder="0" scrolling="no"></iframe>
                    {/*<div className={styles.headRigthSectionRightPanel}>
                        {simWeather.map(day => (
                            <h4 key={day.value}>{day.value}</h4>
                        ))}
                    </div>*/}
                </div>
            </div>
            {isPendingPurposeContent && <div className={styles.loaderPending}></div>}
            {errorPurposeContent && <div>{errorPurposeContent}</div>}
            {purposeContent && !purposeContent.closestPlace && <MainContainer purposeContentType={purposeContent} />}
            {purposeContent && purposeContent.closestPlace && <div className={styles.mainInfoSection} style={{textAlign:'center', marginTop:'1%'}}>
                <p>Lo sentimos, pero no hemos podido encontrar informacion para tu proposito a cerca de {municipio} en la provincia de {provincia}.</p>
                <p>Pero no te preocupes, el municipio más cercano a {municipio} es {purposeContent.closestPlaceMun}, en la provincia de {purposeContent.closestPlaceProv}.</p>
                <p>Por lo que, aqui te dejamos un poco de informacion de {purposeContent.closestPlaceMun}. Pasa buenas aventuras, viajero!</p>
                </div>}
            {purposeContent && purposeContent.closestPlace && <MainContainer purposeContentType={purposeContent.data} />}

            <div className={styles.footerInfoSection}>
                <h1 className={styles.footerTitle}>Ubicación de {municipio} ({provincia}), en Google Maps:</h1>
                <div className={styles.footerInfoSectionContainer}>
                    {munBasic && 
                    <Map 
                        googleMapURL={mapURL}
                        position = {{
                            latitud: munBasic.cLatitud,
                            longitud: munBasic.cLongitud,
                        }}
                        isMarkerShown
                        containerElement={<div style={{height: '80vh'}} />}
                        mapElement={<div style={{height: '100%'}}/>}
                        loadingElement={<p>Cargando...</p>}
                    />}
                </div>
            </div>
        </div>
    );
}

export default MainWindow;