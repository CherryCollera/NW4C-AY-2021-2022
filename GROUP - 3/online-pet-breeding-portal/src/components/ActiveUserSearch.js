import React, { Component } from 'react'
import './ActiveUserSearch.css'
import fireBaseDB, { auth } from "../config/firebase";
import { Link } from 'react-router-dom'

class ActiveUserSearch extends Component {

    constructor(props) {
        super(props)

        this.state = {
            serch: this.props.search,
            userName: '',
            userEmail: '',
            uuid: '',
            profile: '',
            bg: '',
            mesID: '',
        }
    }

    async getActiveUSerPet() {
        const a = fireBaseDB.doc(`users/${this.props.userId}`);
        const b = await a.get();
        try {
            if (b.exist) {
                console.log('No such document!');
            } else {
                const c = b.data();
                this.setState({
                    userName: c.first_name + ' ' + c.last_name,
                    userEmail: c.email,
                    profile: c.profile,
                    mID: Date.now(),
                    bg: c.bgColor,
                });
            }
        }
        catch (err) {
            console.log(err);
        }
    }

    hiddenUser() {
        this.props.hidUsers(this.props.userId);
        this.props.mesID(this.state.mesID)
    }


    async createMessage() {
        const sendRef = await fireBaseDB.collection("Messages").where("p1", "==", this.props.userId).where("p2", "==", auth.currentUser.uid).get();
        const reciRef = await fireBaseDB.collection("Messages").where("p1", "==", auth.currentUser.uid).where("p2", "==", this.props.userId).get();
        const msgRef = fireBaseDB.collection("Messages");
        if (!sendRef.empty) {
            this.setState({ mesID: sendRef.docs[0].data().ID });
        } else if (!reciRef.empty) {
            this.setState({ mesID: reciRef.docs[0].data().ID });
        } else {
            try {
                msgRef.add({
                    p1: auth.currentUser.uid,
                    p2: this.props.userId,
                    timestamp: new Date()
                }).then(mes => {
                    fireBaseDB.doc("users/" + auth.currentUser.uid + "/messages/" + mes.id).set({ ID: mes.id, convos: 0 }, { merge: true })
                    fireBaseDB.doc("Messages/" + mes.id).set({ ID: mes.id, }, { merge: true })
                    this.setState({ mesID: mes.id });
                })
            } catch (error) {
                console.log("Error in creating message info", error);
            };
        }
    }

    componentDidMount() {
        auth.onAuthStateChanged(user => {
            if (user) {
                this.getActiveUSerPet();
                this.createMessage();
            }
        })
    }


    render() {
        return (
            <>
                {(this.state.userName.toLowerCase().includes(this.props.search) || this.state.userName.includes(this.props.search)) && <li key={this.props.index} className='dropUSer' onClick={() => { this.hiddenUser() }}>
                    {this.state.mesID && <Link className='dropUSer' style={{ textDecoration: 'none' }} to={{ pathname: '/messages/' + this.state.mesID, state: { hideDrop: "Messages" } }}>
                        {this.state.profile ? <div style={{ width: "4.5vh", height: "4.5vh" }} className='dp-wrapper'>
                            <img className='adProp' src={this.state.profile} alt='dp' /></div>
                            :
                            <div style={{ backgroundColor: this.state.bg, width: "4.5vh", height: "4.5vh" }} className='dp-wrapper' >
                                {this.state.userName && this.state.userName[0]}
                            </div>}
                        <span>{this.state.userName}</span>
                    </Link>}
                </li>
                }
            </>
        )
    }
}

export default ActiveUserSearch
