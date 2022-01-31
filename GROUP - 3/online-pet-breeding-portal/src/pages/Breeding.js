import React, { Component } from 'react'
import BreedingForm from '../components/BreedingForm'
import Navbar from '../components/Navbar'

export class Breeding extends Component {
    render() {
        return (
            <>
                <Navbar sd='dash' hd='Breed' />
                <BreedingForm />
            </>
        )
    }
}

export default Breeding
