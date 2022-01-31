import React, { Component } from 'react'
import './ANavBar.css'
import logo from '../../images/logo.png'
import logo2 from '../../images/icon.png'
import * as IC from 'react-icons/fa'
import firebase, { auth } from '../../config/firebase'
import { getDoc } from '../../Functions/Functions'

export class ANavBar extends Component {

    constructor(props) {
        super(props)

        this.state = {
            adminData: [],
        }
    }
    handleLogout() {
        auth.signOut().then(d => {
            window.location.href = '/';
        }).catch(err => {
            console.log(err);
        });
    }

    componentDidMount() {
        auth.onAuthStateChanged(user => {
            if (user) {
                getDoc(firebase, user.uid).then(doc => {
                    this.setState({ adminData: doc });
                })
            }
        })
    }

    render() {
        return (
            <div id='adminNav' className='NavBar'>
                <div className='nav-wrapper'>
                    {/* {this.props.back && <a href={this.props.backto} className='ADMback'><IC.FaArrowLeft className='a' /></a>} */}
                    <a href='/' className='logo1'><img src={logo} alt='logo' /></a>
                    <a href='/' className='logo2'><img src={logo2} alt='logo' /></a>
                </div>
                {this.props.admin && this.state.adminData && <div className='Admprofile'>
                    <span><IC.FaUser className='admPIc' title='Profile' />
                        {this.state.adminData.name}</span>
                    <IC.FaSignOutAlt className='admPIc' title='Log-out' onClick={() => { this.handleLogout() }} />
                </div>}
            </div>
        )
    }
}

export default ANavBar
