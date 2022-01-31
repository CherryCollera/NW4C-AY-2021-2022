import React, { Component } from 'react'
import './ConvoBox.css'
import * as IC from 'react-icons/io'
import { getDoc } from '../Functions/Functions'
import ActiveUserSearch from './ActiveUserSearch'
import fireBaseDB, { auth } from "../config/firebase";
import MessageBubbleDiv from './MessageBubbleDiv'

class ConvoBox extends Component {
    constructor(props) {
        super(props)
        this.endMesRef = React.createRef();
        this.state = {
            userSearch: '',
            shwUser: false,
            userIds: [],
            selectedUser: '',
            uSER: this.props.user,
            userName: '',
            userLive: '',
            profile: '',
            bg: '',
            text: '',

            // USer Default
            defaultID: this.props.user,
            userDefault: '',
            mesID: '',
            convo: [],
            status: 6,

            // USerSElected
            selConvo: [],
            selMessa: [],
            selUser: [],
        }
        this.scrollToBottom = this.scrollToBottom.bind(this);
    }
    getActiveUSers() {
        fireBaseDB.collection("users").where("type", "!=", "admin").onSnapshot((snaps) => {
            this.setState({
                userIds: snaps.docs.map(doc => doc.data().uid),
            })
        })
    }
    scrollToBottom() {
        this.endMesRef.current.scrollIntoView({ behavior: "smooth" });
    }
    hidUSers(a) {
        this.setState({
            shwUser: true,
            userSearch: '',
        })
        this.props.selectedUser(a);
        this.getNewMessengerData(a);
    }
    connewMes(a) {
        this.props.newMes(a);
    }
    async getNewMessengerData(f) {
        const a = fireBaseDB.doc(`users/${f}`);
        const b = await a.get();
        try {
            if (b.exist) {
                console.log('No such document!');
            } else {
                const c = b.data();
                this.setState({
                    userDefault: c,
                });
            }
        }
        catch (err) {
            console.log(err);
        }
    }

    async getActiveUSer() {
        const a = auth.currentUser.uid;
        if (this.props.messID && this.props.newmEs) {
            const ref = await fireBaseDB.doc(`Messages/${this.props.messID}`).get();
            const ref2 = await fireBaseDB.collection(`Messages/${this.props.messID}/convo`).orderBy("timestamp", "asc").get();
            const b = ref.data();
            if (b.p1 === a) {
                const c = await getDoc(fireBaseDB, b.p2);
                this.setState({
                    userDefault: c, convo: ref2.docs.map(doc => doc.data())
                })
            }
            else if (b.p2 === a) {
                const c = await getDoc(fireBaseDB, b.p1);
                this.setState({
                    userDefault: c, convo: ref2.docs.map(doc => doc.data())
                })
            }
        } if (this.props.currentMessage && !this.props.newmEs) {
            const ref = await fireBaseDB.doc(`Messages/${this.props.currentMessage}`).get();
            const ref2 = await fireBaseDB.collection(`Messages/${this.props.currentMessage}/convo`).orderBy("timestamp", "asc").get();
            const b = ref.data();
            if (b.p1 === a) {
                const c = await getDoc(fireBaseDB, b.p2);
                this.setState({
                    userDefault: c, convo: ref2.docs.map(doc => doc.data())
                })
            }
            else if (b.p2 === a) {
                const c = await getDoc(fireBaseDB, b.p1);
                this.setState({
                    userDefault: c, convo: ref2.docs.map(doc => doc.data())
                })
            }
        }

    }


    async handleSend() {
        if (this.props.newmEs && this.props.selectedUserID) {
            const ref = fireBaseDB.collection(`Messages/${this.props.messID}/convo`);
            const convo = await ref.get();
            try {
                ref.add({
                    reciever: this.state.userDefault.uid,
                    sender: auth.currentUser.uid,
                    data: this.state.text,
                    timestamp: new Date(),
                }).then((data) => {
                    fireBaseDB.doc(`Messages/${this.props.messID}/convo/${data.id}`).set({ id: data.id, }, { merge: true })
                    fireBaseDB.doc(`users/${auth.currentUser.uid}/messages/${this.props.messID}`)
                        .set({ convos: convo.size + 1, timestamp: new Date(), ID: this.props.messID }, { merge: true });
                    fireBaseDB.doc(`users/${this.state.userDefault.uid}/messages/${this.props.messID}`)
                        .set({ convos: convo.size + 1, timestamp: new Date(), ID: this.props.messID, seened: false }, { merge: true });
                    this.setState({ text: '' })
                })
            } catch (err) { console.log(err) }
        } if (this.props.currentMessage && !this.props.newmEs) {

            const ref = fireBaseDB.collection(`Messages/${this.props.currentMessage}/convo`);
            const convo = await ref.get();
            try {
                ref.add({
                    reciever: this.state.userDefault.uid,
                    sender: auth.currentUser.uid,
                    data: this.state.text,
                    timestamp: new Date(),
                }).then((data) => {
                    fireBaseDB.doc(`Messages/${this.props.currentMessage}/convo/${data.id}`).set({ id: data.id, }, { merge: true })
                    fireBaseDB.doc(`users/${auth.currentUser.uid}/messages/${this.props.currentMessage}`)
                        .set({ convos: convo.size + 1, timestamp: new Date(), ID: this.props.currentMessage }, { merge: true });
                    fireBaseDB.doc(`users/${this.state.userDefault.uid}/messages/${this.props.currentMessage}`)
                        .set({ convos: convo.size + 1, timestamp: new Date(), ID: this.props.currentMessage, seened: false }, { merge: true });
                    this.setState({ text: '' })
                })
            } catch (err) { console.log(err) }
        }
    }

