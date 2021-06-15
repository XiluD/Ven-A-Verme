import "./styles/Advanced_search_old.css";
import { useState, useEffect } from "react";
import useFetch from "./useFetch";

function Advanced_search_old({ handleModalExit }) {
    const path = "assets/";
    const minHabitantes = "0";
    const [maxHabitantes, setMaxHabitantes] = useState("50000");
    const [listItems, setListItems] = useState([]);
    const [sliderValue, setSliderValue] = useState(maxHabitantes / 2);
    const [message, setMessage] = useState(
        "Introduce los parámetros de filtrado y comienza a buscar."
    );
    const [pendingSearch, setPendingSearch] = useState(false);
    const [searchDone, setSearchDone] = useState(false);
    const [municipiosFiltered, setMunicipiosFiltered] = useState(null);
    const [listMunis, setListMunis] = useState([]);

    const {
        data: provincias,
        isPending,
        error,
    } = useFetch("http://127.0.0.1:8000/api/provsBasic");

    const listItemClicked = (item) => {
        document.getElementById("advanced_search").value = item;
        document.activeElement.blur();
    };

    const filter_function = () => {
        let input, filter, ul, li, i, txtValue;
        input = document.getElementById("advanced_search");
        filter = input.value.toUpperCase();
        ul = document.getElementsByClassName("listaProvincias")[0];
        li = ul.getElementsByTagName("li");
        // Loop through all list items, and hide those who don't match the search query
        if (filter !== "") {
            for (i = 0; i < li.length; i++) {
                txtValue = li[i].innerHTML;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        } else {
            for (i = 0; i < li.length; i++) {
                txtValue = li[i].innerHTML;
                li[i].style.display = "";
            }
        }
    };
    const search_focus = () => {
        document.getElementsByClassName("listaProvincias")[0].style.visibility =
            "visible";
        filter_function();
    };
    const search_unfocus = () => {
        document.getElementsByClassName("listaProvincias")[0].style.visibility =
            "hidden";
    };

    const handleChangeSlider = (event) => {
        setSliderValue(event.target.value);
    };
    const handleChangeTextSlider = (event) => {
        if (event.target.value == "") {
            setSliderValue("0");
        } else {
            setSliderValue(event.target.value.replaceAll(",", ""));
        }
    };
    const handleChangeMaxHabs = (event) => {
        if (event.target.value == "") {
            setMaxHabitantes("0");
        } else {
            setMaxHabitantes(event.target.value.replaceAll(",", ""));
        }
    };

    const filterMunicipios = () => {
        let provincia = document.getElementById("advanced_search").value;
        let despoblacion = document.getElementById("check").checked;
        if (provincia == "") {
            alert("Introduce una provincia que consultar");
        } else {
            let url = "";
            if (despoblacion) {
                url =
                    "http://localhost:8000/api/munsOfPoblationOrdered/" +
                    provincia +
                    "/" +
                    sliderValue +
                    "?ev=true";
            } else {
                url =
                    "http://localhost:8000/api/munsOfPoblationOrdered/" +
                    provincia +
                    "/" +
                    sliderValue;
            }
            setPendingSearch(true);
            setSearchDone(false);
            fetch(url)
                .then((res) => {
                    if (!res.ok) {
                        throw Error(
                            "could not fetch the data for that resource"
                        );
                    }
                    return res.json();
                })
                .then((data) => {
                    setMunicipiosFiltered(data);
                    setPendingSearch(false);
                    setSearchDone(true);
                })
                .catch((err) => {
                    setMessage(err.message);
                    setPendingSearch(false);
                });
        }
    };
    const listMuniClicked = (e) => {
        document.getElementById("simple_search").value = e;
        handleModalExit();
    };
    useEffect(() => {
        if (provincias) {
            setListItems(
                provincias.map((provincia) => (
                    <li
                        onMouseDown={(e) => e.preventDefault()}
                        onClick={(e) => listItemClicked(e.target.innerHTML)}
                    >
                        {provincia.provincia}
                    </li>
                ))
            );
        }
        if (municipiosFiltered) {
            setListMunis(
                municipiosFiltered.map((municipio) => (
                    <div
                        className="muniCard"
                        onClick={(e) =>
                            listMuniClicked(
                                `${municipio.municipio}, ${municipio.provincia}`
                            )
                        }
                        style={{
                            backgroundImage: `url(${municipio.imagenMunicipio})`,
                        }}
                    >
                        <div className="gradient">
                            <p className="cardInfo">
                                {municipio.municipio}, {municipio.provincia}
                            </p>
                            <p className="cardInfo">
                                población: {municipio.poblacion}
                            </p>
                        </div>
                    </div>
                ))
            );
        }
    }, [provincias, municipiosFiltered]);

    return (
        <div className="Advanced_search_old">
            <div className="modal_screen" onClick={handleModalExit}>
                {error && <div className="loading-div">{error}</div>}
                {isPending && (
                    <div className="loading-div">
                        <img
                            src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif"
                            alt="loading.gif"
                            width="200"
                            height="200"
                        />
                        <p>Loading...</p>
                    </div>
                )}
                {provincias && (
                    <div
                        className="Advanced_search_card"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <span className="close" onClick={handleModalExit}>
                            &times;
                        </span>
                        <div className="left_container">
                            <h1>Búsqueda Avanzada</h1>
                            <div className="search_list_container">
                                <div className="input_text_container">
                                    <i className="material-icons">search</i>
                                    <input
                                        type="text"
                                        name="search"
                                        placeholder="Buscar provincias..."
                                        autocomplete="off"
                                        id="advanced_search"
                                        onFocus={search_focus}
                                        onBlur={search_unfocus}
                                        onKeyUp={filter_function}
                                    />
                                </div>
                                <div className="relative-positioner">
                                    <ul className="listaProvincias">
                                        {listItems}
                                    </ul>
                                </div>
                            </div>
                            <p>Número máximo de habitantes en el municipio:</p>
                            <div class="slidecontainer">
                                <p>{minHabitantes}</p>
                                <input
                                    type="range"
                                    min={minHabitantes}
                                    max={maxHabitantes}
                                    step="10"
                                    class="slider"
                                    id="myRange"
                                    value={sliderValue}
                                    onChange={handleChangeSlider}
                                />
                                <input
                                    type="text"
                                    name="maxHabitantes"
                                    autocomplete="off"
                                    id="maxHabitantes"
                                    value={parseInt(
                                        maxHabitantes
                                    ).toLocaleString("en-US")}
                                    onChange={handleChangeMaxHabs}
                                />
                            </div>
                            <input
                                type="text"
                                id="quantity"
                                name="quantity"
                                autocomplete="off"
                                value={parseInt(sliderValue).toLocaleString(
                                    "en-US"
                                )}
                                onChange={handleChangeTextSlider}
                            ></input>
                            <div className="checkContainer">
                                <input
                                    type="checkbox"
                                    id="check"
                                    name="check"
                                    value="check"
                                />
                                <label for="check">
                                    Mostrar resultados de la España vaciada
                                </label>
                            </div>
                            <p id="info">
                                Marcando esta casilla, nuestro buscador
                                analizará la información de noticias relevantes
                                sobre el municipio y aplicará un modelo de
                                Inteligencia Artificial para determinar si se
                                trata de un pueblo de la España vaciada o no.
                            </p>
                            <button onClick={filterMunicipios}>Buscar</button>
                        </div>
                        <div className="right_container">
                            <h1>Resultados de tu búsqueda</h1>
                            {!searchDone && <p id="message">{message}</p>}
                            {pendingSearch && (
                                <div className="loading-div">
                                    <img
                                        src="https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif"
                                        alt="loading.gif"
                                        width="200"
                                        height="200"
                                    />
                                    <p>Loading...</p>
                                </div>
                            )}
                            {searchDone && (
                                <div className="cards_container">
                                    {listMunis}
                                </div>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}

export default Advanced_search_old;
