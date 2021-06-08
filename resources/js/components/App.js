import React from "react";
import Login from "./Login";
import NavBar from "./NavBar";
import Simple_search from "./Simple_search";
import Footer from "./Footer";
import NotFound from "./NotFound";
import MainWindow from "./MainWindow";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";

function App() {
  return (
    <Router>
      <div>
        <Switch>
          <Route exact path="/" component={Simple_search}>
            <NavBar />
            <Simple_search />
            <Footer />
          </Route>
          <Route path="/Login" component={Login}>
            <Login />
          </Route>
          <Route path='/:provincia/:municipio/:purpose' component={MainWindow}>
            <NavBar />
            <MainWindow />
            <Footer />
          </Route>
          <Route path="*">
              <NotFound/>
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
