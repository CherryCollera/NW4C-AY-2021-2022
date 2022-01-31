import React, { Component } from 'react'
import BreedDiv from '../components/BreedDiv'
import Navbar from '../components/Navbar'
class BreedFind extends Component {
    render() {
        return (
            <>
                <Navbar sd='dash' hd='Breed' />
                <BreedDiv />
            </>)
    }
}

export default BreedFind
