import React, { Component } from 'react'
import Login from '../components/Login';
import Navbar from '../components/Navbar'

export class LoginPage extends Component {
    render() {
        return (
            <>
                <Navbar sd="reg" />
                <Login />
            </>
        )
    }
}

export default LoginPage
