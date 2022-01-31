import React, { Component } from 'react'
import './BreadCrumb.css';
export class BreadCrumbs extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
            breads: props.breadas,             
        }
    }
    
    render() {
        return (
            <>
            <ul className="breadcrumb">
            {this.state.breads.map((link, index) => 
                (
                <li key={index}><a href="/">{link.li}</a></li>
            ))}
            </ul>
            </>
        )
    }
}

export default BreadCrumbs
