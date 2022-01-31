import React, { Component } from 'react'
import './AdmReports.css'
import MenuDrop from './MenuDrop';

class AdmReports extends Component {

    handleAllSetting = (uid) => {
        const a = uid;
        return (
            <MenuDrop uid={a} />
        )
    }
    render() {
        return (
            <div className='box'>

            </div>
        )
    }
}

export default AdmReports
