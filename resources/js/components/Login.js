import "./styles/Login.css";
import { useState } from "react";

function Login() {
  const path = "assets/";
  const textos = [
    "¡Encantados de verte de nuevo! Introduce tus datos para iniciar sesión y ver tu autenticación para acceder a rutas protegidas de la API. Si no tienes una cuenta, selecciona Registrarse para navegar al formulario de creación de cuenta.",
    "¡Bienvenido! Muchas gracias por elegir utilizar nuestra aplicación. Rellena los campos con tus datos y pulsa Crear Cuenta para crear tu cuenta y acceder a nuestros servicios de autenticación para rutas protegidas de la API.",
  ];
  const [classAnimation, setClassAnimation] = useState("");
  const [welcomeText, setWelcomeText] = useState(textos[0]);
  const [buttonText, setButtonText] = useState("Registrarse");

  const goToRegister = () => {
    if (classAnimation === "" || classAnimation === "animation-goToLogin") {
      setClassAnimation("animation-goToRegister");
      setWelcomeText(textos[1]);
      setButtonText("Ingresar");
    } else {
      setClassAnimation("animation-goToLogin");
      setWelcomeText(textos[0]);
      setButtonText("Registrarse");
    }
  };


  const [email, setEmail] = useState('Correo electrónico');
  const [password, setPassword] = useState('Contraseña');
  const [confirmPassword, setConfirmPassword] = useState('Confirmar contraseña');

  const [isPending, setIsPending] = useState(false);

  const handleLoginSubmit = (e) => {
    e.preventDefault();
    const admin = { email, password};
    
    setIsPending(true);
    console.log(admin);

    const abortCont = new AbortController();
    fetch(`http://127.0.0.1:8000/api/admin/${admin.email}/${admin.password}`, {
      method: 'GET',
      signal: abortCont.signal
    }).then(response => {
      if (!response.ok) {
        throw new Error('cannot fetch the data');
      }
      return response.json();
    }).then(data => {
      setIsPending(false);
      
      if (data.operation === 'Success'){
        alert(`Successful login, remember your API_TOKEN: ${data.api_token}`)
      }
      else{
        alert(`Your email or password are incorrect!`)
      }
    })
}


const handleRegisterSubmit = (e) => {
  e.preventDefault();
  const adminForm = {email, password, confirmPassword};
  if(adminForm.password !== adminForm.confirmPassword){
    alert('Confirmación incorrecta, intentelo de nuevo');
  }
  else{
    const admin = {email, password};
    setIsPending(true);
    fetch(`http://127.0.0.1:8000/api/admin/`, {
        method: 'POST',
        headers: { "Content-Type": "application/json"},
        body: JSON.stringify(admin)
    }).then(response => {
      return response.json();
    }).then(data => {
        console.log(data);
        setIsPending(false);
        if (data.operation === 'Success'){
          alert(`Successfully created account, remember your API_TOKEN: ${data.api_token}`)
        }
        else{
          alert('This account already exists!')
        }
    });
  }
}

  return (
    <div className="login-card">
      <div className="left-container">
        <form className="left-container-aligner" onSubmit={handleLoginSubmit}>
          <h1>Ingreso</h1>
          <div className="input_text_container">
            <i className="material-icons">email</i>
            <input
              type="email"
              required
              placeholder="Correo electrónico"
              onChange = {(e) => setEmail(e.target.value)}
            />
          </div>
          <br />
          <div className="input_text_container">
            <i className="material-icons">vpn_key</i>
            <input
              type="password"
              required
              placeholder="Contraseña"
              onChange = {(e) => setPassword(e.target.value)}
            />
          </div>
          {!isPending && <button>Iniciar sesión</button>}
          {isPending && <button disabled>Iniciando sesion...</button>}
        </form>
      </div>
      <div className="right-container">
        <form className="right-container-aligner" style={{marginBottom: '45px'}} onSubmit={handleRegisterSubmit}>
          <h1 style={{marginRight: '190px'}}>Registro</h1>
          <div className="input_text_container">
            <i className="material-icons">email</i>
            <input
              type="email"
              required
              placeholder="Correo electrónico"
              onChange = {(e) => setEmail(e.target.value)}
            />
          </div>
          <div className="input_text_container">
            <i className="material-icons">vpn_key</i>
            <input
              type="password"
              required
              placeholder="Contraseña"
              onChange = {(e) => setPassword(e.target.value)}
            />
          </div>
          <div className="input_text_container">
            <i className="material-icons">vpn_key</i>
            <input
              type="password"
              required
              placeholder="Confirmar Contraseña"
              onChange = {(e) => setConfirmPassword(e.target.value)}
            />
          </div>
          {!isPending && <button>Crear cuenta</button>}
          {isPending && <button disabled>Creando cuenta...</button>}
        </form>
      </div>
      <div className={"moving-panel " + classAnimation}>
        <div className="login-welcome">
          <a className="title-link" href="/">
            <div className="input_text_container">
              <img src={path + "village_96px.png"} alt="village logo" />
              <h1>Ven a Verme</h1>
            </div>
          </a>
          <p>{welcomeText}</p>
          <button onClick={goToRegister}>{buttonText}</button>
        </div>
      </div>
    </div>
  );
}
export default Login;
