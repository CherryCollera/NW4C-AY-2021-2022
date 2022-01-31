import React, { Component } from 'react'
import firebase from '../../config/firebase'
import * as IC1 from 'react-icons/fa'
import Duration from './Duration'

class ListElement extends Component {
    constructor(props) {
        super(props)

        this.state = {
        }
    }
    async getViolations(a) {
        const ref = await firebase.doc(`banned/${a}`).get();
        this.setState({ violation: ref.data() })
    }
    async handleUnblock(a, b) {
        const ban = firebase.doc(`banned/${a}`);
        const ref = firebase.doc(`users/${b}`);
        const doc = await ref.get();
        if (doc.exists) {
            try {
                ban.set({ status: 'fulfilled' }, { merge: true });
                ref.set({
                    banned: false,
                    banID: '',
                }, { merge: true })
                    .then((data) => {
                        alert('Users has been successfully unbanned');
                        this.setState({ unblkForm: false });
                    })
            } catch (err) {
                console.log(err);
            }
        }
    }

    componentDidMount() {
        this.interval = setInterval(() => {
            if (this.props.data) {
                this.getViolations(this.props.data.banID);
            }
        })
    }

    render() {
        const name = this.props.data.first_name + ' ' + this.props.data.middle_name + ' ' + this.props.data.last_name;
        const address = this.props.data.address + ', ' + this.props.data.baranggay + ', ' + this.props.data.city;
        return (
            <>
                {this.props.data && this.state.violation && <div className='allUTab'>
                    <span style={{ gridColumn: '1/9' }} title='Username'>{name}</span>
                    <span style={{ gridColumn: '9/12' }} title='User Type'>
                        {this.props.data.type === 'pet-owner' && <div style={{ borderColor: 'transparent', backgroundColor: "transparent", fontSize: "1.75vh", color: "red", margin: "0 1vh" }}><IC1.FaHeart /></div>}
                        {this.props.data.type === 'veterinarian' && <div style={{ borderColor: 'transparent', backgroundColor: "transparent", color: "teal", fontSize: "1.75vh", margin: "0 1vh" }}><IC1.FaSyringe /></div>}
                        {this.props.data.type === 'pet-breeder' && <div style={{ borderColor: 'transparent', backgroundColor: "transparent", color: "saddlebrown", fontSize: "1.75vh", margin: "0 1vh" }}><IC1.FaPaw /></div>}
                        {this.props.data.type}
                    </span>
                    <span style={{ gridColumn: '12/15' }} title='Violation'>{this.state.violation.violation}</span>
                    <span style={{ gridColumn: '15/18' }} title='Duration' >
                        {this.state.violation.violationEnds === 'undefined'
                            ? <span className='ofl'>Undefined</span>
                            : <Duration unblock={() => { this.handleUnblock(this.state.violation.id, this.state.violation.uid) }} duration={this.state.violation.violationEnds.toDate()} />}
                    </span>
                    <span style={{ gridColumn: '18/21' }} ><p onClick={() => { this.setState({ unblkForm: true }) }} className='actsetting'>Unblock</p></span>
                </div>}

                {this.state.unblkForm &&
                    <div className="ban-wrapper" style={{ zIndex: 11 }}>
                        <div className="banForm">
                            <div className="log-in">
                                <h1 style={{ color: "var(--blaclk)" }} className='hr'>Unban User</h1>
                                <span><b>Name : </b>{name}</span>
                                <span><b>Address : </b>{address}</span>
                                <span><b>UserID : </b>{this.props.data.uid}</span>
                                <span><b>Violation : </b>{this.state.violation.violation}</span>
                                <span><b>Duration : </b>{this.state.violation.violationEnds === 'undefined'
                                    ? 'Undefined'
                                    : <Duration duration={this.state.violation.violationEnds.toDate()} />}</span>
                                <div className='divBtrn'>
                                    <button onClick={() => { this.handleUnblock(this.state.violation.id, this.state.violation.uid) }} className='btn-log'>Unban</button>
                                    <button onClick={() => { this.setState({ unblkForm: false }) }} className='btn-log'>Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>}
            </>
        )
    }
}

export default ListElement
