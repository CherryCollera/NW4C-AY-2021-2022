import React, { Component } from 'react'
import firebase from '../../config/firebase'
import './BanForm.css'
class BanForm extends Component {
    constructor(props) {
        super(props)

        this.state = {
            violation: '',
            duration: 0,
            name: this.props.user.first_name + " " + this.props.user.middle_name + " " + this.props.user.last_name,
            address: this.props.user.address + ", " + this.props.user.baranggay + ", " + this.props.user.city,
            id: this.props.user.uid,
        }
        this.handleBlock = this.handleBlock.bind(this);
        this.disableUser = this.disableUser.bind(this);
    }
    async disableUser(a, b, c) {
        const ban = firebase.collection(`banned`);
        const ref = firebase.doc(`users/${c}`);
        const doc = await ref.get();
        if (doc.exists) {
            try {
                ban.add({
                    // confirmed: false,
                    uid: c,
                    violation: b,
                    violationStarts: new Date(),
                    violationEnds: a,
                })
                    .then((ban) => {
                        firebase.doc(`banned/${ban.id}`).set({ id: ban.id }, { merge: true });
                        ref.set({
                            banned: true,
                            banID: ban.id,
                        }, { merge: true })
                            .then((data) => {
                                alert('Users has been successfully banned');
                                this.handleDDChange(false);
                            })
                    })
            } catch (err) {
                console.log(err);
            }
        }
    }

    handleBlock() {
        var w = new Date();
        if (!this.state.duration || !this.state.violation) {
            alert('Please fill all fields');
        } else {
            if (this.state.duration === '1') {
                w.setDate(w.getDate() + 1);
                this.disableUser(w, this.state.violation, this.state.id)
            } else if (this.state.duration === '7') {
                w.setDate(w.getDate() + 7);
                this.disableUser(w, this.state.violation, this.state.id)
            } else if (this.state.duration === '30') {
                w.setMonth(w.getMonth() + 1);
                this.disableUser(w, this.state.violation, this.state.id)
            } else {
                this.disableUser('undefined', this.state.violation, this.state.id)
            }

        }
    }
    handleDDChange = (ban) => {
        this.props.handleDD(ban);
    }

    render() {
        return (
            <div className="ban-wrapper">
                <div className="banForm">
                    {this.props.user && <div className="log-in">
                        <h1 className='hr'>Ban User</h1>
                        <span><b>Name : </b>{this.state.name}</span>
                        <span><b>Address : </b>{this.state.address}</span>
                        <span><b>UserID : </b>{this.state.id}</span>
                        <span><b>Reason : </b>
                            <select className='banSelect'
                                defaultValue=''
                                onChange={(e) => { this.setState({ violation: e.target.value }) }}>
                                <option value='' >Select Violation</option>
                                <option value='Verbal Abuse'>Verbal Abuse</option>
                                <option value='Fake Account'>Fake Account</option>
                                <option value='Duplicate Account'>Duplicate Account</option>
                                <option value='Scammer'>Scammer</option>
                            </select>
                        </span>
                        <span><b>Duration : </b>
                            <select className='banSelect'
                                defaultValue=''
                                onChange={(e) => { this.setState({ duration: e.target.value }) }}>
                                <option value='' >Select Ban Duration</option>
                                <option value={1} >1 Day</option>
                                <option value={7}>1 Week</option>
                                <option value={30}>1 Month</option>
                                <option value='undefined'>undefined</option>
                            </select>
                        </span>
                        <div className='divBtrn'>
                            <button onClick={() => { this.handleBlock() }} className='btn-log'>Ban</button>
                            <button onClick={() => { this.handleDDChange(false) }} className='btn-log'>Cancel</button>
                        </div>
                    </div>}
                </div>
            </div>
        )
    }
}

export default BanForm
