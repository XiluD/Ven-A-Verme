import React from 'react';
import Splide from '@splidejs/react-splide/dist/js/components/Splide';
import SplideSlide from '@splidejs/react-splide/dist/js/components/SplideSlide';
import '@splidejs/splide/dist/css/themes/splide-default.min.css';
import styles from './styles/mainWindowStyle.module.css';

const CardsContainer = ({ containerTypeContent, title, handleCardClick }) => {
    //console.log(containerTypeContent);
    return (
        <div className={styles.mainInfoSectionContainer}>
            <div className={styles.splideContainer}>
                <h1 className={styles.splideTitle}>{title}:</h1>
                {/*containerTypeContent.map(card => (
                    <div key={card.cardLink}>
                        <p>{card.cardLink}</p>
                        <p>{card.placeLink}</p>
                        <p>{card.cardTitle}</p>
                        <p>{card.cardSubtitle}</p>
                        <p>{card.cardImage}</p>
                    </div>
                ))*/}
                {/*containerTypeContent.map(card => (
                    <div key={card.cardLink}>
                        <p>{card.cardLink}</p>
                        <p>{card.placeLink}</p>
                        <p>{card.cardTitle}</p>
                        <p>{card.cardPrice}</p>
                        <p>{card.cardDetail}</p>
                        <p>{card.cardDescription}</p>
                        <p>{card.cardContact}</p>
                        <p>{card.cardImage}</p>
                    </div>
                ))*/}
                <Splide
                    options={{
                        width: '90vw',
                        perPage: 5,
                        perMove: 1,
                        focus:'center',
                        pagination: false,
                        lazyLoad: 'nearby',
                        gap: '2vw',
                        cover: true,
                        arrows: 'slider',
                        breakpoints: {
                            1670: {
                                perPage: 4,
                            },
                            1300: {
                                perPage: 3,
                            },
                            1000: {
                                perPage: 2,
                            },
                            800: {
                                perPage: 2,
                                gap: '4vw',
                            },
                            600: {
                                perPage: 1,
                                gap: '1vw',
                                padding: {
                                    left : '5rem',
                                    right: 0,
                                },
                            },
                        }
                    }}
                    className='splideContainer'
                >
                    {containerTypeContent.map(card => {
                        if (title === 'Casas en venta' || title === 'Casas en alquiler'){
                            return (
                                <SplideSlide key={card.cardLink}>
                                    <div className={styles.cardContainer} onClick={() => handleCardClick(card.cardLink)}>
                                        <img src={card.cardImage} alt={card.cardLink} className={styles.cardContainerImage} />
                                        <h3>{card.cardTitle}</h3>
                                        <h4>{card.cardDetail}</h4>
                                        <h5>{card.cardPrice}</h5>
                                    </div>
                                </SplideSlide>
                            );
                        }
                        else{
                            return (
                                <SplideSlide key={card.cardLink}>
                                    <div className={styles.cardContainer} onClick={() => handleCardClick(card.cardLink)}>
                                        <img src={card.cardImage} alt={card.cardLink} className={styles.cardContainerImage} />
                                        <h3>{card.cardTitle}</h3>
                                        <h4>{card.cardSubtitle}</h4>
                                    </div>
                                </SplideSlide>
                            );
                        }
                    }
                    )}
                </Splide>
            </div>
        </div>
    );
}

export default CardsContainer;