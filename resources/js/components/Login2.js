import "../../css/Login2.css";
import { useState } from "react";

function Login2() {
    const textos = [
        "¡Encantados de verte de nuevo! Introduce tus datos para iniciar sesión y proceder al uso de la aplicación. Si no tienes una cuenta, selecciona Registrarse para navegar al formulario de creación de cuenta.",
        "¡Bienvenido! Muchas gracias por elegir utilizar nuestra aplicación, esperamos que te sea de utilidad. Rellena los campos con tus datos y pulsa Enviar para crear tu cuenta y acceder a nuestros servicios.",
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

    return (
        <div className="login-card">
            <div className="left-container">
                <div className="left-container-aligner">
                    <h1>Ingreso</h1>
                    <div className="input_text_container">
                        <i className="material-icons">email</i>
                        <input
                            type="email"
                            name="email"
                            placeholder="Correo electrónico"
                            id="user_email"
                            required
                        />
                    </div>
                    <br />
                    <div className="input_text_container">
                        <i className="material-icons">vpn_key</i>
                        <input
                            type="password"
                            name="password"
                            placeholder="Contraseña"
                            id="user_password"
                            required
                        />
                    </div>
                    <input type="submit" name="submit" />
                </div>
            </div>
            <div className="right-container">
                <div className="right-container-aligner">
                    <h1>Registro</h1>
                    <div className="input_text_container">
                        <i className="material-icons">account_circle</i>
                        <input
                            type="text"
                            name="name"
                            placeholder="Nombre de Usuario"
                            id="user_name"
                            required
                        />
                    </div>
                    <div className="input_text_container">
                        <i className="material-icons">email</i>
                        <input
                            type="email"
                            name="email"
                            placeholder="Correo electrónico"
                            id="user_email"
                            required
                        />
                    </div>
                    <div className="input_text_container">
                        <i className="material-icons">vpn_key</i>
                        <input
                            type="password"
                            name="password"
                            placeholder="Contraseña"
                            id="user_password"
                            required
                        />
                    </div>
                    <div className="input_text_container">
                        <i className="material-icons">vpn_key</i>
                        <input
                            type="password"
                            name="password"
                            placeholder="Confirmar Contraseña"
                            id="user_password_verify"
                            required
                        />
                    </div>
                    <div className="input_text_container">
                        <i className="material-icons">admin_panel_settings</i>
                        <input
                            type="text"
                            name="employee_key"
                            placeholder="Token de administrador*"
                            id="employee_key"
                        />
                    </div>
                    <p>
                        *Este campo solo es requerido para crear una cuenta de
                        arministración
                    </p>
                    <input type="submit" name="submit" />
                </div>
            </div>
            <div className={"moving-panel " + classAnimation}>
                <div className="login-welcome">
                    <div className="input_text_container">
                        <img src="assets/village_96px.png" alt="village logo" />
                        <h1>Ven a Verme</h1>
                    </div>
                    <p>{welcomeText}</p>
                    <button onClick={goToRegister}>{buttonText}</button>
                </div>
            </div>
        </div>
    );
}
export default Login2;
