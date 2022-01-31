import React, { Component } from 'react'
import Navbar from '../components/Navbar'
import UserRegForm from '../components/UserRegForm'

class ReGuest extends Component {
    render() {
        return (
            <>
                <Navbar sd="reg" />
                <UserRegForm guest="true" />

            </>
        )
    }
}

export default ReGuest