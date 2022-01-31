import React, { Component } from 'react'
import './AdmUsers.css'
import * as IC1 from 'react-icons/fa'
import { allUserEX, banUserE, pendingUserEx } from '../data/data'
import MenuDrop from './MenuDrop'
import BanForm from './BanForm'
import ListElement from './ListElement'
import firebase from '../../config/firebase'
import OnlineStatus from './OnlineStatus'
class AdmUsers extends Component {
    constructor(props) {

        super(props)
        this.state = {
            //Development Data
            utab: 'all',
            alluserData: allUserEX,
            pendingUser: pendingUserEx,
            banUser: banUserE,
            setUId: '',
            ban: '',
            DD: false,

            // ? Production Data
            array: [],
        }
    }
    handleDD = (drop, ban) => {
        this.setState({ DD: drop, ban: ban });
    }
    getAllUser() {
        firebase.collection("users").where("type", "!=", "admin").where("banned", '==', false).where("confirmed", '==', true).orderBy('type', 'asc').orderBy("isOnline", 'desc').onSnapshot(snaps => {
            this.setState({ array: snaps.docs.map(doc => doc.data()) });
        })
    }
    getPendingUser() {
        firebase.collection("users").where("type", "==", "veterinarian").where("confirmed", '==', false).orderBy("isOnline", 'desc').onSnapshot(snaps => {
            this.setState({ pending: snaps.docs.map(doc => doc.data()) });
        })
    }
    getBannedUsers() {
        firebase.collection('users').where("banned", "==", true).onSnapshot(snaps => {
            this.setState({ ban: snaps.docs.map(doc => doc.data()) });
        })
    }

    setVerified(a) {
        const ref = firebase.doc(`users/${a}`);
        try {
            ref.update({
                confirmed: true,
            }).then(d => {
                alert("Credentials Verified!!!");
                this.setState({ viewDocs: false })
            })
        } catch (err) {
            console.log(err);
        }
    }
    componentDidMount() {
        this.interval = setInterval(() => {
            if (this.state.utab === 'all') {
                this.getAllUser();
            } else if (this.state.utab === 'pen') {
                this.getPendingUser();

            } else if (this.state.utab === 'ban') {
                this.getBannedUsers();
            }
        })
    }

