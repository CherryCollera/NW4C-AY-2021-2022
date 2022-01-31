import React, { Component } from 'react'
import './Feedback.css'
import * as ioIcons from 'react-icons/io5'
import BeautyStars from "beauty-stars";
import firebase, { auth } from "../config/firebase";

class Feedback extends Component {
    constructor(props) {
        super(props)

        this.state = {
            value: 0,
            desc: '',
        }
        this.handleSubmit = this.handleSubmit.bind(this);
    }
    handleSubmit(event) {
        var uid = this.props.pet.PetId;
        const rateRef = firebase.collection(`Pets/${uid}/rates`);
        if (this.props.used === 'onh' || this.props.used === 'fin') {
            if (this.state.value <= 0) {
                alert('Please give rate value');
            } else if (!uid) {
                alert('No data found');
            } else {
                try {
                    rateRef.add({
                        value: this.state.value,
                        desc: this.state.desc,
                        breedID: this.props.breedID,
                        timestamp: new Date(),
                        rater: auth.currentUser.uid,
                    }).then(rate => {
                        firebase.doc(`Pets/${uid}/rates/${rate.id}`).set({ rateID: rate.id, }, { merge: true });
                        if (this.props.used === 'onh') {
                            this.props.fin();
                        }
                        this.props.hideFeed();
                    })
                } catch (error) {
                    console.log("Error in creating pet info", error);
                };
                alert('Thank you for your response');
            }
        } else if (this.props.used === 'req') {
            this.props.fin(this.state.desc);
            this.props.hideFeed();
        } else if (this.props.used === 'pen') {
            this.props.fin(this.state.desc);
            this.props.hideFeed();
        }
        event.preventDefault();
    }

    render() {
        return (
            <div className='feedback-wrapper'>
                <form onSubmit={this.handleSubmit} className='log-in feebackForm' >
                    <div className="breed-header">

                        {this.props.used === 'pen' && <h2 className='feed_header'>Decline Breed Request?</h2>}
                        {this.props.used === 'req' && <h2 className='feed_header'>Cancel Breed Request?</h2>}
                        <ioIcons.IoCloseSharp
                            onClick={() => { this.props.hideFeed(); }}
                            title='Close'
                            className='feedClose' />
                    </div>
                    {(this.props.used === 'fin' || this.props.used === 'onh') && (this.props.pet.profile ? <img className='img' src={this.props.pet.profile} alt='dp' /> :
                        <div style={{ backgroundColor: this.props.pet.bgColor }} className='img' >{this.props.pet.name && this.props.pet.name[0]}</div>)}
                    <div className='star_rate_container'>
                        {(this.props.used === 'fin' || this.props.used === 'onh') &&
                            <BeautyStars
                                inactiveColor="var(--borderColor)"
                                activeColor="var(--primaryTextColor)"
                                value={this.state.value}
                                onChange={value => this.setState({ value })} />}
                        <p>How's it going?</p>
                        <textarea
                            onChange={(e) => { this.setState({ desc: e.target.value }) }}
                            id='adInp'
                            type='text'
                            className='adInp'
                            placeholder={`Tell us your thoughts` + (this.props.used === 'req' ? ' for cancelling request' : '') +
                                (this.props.used === 'pen' ? ' for declining request' : '') +
                                (this.props.used === 'fin' ? ` for ${this.props.pet.name}` : '')} >
                        </textarea>
                        <button className='btn-log'>Submit</button>
                    </div>
                </form >
            </div >
        )
    }
}

export default Feedback
