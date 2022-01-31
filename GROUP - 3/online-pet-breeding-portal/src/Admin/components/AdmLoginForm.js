import React, { Component } from 'react'
import firebase, { auth } from "../../config/firebase";
class AdmLoginForm extends Component {
  constructor(props) {
    super(props)

    this.state = {
      showp: true,
      user: '',
      pass: '',
      error: '',
    }
  }
  showPas(a) {
    this.setState({
      showp: a,
    })
  }


  async userWall(a, id) {
    const data = await firebase.doc(`users/${id}`).get();
    if (data.exists) {
      if (a && (data.data().type === 'pet-breeder' || data.data().type === 'pet-owner' || data.data().type === 'veterinarian')) {
        firebase.doc(`users/${id}`).set({
          isOnline: new Date(),
        }, { merge: true }).then(() => {
          window.location.href = '/dashboard';
        })
      } else if (data.data().type === 'admin') {
        window.location.href = '/admin';
      } else {
        this.setState({ error: 'Account not found' });
        auth.signOut().catch((error) => {
          console.log(error.code + ': ' + error.message)
        });
      }
    }
  }

  componentDidMount() {
    auth.onAuthStateChanged(user => {
      if (user) {
        this.userWall(true, user.uid);
      }
    })
  }


  // async userWall(id) {
  //   const data = await firebase.doc(`users/${id}`).get();
  //   if (data.data().type === 'admin') {
  //     console.log("admin");
  //     window.location.href = '/admin';
  //   } else {
  //     // window.location.href = '/dashboard';
  //     this.setState({ error: 'Account not found' });
  //     auth.signOut().catch((error) => {
  //       console.log(error.code + ': ' + error.message)
  //     });
  //   }
  // }
  onSubmit() {
    if (this.state.pass && this.state.user) {
      auth.signInWithEmailAndPassword(this.state.user, this.state.pass)
        .then((userCredential) => {
          this.setState({ error: '' });
          this.userWall(false, userCredential.user.uid);
        })
        .catch((error) => {
          if (error.code === 'auth/user-not-found') {
            this.setState({ error: 'Account not found' });
          }
          else if (error.code === 'auth/wrong-password') {
            this.setState({ error: 'Incorrect Password' });
          }
        });
    } else {
      this.setState({ error: 'Please fill all required fields' });
    }
  }
  render() {
    return (
      <div style={{ margin: "5vh auto", width: "80vh", height: "70vh", }} className='log-wrapper'>
        <div className='log-in'>
          <center> <h1 className='til'>LOGIN</h1></center>
          <form>
            <div className='errorLoginMessage' style={{ display: this.state.error === '' ? 'none' : 'flex' }}>{this.state.error}</div>
            <div className="field">
              <input
                type="text"
                name="fullname"
                id="fullname"
                className='login'
                onChange={(e) => { this.setState({ user: e.target.value }) }}
                placeholder="username" />
              <label className='label-log' htmlFor="fullname">Username</label>
            </div>
            <div className="field">
              <input
                type={this.state.showp ? "password" : "text"}
                name="password"
                id="password"
                onChange={(e) => { this.setState({ pass: e.target.value }) }}
                className='login'
                placeholder="Password" />
              <label className='label-log' htmlFor="password">Password</label>
            </div>
            <div className='wraper'>
              <label htmlFor='showPass' className='labp'>
                <input type='checkbox' onChange={(e) => { this.showPas(!this.state.showp) }} id='showPass' className='shp' />
                Show Password</label>
              <a href='/-admin/log-in' className='ffp'>Forgot Password?</a>
            </div>
            <center>
              <button type='button' onClick={() => { this.onSubmit() }} className='btn-log' id='btnLog'>Log In</button>
            </center>
          </form>
        </div>

      </div>
    )
  }
}

export default AdmLoginForm
