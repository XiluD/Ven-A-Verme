import "./styles/Simple_search.css";
import useFetch from "./useFetch";
import { useState, useEffect } from "react";
import { useHistory } from "react-router";
import Advanced_search from "./Advanced_search";
import Advanced_search_old from "./Advanced_search_old";

function Simple_search() {
    /* CONSTANT VARIABLES --------------------------------------------------------------------------------------------- */
    const path = "assets/";
    const [listItems, setListItems] = useState([]);
    const [isASClicked, setIsASClicked] = useState(false); /* default: false */
    const [isASClicked2, setIsASClicked2] =
        useState(false); /* default: false */

    const {
        data: municipios,
        isPending,
        error,
    } = useFetch("http://127.0.0.1:8000/api/provsMunsUltraBasic");
    const history = useHistory();

    /* CONSTANT FUNCTIONS --------------------------------------------------------------------------------------------- */
    const handleModalExit = () => {
        setIsASClicked(!isASClicked);
    };
    const handleModalExit2 = () => {
        setIsASClicked2(!isASClicked2);
    };

    const listItemClicked = (item) => {
        document.getElementById("simple_search").value = item;
        document.activeElement.blur();
    };

    const filter_function = () => {
        let input, filter, ul, li, i, txtValue;
        input = document.getElementById("simple_search");
        filter = input.value.toUpperCase();
        ul = document.getElementsByClassName("listaMunicipios")[0];
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
        document.getElementsByClassName("listaMunicipios")[0].style.visibility =
            "visible";
        filter_function();
    };
    const search_unfocus = () => {
        document.getElementsByClassName("listaMunicipios")[0].style.visibility =
            "hidden";
    };

    const goToSearch = () => {
        let inputText = document
            .getElementById("simple_search")
            .value.split(", ");
        let municipio = inputText[0];
        let provincia = inputText[1];
        let purpose = document.getElementById("purpose").value;
        if (municipio !== "" && provincia !== "") {
            if (purpose !== "default") {
                history.push("/" + provincia + "/" + municipio + "/" + purpose);
                /*window.location =
          "/venaverme/" + provincia + "/" + municipio + "/" + purpose;*/
            } else {
                alert("Selecciona el propósito de tu viaje");
            }
        } else {
            alert("Introduce un pueblo que consultar");
        }
    };

    /* USEEFECT --------------------------------------------------------------------------------------------- */

    useEffect(() => {
        if (municipios) {
            setListItems(
                municipios.map((municipio) => (
                    <li
                        onMouseDown={(e) => e.preventDefault()}
                        onClick={(e) => listItemClicked(e.target.innerHTML)}
                    >
                        {municipio.municipio + ", " + municipio.provincia}
                    </li>
                ))
            );
        }
    }, [municipios]);

    /* RETURN --------------------------------------------------------------------------------------------- */

    return (
        <div className="simple-search">
            {isASClicked && (
                <Advanced_search_old handleModalExit={handleModalExit} />
            )}
            {isASClicked2 && (
                <Advanced_search handleModalExit={handleModalExit2} />
            )}

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
            {municipios && (
                <div className="main-col-container">
                    <div className="row-container-title">
                        <div className="col-container" id="titulo">
                            <h1>
                                Descubre todo lo que los pueblos de España te
                                pueden ofrecer.
                            </h1>
                        </div>
                        <div className="col-container" id="ilustracion">
                            <div className="svg-container">
                                <svg
                                    width="20vw"
                                    height="20vw"
                                    viewBox="0 0 841 758"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g clip-path="url(#clip0)">
                                        <path
                                            d="M534.25 438.618L418.25 300.618L185.404 302.746L44.156 440.325L47.01 442.159H45.991V728.324H533.937V442.159L534.25 438.618Z"
                                            fill="#3F3D56"
                                        />
                                        <path
                                            d="M418.371 300.912L273.455 470.811V728.324H533.937V438.491L418.371 300.912Z"
                                            fill="#63A525"
                                        />
                                        <path
                                            d="M431.212 585.915H378.015V632.936H431.212V585.915Z"
                                            fill="white"
                                        />
                                        <path
                                            d="M431.212 504.529H378.015V550.803H431.212V504.529Z"
                                            fill="white"
                                        />
                                        <path
                                            d="M194.8 573.439H141.602V620.459H194.8V573.439Z"
                                            fill="white"
                                        />
                                        <path
                                            d="M194.8 492.052H141.602V538.327H194.8V492.052Z"
                                            fill="white"
                                        />
                                        <path
                                            d="M840.5 727.431H0V729.431H840.5V727.431Z"
                                            fill="#3F3D56"
                                        />
                                        <path
                                            d="M713.92 695.831L717.92 715.831L697.92 719.831L700.92 694.831L713.92 695.831Z"
                                            fill="#A0616A"
                                        />
                                        <path
                                            d="M776.92 691.831L771.92 716.831H747.92L757.92 686.831L776.92 691.831Z"
                                            fill="#A0616A"
                                        />
                                        <path
                                            d="M798.919 517.831L802.919 544.831L797.919 603.831L793.919 625.831L776.919 697.831C776.919 697.831 757.919 697.831 754.919 689.831L759.919 648.831C759.919 648.831 763.919 615.831 762.919 611.831C761.919 607.831 746.919 543.831 746.919 543.831C746.919 543.831 724.919 644.831 721.919 653.831C718.919 662.831 714.919 701.831 714.919 701.831C714.919 701.831 697.919 704.831 696.919 701.831C695.919 698.831 694.919 627.831 694.919 616.831C694.919 605.831 696.919 599.831 696.919 597.831C696.919 595.831 689.041 500.359 689.041 500.359L798.919 517.831Z"
                                            fill="#2F2E41"
                                        />
                                        <path
                                            d="M757.919 711.831C757.919 711.831 762.919 712.831 765.919 711.831C768.919 710.831 765.919 704.831 765.919 704.831H776.919C776.919 704.831 788.919 731.831 793.919 733.831C798.919 735.831 814.919 757.831 795.919 757.831C784.196 757.681 772.754 754.214 762.919 747.831C762.919 747.831 760.919 738.831 751.919 737.831C742.919 736.831 736.919 725.831 736.919 725.831L749.919 701.831C749.919 701.831 752.919 712.831 757.919 711.831Z"
                                            fill="#2F2E41"
                                        />
                                        <path
                                            d="M710.919 710.831C710.919 710.831 708.919 714.831 706.919 712.831C704.919 710.831 702.919 705.831 702.919 705.831C702.919 705.831 696.919 702.831 695.919 705.831C694.919 708.831 690.919 724.831 688.919 726.831C686.919 728.831 665.919 749.831 686.919 753.831C707.919 757.831 711.919 748.831 711.919 748.831C711.919 748.831 708.919 743.831 714.919 741.831C720.919 739.831 721.919 732.831 721.919 732.831L717.919 702.831C717.919 702.831 713.919 712.831 710.919 710.831Z"
                                            fill="#2F2E41"
                                        />
                                        <path
                                            d="M821.919 447.831L824.919 499.831C824.919 499.831 838.919 532.831 819.919 531.831C800.919 530.831 812.919 498.831 812.919 498.831L794.317 452.422L821.919 447.831Z"
                                            fill="#A0616A"
                                        />
                                        <path
                                            d="M667.919 432.831L664.919 484.831C664.919 484.831 650.919 517.831 669.919 516.831C688.919 515.831 676.919 483.831 676.919 483.831L695.522 437.422L667.919 432.831Z"
                                            fill="#A0616A"
                                        />
                                        <path
                                            d="M747.919 319.831C762.279 319.831 773.919 308.191 773.919 293.831C773.919 279.472 762.279 267.831 747.919 267.831C733.56 267.831 721.919 279.472 721.919 293.831C721.919 308.191 733.56 319.831 747.919 319.831Z"
                                            fill="#A0616A"
                                        />
                                        <path
                                            d="M768.419 304.331C768.419 304.331 761.419 332.331 775.419 339.331C789.419 346.331 731.419 356.331 727.419 339.331L729.419 331.331C729.419 331.331 737.419 321.331 735.419 312.331L768.419 304.331Z"
                                            fill="#A0616A"
                                        />
                                        <path
                                            d="M752.919 339.831C752.919 339.831 735.664 341.443 730.292 330.137C730.292 330.137 689.919 332.831 680.919 369.831L695.919 465.831C695.919 465.831 679.919 493.831 681.919 496.831C681.919 496.831 671.919 524.831 763.919 525.831L803.919 523.831C804.46 518.147 804.123 512.413 802.919 506.831C800.919 497.831 789.919 434.831 789.919 434.831C789.919 434.831 819.919 387.831 816.919 380.831C813.919 373.831 809.115 346.23 770.517 335.031C770.517 335.031 769.919 340.831 752.919 339.831Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M803.919 363.831L816.919 380.831C816.919 380.831 829.919 451.831 825.919 452.831C821.919 453.831 797.919 461.831 793.919 458.831C789.919 455.831 771.919 396.831 771.919 396.831L803.919 363.831Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M697.919 358.831L680.919 369.831C680.919 369.831 655.919 439.831 662.919 442.831C669.919 445.831 708.919 443.831 708.919 443.831L697.919 358.831Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M776.339 270.563C776.339 270.563 767.333 251.051 750.072 255.554C732.812 260.057 723.055 266.811 722.305 273.565C721.555 280.319 722.68 290.451 722.68 290.451C722.68 290.451 724.556 276.567 736.564 279.569C742.95 281.165 751.248 281.276 757.617 281.03C758.865 280.978 760.111 281.182 761.278 281.628C762.445 282.074 763.509 282.754 764.404 283.625C765.3 284.496 766.008 285.541 766.487 286.695C766.965 287.849 767.203 289.089 767.187 290.338L766.872 311.831C766.872 311.831 791.872 295.831 776.339 270.563Z"
                                            fill="#2F2E41"
                                        />
                                        <path
                                            d="M653.71 278.13H300.524C298.79 278.128 297.128 277.438 295.902 276.212C294.676 274.986 293.986 273.324 293.984 271.59V109.418C293.986 107.684 294.676 106.022 295.902 104.796C297.128 103.57 298.79 102.88 300.524 102.878H653.71C655.444 102.88 657.106 103.57 658.332 104.796C659.558 106.022 660.248 107.684 660.25 109.418V271.59C660.248 273.324 659.558 274.986 658.332 276.212C657.106 277.438 655.444 278.128 653.71 278.13V278.13ZM300.524 105.494C299.484 105.495 298.486 105.909 297.751 106.645C297.015 107.38 296.601 108.378 296.6 109.418V271.59C296.601 272.63 297.015 273.628 297.751 274.363C298.486 275.099 299.484 275.513 300.524 275.514H653.71C654.75 275.513 655.747 275.099 656.483 274.363C657.219 273.628 657.633 272.63 657.634 271.59V109.418C657.633 108.378 657.219 107.38 656.483 106.645C655.747 105.909 654.75 105.495 653.71 105.494H300.524Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M352.786 186.969C367.5 186.969 379.428 175.041 379.428 160.327C379.428 145.612 367.5 133.684 352.786 133.684C338.072 133.684 326.144 145.612 326.144 160.327C326.144 175.041 338.072 186.969 352.786 186.969Z"
                                            fill="#63A525"
                                        />
                                        <path
                                            d="M414.317 142.565C413.733 142.564 413.155 142.678 412.616 142.901C412.076 143.124 411.586 143.451 411.173 143.863C410.76 144.276 410.432 144.765 410.209 145.305C409.985 145.844 409.87 146.422 409.87 147.005C409.87 147.589 409.985 148.167 410.209 148.706C410.432 149.245 410.76 149.735 411.173 150.148C411.586 150.56 412.076 150.887 412.616 151.11C413.155 151.332 413.733 151.447 414.317 151.446H623.65C624.828 151.446 625.957 150.978 626.79 150.145C627.622 149.312 628.09 148.183 628.09 147.005C628.09 145.828 627.622 144.698 626.79 143.865C625.957 143.033 624.828 142.565 623.65 142.565H414.317Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M414.317 169.207C413.733 169.206 413.155 169.321 412.616 169.543C412.076 169.766 411.586 170.093 411.173 170.505C410.76 170.918 410.432 171.408 410.209 171.947C409.985 172.486 409.87 173.064 409.87 173.648C409.87 174.231 409.985 174.809 410.209 175.348C410.432 175.888 410.76 176.377 411.173 176.79C411.586 177.202 412.076 177.529 412.616 177.752C413.155 177.975 413.733 178.089 414.317 178.088H504.394C504.977 178.089 505.555 177.975 506.095 177.752C506.634 177.529 507.125 177.202 507.538 176.79C507.951 176.377 508.278 175.888 508.502 175.348C508.726 174.809 508.841 174.231 508.841 173.648C508.841 173.064 508.726 172.486 508.502 171.947C508.278 171.408 507.951 170.918 507.538 170.505C507.125 170.093 506.634 169.766 506.095 169.543C505.555 169.321 504.977 169.206 504.394 169.207H414.317Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M332.35 211.801C328.973 211.801 326.224 213.793 326.224 216.241C326.224 218.689 328.973 220.681 332.35 220.681H621.165C624.543 220.681 627.292 218.689 627.292 216.241C627.292 213.793 624.543 211.801 621.165 211.801H332.35Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M332.35 238.443C328.973 238.443 326.224 240.435 326.224 242.883C326.224 245.332 328.973 247.324 332.35 247.324H621.165C624.543 247.324 627.292 245.332 627.292 242.883C627.292 240.435 624.543 238.443 621.165 238.443H332.35Z"
                                            fill="#9A9A9A"
                                        />
                                        <path
                                            d="M590.1 94.7642C616.268 94.7642 637.482 73.5505 637.482 47.3821C637.482 21.2137 616.268 0 590.1 0C563.931 0 542.717 21.2137 542.717 47.3821C542.717 73.5505 563.931 94.7642 590.1 94.7642Z"
                                            fill="#63A525"
                                        />
                                        <path
                                            d="M590.1 124.408L575.284 98.747L560.469 73.086H590.1H619.73L604.915 98.747L590.1 124.408Z"
                                            fill="#63A525"
                                        />
                                        <path
                                            d="M590.482 64.0864C599.871 64.0864 607.482 56.4752 607.482 47.0864C607.482 37.6975 599.871 30.0864 590.482 30.0864C581.093 30.0864 573.482 37.6975 573.482 47.0864C573.482 56.4752 581.093 64.0864 590.482 64.0864Z"
                                            fill="white"
                                        />
                                        <path
                                            d="M768.872 298.831C771.081 298.831 772.872 296.593 772.872 293.831C772.872 291.07 771.081 288.831 768.872 288.831C766.663 288.831 764.872 291.07 764.872 293.831C764.872 296.593 766.663 298.831 768.872 298.831Z"
                                            fill="#A0616A"
                                        />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0">
                                            <rect
                                                width="840.5"
                                                height="757.831"
                                                fill="white"
                                            />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div className="content">
                        <div className="search_list_container">
                            <div className="input_text_container">
                                <i className="material-icons">search</i>
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Busca municipios a donde ir..."
                                    autocomplete="off"
                                    id="simple_search"
                                    onFocus={search_focus}
                                    onBlur={search_unfocus}
                                    onKeyUp={filter_function}
                                    required
                                />
                            </div>
                            <div className="relative-positioner">
                                <ul className="listaMunicipios">{listItems}</ul>
                            </div>
                        </div>
                        <select name="purpose" id="purpose">
                            <option
                                value="default"
                                disabled
                                selected
                                style={{ display: "none" }}
                            >
                                Propósito del viaje
                            </option>
                            <option value="vacations">Vacaciones</option>
                            <option value="rentSale">
                                Búsqueda de vivienda
                            </option>
                        </select>
                        <button onClick={goToSearch}>Buscar</button>

                        <button
                            onClick={() => {
                                setIsASClicked2(!isASClicked2);
                            }}
                        >
                            <img
                                src={path + "advanced_search_52px.png"}
                                alt="advanced search logo"
                            />
                            Búsqueda Avanzada
                        </button>
                        <button
                            onClick={() => {
                                setIsASClicked(!isASClicked);
                            }}
                        >
                            <img
                                src={path + "advanced_search_52px.png"}
                                alt="advanced search logo"
                            />
                            Búsqueda Avanzada_old
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}
export default Simple_search;
