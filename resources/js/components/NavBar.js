import "./styles/NavBar.css";
import { Link } from 'react-router-dom';

function NavBar() {
  const path = "assets/";
  return (
    <div className="navbar">
      <div className="left-container">
        <Link to="/">
          <div className="title-container">
            <img src={path + "village_96px.png"} alt="village logo" />
            <h1>Ven a Verme</h1>
          </div>
        </Link>
      </div>
      <div className="right-container">
        <div className="tooltip">
          <Link to="/">
            <img src={path + "search_52px.png"} alt="search logo" />
          </Link>
          <span class="tooltiptext">buscador</span>
        </div>
        <div className="tooltip">
          <Link to="/Login">
            <img src={path + "male_user_52px.png"} alt="profile logo" />
          </Link>
          <span class="tooltiptext">perfil</span>
        </div>
        <div className="tooltip">
          <a href="/api/documentation" target="_blank">
            <img src={path + "api_52px.png"} alt="api logo" />
          </a>
          <span class="tooltiptext">Api Docs</span>
        </div>
      </div>
    </div>
  );
}
export default NavBar;
