import React, { Component } from 'react'
import { FaBan, FaUserAlt } from 'react-icons/fa'
import { Link } from 'react-router-dom'
import './MenuDrop.css'

class MenuDrop extends Component {
    constructor(props) {
        super(props)

        this.state = {
            uuid: this.props.uuid,
        }
    }
    handleDDChange = (drop, ban) => {
        this.props.handleDD(drop, ban);
    }

    render() {
        return (

            <>
                <ul className='ActSetDiv'>
                    <li><Link style={{ textDecoration: 'none' }} to={{ pathname: '/profile/' + this.state.uuid, state: { fromUserID: this.state.uuid } }}><FaUserAlt style={{ color: 'darkorange', marginRight: '.5vh' }} /> User Information</Link></li>
                    <li onClick={() => { this.handleDDChange(false, 'ban') }} ><FaBan style={{ color: 'darkred', marginRight: '.5vh' }} /> Block User</li>
                </ul>
            </>
        )
    }
}

export default MenuDrop
