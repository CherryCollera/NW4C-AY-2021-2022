import React, { Component } from 'react'
import Navbar from '../components/Navbar'
import UserRegForm from '../components/UserRegForm'

class Register extends Component {



    render() {
        return (
            <>
                <Navbar sd="reg" />
                <UserRegForm />

            </>
        )
    }
}

export default Register
