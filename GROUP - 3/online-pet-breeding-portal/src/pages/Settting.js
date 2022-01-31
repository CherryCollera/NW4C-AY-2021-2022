import React, { Component } from 'react'
import AccountSetting from '../components/AccountSetting'
import Navbar from '../components/Navbar'

class Settting extends Component {
    render() {
        return (
            <>
                <Navbar sd='dash' />
                <AccountSetting />
            </>
        )
    }
}

export default Settting