    Seened() {
        if (this.props.currentMessage && !this.props.newmEs) {
            fireBaseDB.doc(`users/${auth.currentUser.uid}/messages/${this.props.currentMessage}`)
                .set({ seened: true }, { merge: true });
        }
    }
    async checkStatus(a) {
        if (a) {
            const status = fireBaseDB.doc(`users/${a}`);
            const stats = await status.get();
            const stat = stats.data().isOnline;
            var isOnlineLast = (stat.toDate().getTime() - new Date().getTime()) / 1000;
            isOnlineLast /= 60;
            const time = Math.abs(Math.round(isOnlineLast));
            this.setState({ status: time });
        }

    }
    setMesID(e) {
        this.props.setMesID(e)
    }

    componentDidMount() {
        this.interval = setInterval(() => {
            auth.onAuthStateChanged(user => {
                if (user) {
                    this.getActiveUSers();
                    this.getActiveUSer();
                    this.Seened();
                    this.checkStatus(this.state.userDefault.uid);
                    // console.log(this.state.userDefault.uid);
                    // console.log(this.state.status);
                }
            })
        });
    }
    render() {
        return (
            <>{(this.props.currentMessage && !this.props.newmEs) && <>
                <div className="convoBox">
                    <div className="convoHead">
                        {this.state.userDefault && <><span>
                            {this.state.userDefault.profile ? <div className='dp-wrapper'>
                                <img className='adProp' src={this.state.userDefault.profile} alt='dp' />
                                {this.state.status <= 60 && <div className='isOnline'></div>}
                            </div> : <div style={{ backgroundColor: this.state.userDefault.bgColor }} className='dp-wrapper' >
                                {this.state.userDefault.first_name !== undefined && this.state.userDefault.first_name[0]}
                                {this.state.status <= 60 && <div className='isOnline'></div>}
                            </div>}
                            <span className='AcNae'>{this.state.userDefault.first_name ? this.state.userDefault.first_name : ''}
                            </span>
                        </span>
                            {/* <IC.IoMdInformationCircle onClick={(a) => { this.props.hidSet(true) }} className='msgInfor' /> */}
                        </>}
                    </div>
                    <MessageBubbleDiv statasad={this.state.status} userDefault={this.state.userDefault} convo={this.state.convo} />
                    <div className="convoTail">
                        {/* <IC.IoIosAddCircle className='msgInfor' /> */}
                        <input type='text' className='msgIn' placeholder="Write something . . ." onChange={(e) => this.setState({ text: e.target.value })} value={this.state.text} />
                        <IC.IoMdSend onClick={() => { this.handleSend() }} className='msgIC' />
                    </div >
                </div>
            </>}
                {(this.props.newmEs || !this.props.currentMessage) &&
                    <div className="convoBox">
                        <div className="convoHead">
                            {(this.props.newmEs) && (!this.props.selectedUserID ? <div className='newMesCon'>
                                To:
                                <input type='text' value={this.state.userSearch} onChange={(e) => { this.setState({ userSearch: e.target.value }) }} />
                                {this.state.userSearch && <ul className='dropUSerUL'>
                                    {this.state.userIds && this.state.userIds.map((item, index) => {
                                        return <ActiveUserSearch
                                            used='newUser'
                                            resetAdd={(a) => { this.connewMes(a) }}
                                            hidUsers={(a) => { this.hidUSers(a) }}
                                            mesID={(e) => { this.setMesID(e) }}
                                            userId={item}
                                            key={index}
                                            search={this.state.userSearch} />
                                    })}
                                </ul>}
                            </div> : <>
                                {this.state.userDefault && <><span>
                                    {this.state.userDefault.profile ? <div className='dp-wrapper'><img className='adProp' src={this.state.userDefault.profile} alt='dp' /></div> : <div style={{ backgroundColor: this.state.userDefault.bgColor }} className='dp-wrapper' >{this.state.userDefault.first_name !== undefined && this.state.userDefault.first_name[0]}</div>}
                                    <span className='AcNae'>{this.state.userDefault.first_name ? this.state.userDefault.first_name : ''}
                                    </span>
                                </span>
                                    {/* <IC.IoMdInformationCircle onClick={(a) => { this.props.hidSet(true) }} className='msgInfor' /> */}
                                </>}
                            </>)}
                        </div>
                        {this.props.selectedUserID && <><MessageBubbleDiv statasad={this.state.status} userDefault={this.state.userDefault} convo={this.state.convo} />
                            <div className="convoTail">
                                {/* <IC.IoIosAddCircle className='msgInfor' /> */}
                                <input type='text' className='msgIn' placeholder="Write something . . ." onChange={(e) => this.setState({ text: e.target.value })} value={this.state.text} />
                                <IC.IoMdSend onClick={() => { this.handleSend() }} className='msgIC' />
                            </div ></>}
                    </div >
                }
            </>
        )
    }
}

export default ConvoBox
