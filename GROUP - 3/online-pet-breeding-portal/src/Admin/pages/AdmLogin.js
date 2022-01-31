import React, { Component } from 'react'
import { auth } from '../../config/firebase'
import { userWall } from '../../Functions/Functions'
import Login from '../../components/Login.js'
import ANavBar from '../components/ANavBar'

class AdmLogin extends Component {
    componentDidMount() {
        auth.onAuthStateChanged(user => {
            if (user) {
                userWall(user.uid);
            }
        })
    }
    render() {
        return (
            <>
                <ANavBar />
                <div className='logIn'>
                    <Login />
                </div>
            </>
        )
    }
}

export default AdmLogin
