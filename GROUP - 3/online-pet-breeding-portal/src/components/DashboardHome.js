import React, { Component } from 'react'
import fb from "../config/firebase";
import moment from 'moment';
import { getDoc } from '../Functions/Functions';
import MenuPost from './MenuPost';

class DashboardHome extends Component {
    constructor(props) {
        super(props)

        this.state = {
            userDefault: []
        }

    }
    componentDidMount() {
        var Filter = require('bad-words'),
        filter = new Filter();
        
        this.interval = setInterval(() => {
            this.setState({comment : filter.clean(this.props.value.comment) });
            getDoc(fb, this.props.value.userID).then(doc => {
                this.setState(
                    {
                        userDefault: doc,
                        dateposted: moment(this.props.value.timestamp.toDate(), "YYYYMMDD").fromNow(),
                    }
                )
            })
        })
    }
    componentWillUnmount() {
        clearInterval(this.interval);
    }

    render() {
        return (
            <div className='Msg send commentsasd'>
                {this.state.userDefault && this.state.userDefault.type === 'admin' ? <div style={{ textTransform: "capitalize", zoom: ".85", backgroundColor: "var(--primaryColor)" }} className='dp-wrapper' >{this.state.userDefault.name && this.state.userDefault.name[0]}</div> : (this.state.userDefault.profile ? <div className='dp-wrapper' style={{ border: 'none' }}><img className='adProp' src={this.state.userDefault.profile} alt='dp' /></div> : <div style={{ zoom: ".85", backgroundColor: this.state.userDefault.bgColor }} className='dp-wrapper' >{this.state.userDefault.first_name !== undefined && this.state.userDefault.first_name[0]}</div>)}
                <div className='msgBubble sent'>{this.state.comment}</div> • {this.state.dateposted}
                {this.state.userDefault && <MenuPost data={this.props.posts}  poster={this.props.posterData} comment={this.props.value} user={this.props.currentUser} used="comment"/>}
            </div>
        )
    }
}

export default DashboardHome
