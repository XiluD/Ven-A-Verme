import React from 'react';
import styles from './styles/mainWindowStyle.module.css';
import Splide from '@splidejs/react-splide/dist/js/components/Splide';
import SplideSlide from '@splidejs/react-splide/dist/js/components/SplideSlide';
import '@splidejs/splide/dist/css/themes/splide-default.min.css';
import useFetch from "./useFetch";

const ModalWindow = ({ cardLink, handleModalExit }) => {
    const api_token = "28uE4Cz64VWJtqA8VDJyZqZdAjSzSqUUGKvFAcsFfE8DtTsMfhWRmRX0gzLEYCjRI8IsC9Wn7SLybtG3";

    let cardContentEndPoint = null;

    if (cardLink.startsWith('/Attraction_Review') || cardLink.startsWith('/Hotel_Review') ||
        cardLink.startsWith('/Restaurant_Review') || cardLink.startsWith('/VacationRentalReview')) {
        cardContentEndPoint = 'http://127.0.0.1:8000/api/tripCard?cardLink=' + cardLink + '&api_token=' + api_token;
    }
    else {
        cardContentEndPoint = 'http://127.0.0.1:8000/api/ideaCard?cardLink=' + cardLink + '&api_token=' + api_token;
    }

    const { data: cardContent, isPending: isPendingCardContent, error: errorCardContent } = useFetch(cardContentEndPoint);

    const handleClickRedirect = (cardLink) => {
        if (cardLink.startsWith('/Attraction_Review') || cardLink.startsWith('/Hotel_Review') ||
            cardLink.startsWith('/Restaurant_Review') || cardLink.startsWith('/VacationRentalReview')) {
            window.open('https://www.tripadvisor.es' + cardLink, '_blank');
        }
        else {
            window.open(cardLink, '_blank');
        }
    };

    const handleSentimentResultText = (sentiment) => {
        if (sentiment === 'muyRecomendado') {
            return "Muy recomendado por los usuarios";
        }
        else if (sentiment === 'recomendado') {
            return "Recomendado por los usuarios";
        }
        else if (sentiment === 'valoracionesVariadas') {
            return "Valoraciones variadas de los usuarios";
        }
        else {
            return "Poco recomendado por los usuarios";
        }
    }

    const IdealistaFeaturesTable = ({cardContent}) => {
        return (
            <table>
                <thead>
                    <tr>
                        {cardContent.innerCardFeatures.basic.length>0 && <th>Mobiliario básico</th>}
                        {cardContent.innerCardFeatures.building.length>0 && <th>Características del edificio</th>}
                        {cardContent.innerCardFeatures.equipment.length>0 && <th>Equipamiento</th>}
                    </tr>
                </thead>
                <tbody>
                    {cardContent.innerCardFeatures.basic && cardContent.innerCardFeatures.basic.map((feature, index) => {
                        return index < 8 ? (
                            <tr key = {index.toString()}>
                                <td>{feature}</td>
                                <td>{cardContent.innerCardFeatures.building[index]}</td>
                                <td>{cardContent.innerCardFeatures.equipment[index]}</td>
                            </tr>
                        ): null;
                    })}
                </tbody>
            </table>
        );
    }

    console.log(cardContent);

    return (
        <div className={styles.modal} onClick={handleModalExit}>
            {isPendingCardContent && <h1 className={styles.waitingAlert}>LOADING, PLEASE WAIT...</h1>}
            {errorCardContent && { errorCardContent }}
            {cardContent && cardContent.ratingSentimentPoints && (
                <div className={styles.modalContent} onClick={(e) => e.stopPropagation()}>
                    <span className={styles.close} onClick={handleModalExit}>&times;</span>
                    <div className={styles.infoContainer}>
                        <h1>{cardContent.innerCardTitle}</h1>
                        <h2>{cardContent.innerCardAddress}</h2>
                        <h3>Nota media en TripAdvisor: {cardContent.ratingSentimentPoints.toFixed(2)} sobre 10.</h3>
                        <h3>Valoración de análisis de sentimiento: {handleSentimentResultText(cardContent.ratingSentimentFeed)}.</h3>
                        <div className = {styles.cardButtonContainer} style={{marginTop:'3.5%'}}>
                            <button className={styles.cardButton} onClick={() => handleClickRedirect(cardContent.cardLink)}>Saber más</button>
                        </div>
                    </div>
                    {cardContent.cardImages.length === 0 && <div className={styles.noImagesFound}>No images found</div>}
                    {cardContent.cardImages.length > 0
                        &&
                        <Splide
                            options={{
                                width: '90%',
                                perPage: 2,
                                perMove: 2,
                                focus: 'center',
                                pagination: false,
                                lazyLoad: 'nearby',
                                cover: true,
                                arrows: 'slider',
                                breakpoints: {
                                    1600: {
                                        perPage: 1,
                                        perMove: 1,
                                        gap: '1vw',
                                        padding: {
                                            left : '4.5rem',
                                            right: 0,
                                        },
                                    },
                                }
                            }}
                            className='splideContainerModal'
                        >
                            {cardContent.cardImages.map(image => (
                                <SplideSlide key={image} className={styles.cardContentImageContainer}>
                                    <div>
                                        <img src={image} alt={image} className={styles.cardContentImage} />
                                    </div>
                                </SplideSlide>
                            )
                            )
                            }
                        </Splide>}

                </div>
            )}

            {cardContent && cardContent.innerCardPrice && (
                <div className={styles.modalContent} style={{width:'75%'}} onClick={(e) => e.stopPropagation()}>
                    <span className={styles.close} onClick={handleModalExit}>&times;</span>
                    <div className={styles.infoContainer}>
                        <h1>{cardContent.innerCardTitle} - {cardContent.innerCardPlace}</h1>
                        <h2>{cardContent.innerCardPrice}</h2>

                        <div className={styles.ideaCardInfoTablesContainer}>
                            <div className={styles.ideaCardInfoTablesContainerLeft}>
                                <p>{cardContent.innerCardDetail}.</p>
                                <br/>
                                <p>{cardContent.innerCardDescription}</p>
                                <br/>
                                <p>Telefono de contacto: {cardContent.innerCardContact}</p>
                            </div>
                            <div className={styles.ideaCardInfoTablesContainerRight}>
                             <IdealistaFeaturesTable cardContent = {cardContent}/>
                            </div>

                        </div>
                        <div className = {styles.cardButtonContainer}>
                            <button className={styles.cardButton} onClick={() => handleClickRedirect(cardContent.cardLink)}>Saber más</button>
                        </div>
                    </div>
                    {cardContent.cardImages.length === 0 && <div className={styles.noImagesFound}>No images found</div>}
                    {cardContent.cardImages.length > 0
                        &&
                        <Splide
                            options={{
                                width: '90%',
                                perPage: 2,
                                perMove: 2,
                                focus: 'center',
                                pagination: false,
                                lazyLoad: 'nearby',
                                cover: true,
                                arrows: 'slider',
                            }}
                            className='splideContainerModal2'
                        >
                            {cardContent.cardImages.map(image => (
                                <SplideSlide key={image} className={styles.cardContentImageContainer2}>
                                    <div>
                                        <img src={image} alt={image} className={styles.cardContentImage2} />
                                    </div>
                                </SplideSlide>
                            )
                            )
                            }
                        </Splide>}

                </div>
            )}


        </div>
    );
}

export default ModalWindow;