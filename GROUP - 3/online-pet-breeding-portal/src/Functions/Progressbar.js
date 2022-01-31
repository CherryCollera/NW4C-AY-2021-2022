import React, { Component } from 'react'
import ProgressBarDiv from '../components/ProgressBarDiv';

class Progressbar extends Component {
    constructor(props) {
        super(props)
        this.state = {
            progVal: this.props.start,
            progEnd: this.props.end,
            used: this.props.used,
            dataCount: 0,
            datae: ['Collecting User data', 'Collecting User data', 'Creating user account', 'Creating user account', 'Finishing user account', 'Finishing user account', 'Finishing user account', 'Account Created']
        }
    }


    componentDidMount() {
        this.interval = setInterval(() => {
            if (this.state.progVal < this.state.progEnd) {
                this.setState({
                    progVal: this.state.progVal + 15,
                    dataCount: this.state.dataCount + 1,
                })
            } else if (this.state.progVal > this.state.progEnd && this.state.used === 'reg') {
                clearInterval(this.interval);
                window.location.href = '/Welcome'
            }

        }, 1000);

        // if(this.props.pet){
        //     this.timeout = setTimeout(() =>{
        //         window.location.reload();
        //     }, 5000)
        // }
    }
    render() {
        return <ProgressBarDiv used={this.state.used} data={this.state.datae[this.state.dataCount]} value={this.state.progVal} />

    }
}

export default Progressbar
