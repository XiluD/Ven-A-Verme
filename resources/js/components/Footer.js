import "./styles/Footer.css";

function Footer() {
  const path = "assets/";
  return (
    <div className="footer">
      <div className="section-container">
        <h1>Síguenos en GitHub:</h1>
        <div className="row-container">
          <a href="https://github.com/XiluD">
            <div className="tooltip">
              <img
                src="https://avatars.githubusercontent.com/u/47109009?v=4"
                alt="github profile"
              />
              <span class="tooltiptext">Diego Vicente</span>
            </div>
          </a>
          <a href="https://github.com/ManuelSalvador3">
            <div className="tooltip">
              <img
                src="https://avatars.githubusercontent.com/u/27558633?v=4"
                alt="github profile"
              />
              <span class="tooltiptext">Manuel Salvador</span>
            </div>
          </a>
          <a href="https://github.com/10GGGGGGGGGG">
            <div className="tooltip">
              <img
                src="https://avatars.githubusercontent.com/u/47125167?v=4"
                alt="github profile"
              />
              <span class="tooltiptext">Gonzalo Alcaide</span>
            </div>
          </a>
        </div>
      </div>
      <div className="section-container" id="center">
        <h1>Contacta con nosotros:</h1>
        <div className="row-container">
          <a href="https://es-es.facebook.com/">
            <div className="tooltip">
              <img src={path + "facebook_52px.png"} alt="social icon" />
              <span class="tooltiptext">Facebook</span>
            </div>
          </a>
          <a href="https://www.whatsapp.com/?lang=es">
            <div className="tooltip">
              <img src={path + "whatsapp_52px.png"} alt="social icon" />
              <span class="tooltiptext">WhatsApp</span>
            </div>
          </a>
          <a href="https://www.instagram.com/">
            <div className="tooltip">
              <img src={path + "instagram_52px.png"} alt="social icon" />
              <span class="tooltiptext">Instagram</span>
            </div>
          </a>
          <a href="https://www.youtube.com/">
            <div className="tooltip">
              <img src={path + "youtube_52px.png"} alt="social icon" />
              <span class="tooltiptext">Youtube</span>
            </div>
          </a>
          <a href="https://twitter.com/">
            <div className="tooltip">
              <img src={path + "twitter_52px.png"} alt="social icon" />
              <span class="tooltiptext">Twitter</span>
            </div>
          </a>
        </div>
      </div>
      <div className="section-container">
        <h2>Proyecto de Computación II-III</h2>
        <h2>Grado en Ingeniería Informática</h2>
        <div className="row-container">
          <a href="https://universidadeuropea.com/">
            <img
              id="uni-logo"
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREVLJcncrAEdCJhnhapPFadhrnmGvwgFxy-A&usqp=CAU"
              alt="uni-logo"
            />
          </a>
          <h2>Universidad Europea de Madrid</h2>
        </div>
      </div>
    </div>
  );
}
export default Footer;
