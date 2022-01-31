import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import { sideNavs } from '../data/data'
import './Sidebar.css'

class SideBar extends Component {
    render() {
        return (
            <div className='sideB'>
                <h1>Admin </h1>
                <ul>
                    {sideNavs.map((item, index) => { return <li className={this.props.admOn === item.label ? 'on' : ''} key={index}><Link className='linkaadm' to={{ pathname: item.to }}> {item.icon} <span>{item.label}</span></Link></li> })}
                </ul>
            </div>
        )
    }
}

export default SideBar
