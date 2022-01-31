import React, { Component } from 'react'
import firebase, { auth } from "../config/firebase";
import { getDoc } from '../Functions/Functions';
import './BreedDash.css'

class BreedRecords extends Component {
    constructor(props) {
        super(props)

        this.state = {
            user: [],
        }
        this.getPetsData = this.getPetsData.bind(this);

    }
    async getPetsData(a, b) {
        const doc = await firebase.doc(`Pets/${b}`).get();
        if (!doc.empty) {
            this.setState({ other_pet: doc.data() });
        }
        const doc2 = await firebase.doc(`Pets/${a}`).get();
        if (!doc2.empty) {
            this.setState({ pet: doc2.data() });
        }
    }
    thandleClick() {
        window.location.href = '/breed';
    }

    componentDidMount() {
        auth.onAuthStateChanged(user => {
            if (this.props.data.sender === user.uid) {
                getDoc(firebase, this.props.data.reciever).then(data => {
                    this.setState({ user: data })
                    this.getPetsData(this.props.data.myPet, this.props.data.otherPet);
                })
            } else {
                getDoc(firebase, this.props.data.sender).then(data => {
                    this.setState({ user: data })
                    this.getPetsData(this.props.data.otherPet, this.props.data.myPet);
                })

            }
        })
    }

    render() {
        return (
            <li className='breedRecords' onClick={() => { this.thandleClick() }}>
                {this.state.user.profile && this.state.other_pet && this.state.pet ? <div className='dp-wrapper' >
                    <img className='adProp' src={this.state.user.profile} alt='dp' />
                    <div className='isOnline'></div>
                </div> : <div style={{ backgroundColor: this.state.user.bgColor }} className='dp-wrapper' >
                    {this.state.user.first_name !== undefined && this.state.user.first_name[0]}
                    <div className='isOnline'></div>
                </div>}
                {this.props.used === 'req' && <span className='breedRecords_span'>
                    You requested for {this.state.user.first_name}'s {this.state.other_pet && this.state.other_pet.breed}(<strong>{this.state.other_pet && this.state.other_pet.name}</strong>) to breed with your {this.state.pet && this.state.pet.breed}(<strong>{this.state.pet && this.state.pet.name}</strong>)
                </span>}
            </li>
        )
    }
}

export default BreedRecords
