import React, { Component } from 'react'
import firebase, { auth } from "../config/firebase";
import { getDoc, getConvos } from '../Functions/Functions';
import { Link } from 'react-router-dom';
import moment from 'moment';

class Inboxes extends Component {
    constructor(props) {
        super(props)

        this.state = {
            convos: [],
            status: 6,
            user: [],
        }
    }
    getUserData(id) {
        getDoc(firebase, id).then((doc) => {
            this.setState({ user: doc })
        })
    }
    getConvos(id) {
        getConvos(firebase, id).then(messages => {
            if (messages !== 'noMessage') {
                if ((messages[0].sender === auth.currentUser.uid)) {
                    this.getUserData(messages[0].reciever);
                    this.checkStatus(messages[0].reciever);
                } else {
                    this.getUserData(messages[0].sender);
                    this.checkStatus(messages[0].sender);
                }
            }
            return this.setState({ convos: messages })
        })
    }

    // moment(this.props.posts.timestamp.toDate(), "YYYYMMDD").fromNow(),
    async checkStatus(a) {
        const status = firebase.doc(`users/${a}`);
        const stats = await status.get();
        const stat = stats.data().isOnline;
        var isOnlineLast = (stat.toDate().getTime() - new Date().getTime()) / 1000;
        isOnlineLast /= 60;
        const time = Math.abs(Math.round(isOnlineLast));
        this.setState({ status: time });
    }
    onClick() {
        if (this.props.drop) {
            this.props.hideDrop();
        } else {
            this.props.closeNewM();
        }
    }

    componentDidMount() {
        this.interval = setInterval(() => {
            auth.onAuthStateChanged(user => {
                if (user) {
                    this.getConvos(this.props.value.data().ID);
                }
            })
        })
    }

    render() {
        return <>
            {this.state.convos !== 'noMessage' && this.state.convos.map((item, index) => {
                return (
                    index === 0 && <Link key={index} className={this.props.currentMessage && this.props.currentMessage === this.props.value.data().ID ? 'msgLI msgHover' : 'msgLI'} onClick={() => { this.onClick() }} style={{ textDecoration: 'none' }} to={{ pathname: `/messages/${this.props.value.data().ID}`, state: { fromUserID: `${this.props.value.data().ID}`, hideDrop: "Messages" } }} >
                        {this.state.user.profile ?
                            <div className='dp-wrapper'>
                                <img className='adProp' src={this.state.user.profile} alt='dp' />
                                {this.state.status < 3 && <div className='isOnline'></div>}
                            </div> : <div style={{ backgroundColor: this.state.user.bgColor }} className='dp-wrapper' >
                                {this.state.user.first_name !== undefined && this.state.user.first_name[0]}
                                {this.state.status < 3 && <div className='isOnline'></div>}
                            </div>}
                        <span className={this.props.value.data().seened === false ? 'chatName unseen' : 'chatName'}>
                            <h1 className={this.props.value.data().seened === false ? 'unseen' : ''}>{this.state.user.first_name} {this.state.user.middle_name && this.state.user.middle_name[0] + '.'} {this.state.user.last_name}</h1>
                            <span>{this.state.convos[0].data !== ''
                                ? (this.state.convos[0].data.length < 15
                                    ? this.state.convos[0].data
                                    : this.state.convos[0].data.substring(0, 15) + '...')
                                : ' '} • {moment(this.state.convos[0].timestamp.toDate(), "YYYYMMDD").fromNow()} </span>
                        </span>

                    </Link >
                )
            }
            )}

        </>
    }
}

export default Inboxes
