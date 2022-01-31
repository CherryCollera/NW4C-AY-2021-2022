import React, { Component } from 'react'
import firebase, { auth } from "../config/firebase";
import './BreedDash.css'
import BreedRecords from './BreedRecords';
// const fs = require('fs');
// const path = require('path');



class BreedDash extends Component {
    constructor(props) {
        super(props)

        this.state = {
            request: [],
            users: [],
        }
    }


    getRequest() {
        firebase.collection("Breed").where("sender", "==", auth.currentUser.uid).limit(2).onSnapshot(snaps => {
            if (!snaps.empty) {
                this.setState({ request: snaps.docs.map(doc => doc.data()) });
            }
        })
    }
    componentDidMount() {
        this.getRequest();
    }

    render() {
        return (
            <div className='breedDash'>
                <h1 className='breedDash_header'>Breeding Records</h1>
                <ul className='breed_req-container'>
                    {this.state.request.length > 0 ? this.state.request.map((data, index) => {
                        return <BreedRecords key={index} data={data} used="req" />
                    }) : <div className='noRecords'>No Records Yet</div>}
                </ul>
                <center className='btAdp breedBTn'>
                    <a href='/breed' className='btn-log' type='button' >Breeding</a>
                </center>
            </div>
        )
    }
}

export default BreedDash
