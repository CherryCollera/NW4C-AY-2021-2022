import React, { Component } from 'react'
import './DropDownDiv.css'
import * as iOIC from 'react-icons/io'
import firebase, { auth } from "../config/firebase";
import { Link } from 'react-router-dom'
import Inboxes from './Inboxes'
import NotificationDiv from './NotificationDiv';
// import { Messages } from '../data/NavData'

class DropDownDiv extends Component {
    constructor(props) {
        super(props)

        this.state = {
            convos: [],
            messages: [],
            user: [],
            pending: [],
            drop: props.drop,
            firstM: '',
            noMes: '',
            initialPet: false,
        }
    }

    handlelogout() {
        try {
            auth.onAuthStateChanged(user => {
                auth.signOut().then(() => {
                    window.location.href = '/';
                }).catch((error) => {
                    console.log(error.code + ': ' + error.message)
                });

            })
        } catch (error) { console.log(error) }
    }

    async getAllMEssages() {
        const mesRef = await firebase
            .collection(`users/${auth.currentUser.uid}/messages/`)
            .orderBy("timestamp", "desc")
            .get();
        if (!(mesRef.empty)) {
            this.setState({ messages: mesRef.docs, firstM: mesRef.docs[0].data().ID })
        } else {
            this.setState({ messages: 'noMessage', noMes: 'noMessage' })
        }
    }

    async getPets(a) {
        const pets = await firebase.collection("Pets").where("owner", "==", a).limit(1).get();
        this.setState({ pets: pets.docs.map(doc => doc.data()) });
    }


    getPending() {
        firebase.collection("Notifications").where("to", "==", auth.currentUser.uid).onSnapshot(snaps => {
            if (!snaps.empty) {
                this.setState({ pending: snaps.docs.map(doc => doc.data()) });
            }
        })
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            auth.onAuthStateChanged(user => {
                if (user) {
                    if (this.props.drop === 'Messages') {
                        this.getAllMEssages();
                    }
                    if (this.props.drop === 'Setting') {
                        this.getPets(user.uid);
                    }
                    if (this.props.drop === 'Notification') {
                        this.getPending();
                    }
                }
            })
        })
    }
    render() {
        return (
            <div id={this.props.drop} className='drop'>
                <p className='droTitle'>{this.props.drop}</p>
                <div className='har'></div>
                {this.props.drop === 'Setting' && this.state.pets &&
                    <>
                        <Link className='setOPt'
                            to={{
                                pathname: `/settings`,
                            }}>
                            <iOIC.IoIosPerson />
                            <span>Profile Setting </span>
                        </Link>
                        {this.props.user && this.props.user.type !== 'veterinarian' && (this.state.pets.length <= 0 ?
                            <Link className='setOPt'
                                onClick={() => { this.props.hideDrop() }}
                                to={{ pathname: `/pets` }}>
                                <iOIC.IoMdPaw />
                                <span>Pet Setting</span>
                            </Link> :
                            <Link className='setOPt'
                                onClick={() => { this.props.hideDrop() }}
                                to={{ pathname: `/pets/${this.state.pets[0].PetId}` }}>
                                <iOIC.IoMdPaw />
                                <span>Pet Setting</span>
                            </Link>)}
                        <div onClick={() => { this.handlelogout() }} className='setOPt'><iOIC.IoMdLogOut /><span>Logout</span></div>
                    </>}
                {this.props.drop === 'Messages' && <><ul className='messUl'>
                    {this.state.noMes !== 'noMessage' && this.state.messages !== 'noMessage' ? (this.state.messages.map((item, index) => { return item.convos !== 0 && <Inboxes uses='dropdown' drop={true} hideDrop={() => { this.props.hideDrop() }} key={index} handleFirst={(a) => { this.getFirstM(a) }} value={item} /> }))
                        :
                        <li className='mNoMes hr'>
                            <span>No Message(s)</span>
                        </li>
                    }
                </ul>
                    {<Link className='seeMEs' onClick={() => { this.props.hideDrop() }} to={{ pathname: `/messages/${this.state.firstM && this.state.firstM}`, state: { fromUserID: `${this.state.firstM && this.state.firstM}`, hideDrop: "Messages" } }}>
                        See in Messenger
                    </Link>}

                </>}
                {this.props.drop === 'Notification' && <><ul className='Notif_UL'>
                    {this.state.pending.length > 0 ? this.state.pending.map((d, i) => <NotificationDiv key={i} data={d} />) : <li className='mNoMes hr'>
                        <span>No Notification(s)</span>
                    </li>}
                </ul>
                    {this.props.user && this.props.user.type !== 'veterinarian' && <Link className='seeMEs' onClick={() => { this.props.hideDrop() }} to={{ pathname: `/breed` }}>
                        View Breeding
                    </Link>}
                </>}
            </div>
        )
    }
}

export default DropDownDiv
