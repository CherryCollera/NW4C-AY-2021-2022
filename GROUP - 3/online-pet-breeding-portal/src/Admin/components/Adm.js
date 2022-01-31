import React, { Component } from 'react'
import AdmHome from './AdmHome'
import AdmPets from './AdmPets'
import AdmReports from './AdmReports'
import AdmUsers from './AdmUsers'
import SideBar from './SideBar'

class Adm extends Component {
    constructor(props) {
        super(props)

        this.state = {
            admOn: 'a'
        }
    }

    handleNavs() {
        var path = window.location.pathname;

        if (path.length >= 8) {
            path = path.substring(7, path.length);
            path = path.charAt(0).toUpperCase() + path.slice(1);
            this.setState({ admOn: path });
        } else {
            this.setState({
                admOn: 'Home'
            });
        }
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            this.handleNavs();
        })
    }
    render() {
        return (
            <div style={{ display: 'flex', }}>
                <SideBar admOn={this.state.admOn} />
                <div style={{ left: 0, display: 'flex', position: 'absolute', top: '8vh', right: 0, bottom: 0, overflow: 'auto', flexDirection: 'column' }}>
                    {this.state.admOn === 'Home' && <AdmHome />}
                    {this.state.admOn === 'Users' && <AdmUsers />}
                    {this.state.admOn === 'Reports' && <AdmReports />}
                    {this.state.admOn === 'Pets' && <AdmPets />}
                    {this.state.admOn === 'Statistics' && <></>}
                </div>
            </div>
        )
    }
}

export default Adm
