import React, { Component } from 'react'
import firebase, { auth } from '../config/firebase';
import { getDoc } from '../Functions/Functions';
import './AccountSetting.css'
import SettingElement from './SettingElement';
class AccountSetting extends Component {
    constructor(props) {
        super(props)

        this.state = {
            user: [],
            formS: '',
        }
    }


    componentDidMount() {
        this.interval = setInterval(() => {
            getDoc(firebase, auth.currentUser.uid).then(data => { this.setState({ user: data }) });
        })
    }
    render() {
        return (
            <div className=' dash-wrapper'>
                {this.state.user.length !== 0 && <div className='acc-setting'>
                    <h1>General Account Setting</h1>
                    <SettingElement
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        type='Name'
                        data={this.state.user}
                        content={`${this.state.user.first_name} ${this.state.user.middle_name} ${this.state.user.last_name}`} />
                    <div className='set-div'></div>
                    <SettingElement
                        type='Password'
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        data={this.state.user}
                        content={`${this.state.user.password}`} />
                    <div className='set-div'></div>
                    <SettingElement
                        type='Birthdate'
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        data={this.state.user}
                        content={`${this.state.user.birthday && this.state.user.birthday.toDate().toDateString()}`} />
                    <div className='set-div'></div>
                    <SettingElement
                        type='Contact Number'
                        data={this.state.user}
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        content={`${this.state.user.contact}`} />
                    <div className='set-div'></div>
                    <SettingElement
                        type='Email Address'
                        data={this.state.user}
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        content={`${this.state.user.email}`} />
                    <div className='set-div'></div>
                    {/* <SettingElement
                        type='Address'
                        data={this.state.user}
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        content={`${this.state.user.address}, Brgy. ${this.state.user.baranggay}, ${this.state.user.city}, Bataan`} />
                    <div className='set-div'></div>*/}
                    <SettingElement
                        type='Map Location'
                        data={this.state.user}
                        formSelected={this.state.formS}
                        formS={(a) => { this.setState({ formS: a }) }}
                        content={`${this.state.user.location && this.state.user.location.address}`} />
                    <div className='hr'></div>
                </div>}
            </div>
        )
    }
}

export default AccountSetting
