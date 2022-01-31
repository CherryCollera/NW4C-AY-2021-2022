import React, { Component } from 'react'
import Adm from '../components/Adm'
import ANavBar from '../components/ANavBar'

class AdmDash extends Component {
    render() {
        return (
            <>
                <ANavBar admin={true} />
                <Adm />
            </>
        )
    }
}

export default AdmDash
