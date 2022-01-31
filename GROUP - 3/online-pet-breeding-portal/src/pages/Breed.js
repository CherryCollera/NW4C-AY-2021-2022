import React, { Component } from 'react'
import Navbar from '../components/Navbar'
import BreedHome from '../components/BreedHome'

export class Breed extends Component {
    render() {
        return (
            <>
                <Navbar sd='dash' hd='Breed' />
                <BreedHome />
            </>
        )
    }
}

export default Breed
