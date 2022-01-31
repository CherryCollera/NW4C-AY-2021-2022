import React, { Component } from 'react'
import fireBaseDB from "../../config/firebase";

class OnlineStatus extends Component {
    constructor(props) {
        super(props)

        this.state = {
            status: 11,
        }
    }


    async checkStatus(a) {
        const status = fireBaseDB.doc(`users/${a}`);
        const stats = await status.get();
        const stat = stats.data().isOnline;
        if (stat !== undefined) {
            var isOnlineLast = (stat.toDate().getTime() - new Date().getTime()) / 1000;
            isOnlineLast /= 60;
            const time = Math.abs(Math.round(isOnlineLast));
            this.setState({ status: time });
        }
    }

    componentDidMount() {
        this.interval = setInterval(() => {
            if (this.props.userID) {
                this.checkStatus(this.props.userID);
            }
        });
    }
    render() {
        return (<>
            {this.props.userID && <span style={{ gridColumn: '14/16' }} title='Status' >{!(this.state.status < 10) ? <div className='ofl'>Offline</div> : <div className='onl'>Online</div>} </span>}
        </>
        )
    }
}

export default OnlineStatus