    render() {
        return (
            <div className='adm-container'>
                <div className='admUTabs'>
                    <div onClick={() => this.setState({ utab: 'all', viewDocs: false })} className={this.state.utab === 'all' ? 'admTab o' : 'admTab'}><IC1.FaRegUserCircle style={{ color: "darkorange" }} /> <span>All{this.state.array && ' (' + this.state.array.length + ')'}</span></div>
                    <div onClick={() => this.setState({ utab: 'pen', viewDocs: false })} className={this.state.utab === 'pen' ? 'admTab o' : 'admTab'}><IC1.FaRegPauseCircle style={{ color: "indigo" }} /> <span>Pending</span></div>
                    <div onClick={() => this.setState({ utab: 'ban', viewDocs: false })} className={this.state.utab === 'ban' ? 'admTab o' : 'admTab'}><IC1.FaBan style={{ color: "darkred" }} /> <span>Banned</span></div>
                    <div className='admTab' id='search'>
                        {/* <label className='admSear'>
                            <input type='text' placeholder='Search' id='search' className='admsearch' />
                            <div className='search-btn'><IC1.FaSearch /></div>
                        </label> */}
                    </div>
                </div>
                <div className='tabContent'>

                    {this.state.utab === 'all' && <>
                        <div className='allUTab'>
                            <div style={{ gridColumn: '1/7' }}>Name</div>
                            <div style={{ gridColumn: '7/14' }}>Address</div>
                            <div style={{ gridColumn: '14/16' }}>Status</div>
                            <div style={{ gridColumn: '16/19' }}>Type</div>
                            <div style={{ gridColumn: '19/21' }}>Action</div>
                        </div>

                        {this.state.array && this.state.array.map((item, index) => {
                            const name = item.first_name + ' ' + item.middle_name + ' ' + item.last_name;
                            const address = item.address + ', ' + item.baranggay + ', ' + item.city;
                            return <div key={index} className='allUTab'>
                                <span style={{ gridColumn: '1/7' }} title={name}>
                                    {name}</span>
                                <span style={{ gridColumn: '7/14' }} title={address}>
                                    {address.length < 50 ? address : address.substring(0, 50) + '...'}</span>
                                <OnlineStatus userID={item.uid} />
                                <span style={{ gridColumn: '16/19' }} title={item.type}>
                                    {item.type === 'pet-owner' && <div style={{ borderColor: 'transparent', backgroundColor: "transparent", fontSize: "1.75vh", color: "red", margin: "0 1vh" }}><IC1.FaHeart /></div>}
                                    {item.type === 'veterinarian' && <div style={{ borderColor: 'transparent', backgroundColor: "transparent", color: "teal", fontSize: "1.75vh", margin: "0 1vh" }}><IC1.FaSyringe /></div>}
                                    {item.type === 'pet-breeder' && <div style={{ borderColor: 'transparent', backgroundColor: "transparent", color: "saddlebrown", fontSize: "1.75vh", margin: "0 1vh" }}><IC1.FaPaw /></div>}
                                    {item.type}
                                </span>
                                <span style={{ gridColumn: '19/21', overflow: 'visible' }} onClick={() => { this.setState({ setUId: item.uid, DD: true, user: item }) }} >
                                    <p onClick={() => { this.setState({ setUId: item.uid, DD: true, user: item }) }} className='actsetting'>Setting</p>
                                    {this.state.DD && this.state.setUId === item.uid &&
                                        <MenuDrop handleDD={this.handleDD} uuid={item.uid} />}
                                </span>
                            </div>
                        })}
                        {this.state.array.length < 1 && <div className='noUserTab'>No Users Found</div>}

                    </>}
                    {this.state.ban === 'ban' && this.state.utab === 'all' && <BanForm handleDD={this.handleDD} uuid={this.state.setUId} user={this.state.user} />}
                    {this.state.utab === 'pen' && <>
                        <div className='allUTab'>
                            <div style={{ gridColumn: '1/7' }}>Name</div>
                            <div style={{ gridColumn: '7/14' }}>Address</div>
                            <div style={{ gridColumn: '14/17' }}>Files</div>
                            <div style={{ gridColumn: '17/21' }}>Action</div>
                        </div>

                        {this.state.pending && this.state.pending.map((item, index) => {
                            const name = item.first_name + ' ' + item.middle_name + ' ' + item.last_name;
                            const address = item.address + ', ' + item.baranggay + ', ' + item.city;
                            return <div key={index} className='allUTab'>
                                <span style={{ gridColumn: '1/7' }} title={`${item.type} : ${name}`}> <div style={{ borderColor: 'transparent', backgroundColor: "transparent", color: "teal", fontSize: "1.75vh", margin: "0 1vh" }}><IC1.FaSyringe /></div>{name}</span>
                                <span style={{ gridColumn: '7/14' }} title={address}>{address.length < 50 ? address : address.substring(0, 30) + '...'}</span>
                                <span onClick={() => { this.setState({ viewDocs: item.uid }) }} className='ViewDocs' style={{ gridColumn: '14/17' }} title={item.uid}>View Credential</span>
                                <span id='pendAct' title={item.uid} style={{ gridColumn: '17/21', color: 'darkorange' }}><div onClick={() => { this.setVerified(item.uid) }} className='onl'>Verify</div> <div className='ofl'>Decline</div></span>
                                {this.state.viewDocs === item.uid && <>
                                    <div className="ban-wrapper credwarper">
                                        <div className="banForm credent">
                                            <div className="log-in credit">
                                                <h1 style={{ color: "var(--primaryColor)" }} className='hr credHead'>{name}'s Credentials <IC1.FaRegWindowClose onClick={() => { this.setState({ viewDocs: false }) }} className='hideCred' /></h1>
                                                <object data={item.credentials} type="application/pdf" width="100%" height="95%">
                                                    <p>Alternative text - include a link <a href={item.credentials}>to the PDF!</a></p>
                                                </object>
                                                <div className='btnDiv'>
                                                    <button onClick={() => { this.setVerified(item.uid) }} className='onl'>Verified</button>
                                                    <button className='ofl'>Declined</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </>}
                            </div>
                        })}
                        {this.state.pending && this.state.pending.length < 1 && <div className='noUserTab'>No Users Found</div>}


                    </>}
                    {this.state.utab === 'ban' && <>
                        <div className='allUTab'>
                            <div style={{ gridColumn: '1/9' }}>Name</div>
                            <div style={{ gridColumn: '9/12' }} >Type</div>
                            <div style={{ gridColumn: '12/15' }} >Violation</div>
                            <div style={{ gridColumn: '15/18' }} >Ban Duration</div>
                            <div style={{ gridColumn: '18/21' }}>Action</div>
                        </div>
                        {this.state.ban ? this.state.ban.map((item, index) => <ListElement key={index} data={item} />) :
                            <div className='noUserTab'>No Users Found</div>}</>}
                </div>
            </div >
        )
    }
}

export default AdmUsers
