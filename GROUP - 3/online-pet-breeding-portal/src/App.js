import React, { Component } from 'react'
import {
  Route,
  BrowserRouter as Router,
  Switch,
  Redirect,
} from "react-router-dom";
import AdmDash from './Admin/pages/AdmDash';
import AdmLogin from './Admin/pages/AdmLogin';
import firebase, { auth } from './config/firebase';
import Progressbar from './Functions/Progressbar';
import { ContactUs } from './Mailer/Mailer';
import { Breed } from './pages/Breed';
import BreedFind from './pages/BreedFind';
import Breeding from './pages/Breeding';
import Dashboard from './pages/Dashboard';
import Homepage from './pages/Homepage';
import Locate from './pages/Locate';
import Messages from './pages/Messages';
import Pets from './pages/Pets';
import Register from './pages/Register';
import ReGuest from './pages/ReGuest';
import Settting from './pages/Settting';
import UserProfile from './pages/UserProfile';
import Welcome from './pages/Welcome';

function PublicRoute({ component: Component, authenticated, userType, ...rest }) {
  return (
    <Route
      {...rest}
      render={(props) => authenticated === true
        ?
        (userType === 'admin' && <Redirect to='/admin' />) ||
        (userType === 'user' && <Component {...props} />)
        : <Redirect to={{ pathname: '/' }} />}
    />
  )
}
function PrivateRoute({ component: Component, authenticated, userType, ...rest }) {
  return (
    <Route
      {...rest}
      render={(props) => (authenticated === true)
        ?
        (userType === 'admin' && <Component {...props} />) ||
        (userType === 'user' && <Redirect to='/dashboard' />)
        : <Redirect to='/' />}
    />
  )
}

class App extends Component {
  constructor() {
    super();
    this.state = {
      authenticated: false,
      loading: true,
    };
    this.getUserType = this.getUserType.bind(this);
  }

  setUserOnline() {
    this.interval = setInterval(() => {
      auth.onAuthStateChanged((user) => {
        if (user) {
          firebase.doc(`users/${user.uid}`).set({
            isOnline: new Date(),
          }, { merge: true });
        }
      })
    }, 60000)
  }

  async getUserType(a) {
    const data = await firebase.doc(`users/${a}`).get();
    if (data.exists) {
      if (!data.data().confirmed) {
        const path = window.location.pathname;
        if (path !== '/Welcome') {
          auth.signOut().then(() => {
            window.location.href = '/';
          }).catch((error) => {
            console.log(error.code + ': ' + error.message)
          });
        }
      }
      if (data.data().banned) {
        auth.signOut().then(() => {
          window.location.href = '/';
        }).catch((error) => {
          console.log(error.code + ': ' + error.message)
        });
      }
      if (data.data().type === 'pet-breeder' || data.data().type === 'pet-owner' || data.data().type === 'veterinarian') {
        this.setState({ userType: 'user' })
      } else if (data.data().type === 'admin') {
        this.setState({ userType: 'admin' })
      }
    }
  }

  componentDidMount() {
    auth.onAuthStateChanged((user) => {
      if (user) {
        this.getUserType(user.uid);
        this.setState({
          authenticated: true,
          loading: false,
        });
      } else {
        this.setState({
          authenticated: false,
          loading: false,
        });
      }
    })
    this.setUserOnline();
  }

  render() {

    return this.state.loading === true ? <Progressbar start={0} /> : (<>
      <Router>
        <Switch>

          {/* All */}
          <Route path="/register" exact component={Register}></Route>
          <Route path="/log-in" exact component={AdmLogin}></Route>
          <Route path="/register-guest" exact component={ReGuest}></Route>
          <Route path="/mail" exact component={ContactUs}></Route>
          <Route path="/" exact component={Homepage}></Route>
          <Route path="/admin/log-in" exact component={AdmLogin}></Route>
          {/* Admin */}
          <PrivateRoute exact path="/admin" authenticated={this.state.authenticated} userType={this.state.userType} component={AdmDash}></PrivateRoute>/
          <PrivateRoute exact path="/admin/users" authenticated={this.state.authenticated} userType={this.state.userType} component={AdmDash}></PrivateRoute>/
          <PrivateRoute exact path="/admin/pets" authenticated={this.state.authenticated} userType={this.state.userType} component={AdmDash}></PrivateRoute>/
          <PrivateRoute exact path="/admin/reports" authenticated={this.state.authenticated} userType={this.state.userType} component={AdmDash}></PrivateRoute>/
          <PrivateRoute exact path="/admin/messages" authenticated={this.state.authenticated} userType={this.state.userType} component={AdmDash}></PrivateRoute>/
          <PrivateRoute exact path="/admin/statistics" authenticated={this.state.authenticated} userType={this.state.userType} component={AdmDash}></PrivateRoute>/
          {/* Under Development */}

          {/* User */}
          <Route exact path="/pets/:handle" component={Pets}></Route>
          <Route exact path="/dashboard" component={Dashboard}></Route>
          <Route exact path="/profile/:handle" component={UserProfile}></Route>
          <PublicRoute exact path="/Welcome" authenticated={this.state.authenticated} userType={this.state.userType} component={Welcome}></PublicRoute>
          <PublicRoute exact path="/locate" authenticated={this.state.authenticated} userType={this.state.userType} component={Locate}></PublicRoute>
          <PublicRoute exact path="/breed" authenticated={this.state.authenticated} userType={this.state.userType} component={Breed}></PublicRoute>
          <PublicRoute exact path="/breeding" authenticated={this.state.authenticated} userType={this.state.userType} component={Breeding}></PublicRoute>
          <PublicRoute exact path="/breed/find" authenticated={this.state.authenticated} userType={this.state.userType} component={BreedFind}></PublicRoute>
          <PublicRoute exact path="/profile" authenticated={this.state.authenticated} userType={this.state.userType} component={UserProfile}></PublicRoute>
          <PublicRoute exact path="/settings" authenticated={this.state.authenticated} userType={this.state.userType} component={Settting}></PublicRoute>
          <PublicRoute exact path="/messages" authenticated={this.state.authenticated} userType={this.state.userType} component={Messages}></PublicRoute>
          <PublicRoute exact path="/pets" authenticated={this.state.authenticated} userType={this.state.userType} component={Pets}></PublicRoute>
          <PublicRoute exact path="/messages/:handle" authenticated={this.state.authenticated} userType={this.state.userType} component={Messages}></PublicRoute>
        </Switch>
      </Router>
    </>
    )

  }
}
export default App

