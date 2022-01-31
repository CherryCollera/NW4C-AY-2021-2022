import React, { Component } from 'react'
import Navbar from '../components/Navbar'
import Map from '../Maps/Map'

class Locate extends Component {
    render() {
        return (
            <>
                <Navbar sd='dash' hd='Locate' />
                <Map />
            </>
        )
    }
}
// 
export default Locate
