import React, { Component } from 'react'
import './Map'
import './MapInfoWindow.css'
import { Link } from 'react-router-dom';
import { auth } from "../config/firebase";
// import { SphericalUtil } from 'node-geometry-library';

class MapInfoWindow extends Component {
    constructor(props) {
        super(props)

        this.state = {
            status: 6,
        }
    }
    async checkStatus() {
        const stat = this.props.user.isOnline;
        var isOnlineLast = (stat.toDate().getTime() - new Date().getTime()) / 1000;
        isOnlineLast /= 60;
        const time = Math.abs(Math.round(isOnlineLast));
        this.setState({ status: time });
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            auth.onAuthStateChanged(user => {
                if (user) {
                    this.checkStatus();
                }
            });
        });
    }
    render() {
        return (
            <div className='userInfoMap'>
                {this.props.user.profile ? <div className='locImg' > <img src={this.props.user.profile} alt='dp' />
                    {this.state.status < 3 && <div className='isOnline'></div>}
                </div> :
                    <div>
                        <div style={{ backgroundColor: this.props.user.bgColor }} className='locImg' >{this.props.user.first_name && this.props.user.first_name[0]}
                            {this.state.status < 3 && <div className='isOnline'></div>}
                        </div>
                    </div>}
                <span className='locName'>{this.props.user.uid === auth.currentUser.uid ? 'You' : this.props.user.first_name}</span>
                <Link className='locBtn'
                    to={this.props.user.uid === auth.currentUser.uid
                        ? { pathname: `/profile` }
                        : { pathname: `/profile/${this.props.user.uid}`, state: { fromUserID: `${this.props.user.uid}` } }
                    }
                >View Profile</Link>
            </div>
        )
    }
}

export default MapInfoWindow
