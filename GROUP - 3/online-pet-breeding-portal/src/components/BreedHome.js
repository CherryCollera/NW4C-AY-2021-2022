import React, { Component } from 'react'
import './BreedHome.css'
import * as IC1 from 'react-icons/fa'
import firebase, { auth } from "../config/firebase";
import { VerticalTimeline, VerticalTimelineElement } from 'react-vertical-timeline-component';
import BreedList from './BreedList';

class BreedHome extends Component {
    constructor(props) {
        super(props)

        this.state = {
            breedTab: 'req',
            request: [],
            pending: [],
            ongoing: [],
            declined: [],
            finished: [],
            pen: 0,
            dec: 0,
            req: 0,
            fin: 0,
            onh: 0,
        }
    }
    async getPending() {
        const snaps = await firebase.collection("Breed").where("reciever", "==", auth.currentUser.uid).where("status", 'in', ['sent', 'viewed']).get();
        this.setState({ pending: snaps.docs.map(doc => doc.data()), pen: snaps.size });
    }
    getRequest() {
        firebase.collection("Breed").where("sender", "==", auth.currentUser.uid).where("status", 'in', ['sent', 'viewed']).onSnapshot(snaps => {
            this.setState({ request: snaps.docs.map(doc => doc.data()), req: snaps.size });
        })
    }
    getOngoing() {
        firebase.collection("Breed").where("status", '==', 'ongoing').onSnapshot(snaps => {
            var a = 0;
            snaps.docs.map(doc => {
                if (doc.data().sender === auth.currentUser.uid || doc.data().reciever === auth.currentUser.uid) {
                    a++;
                }
                return true;
            })
            this.setState({ ongoing: snaps.docs.map(doc => doc.data()), onh: a });
        })
    }
    getFinished() {
        firebase.collection("Breed").where("status", '==', 'finished').onSnapshot(snaps => {
            var a = 0;
            snaps.docs.map(doc => {
                if (doc.data().sender === auth.currentUser.uid || doc.data().reciever === auth.currentUser.uid) {
                    a++;
                }
                return true;
            })
            this.setState({ finished: snaps.docs.map(doc => doc.data()), fin: a });
        })
    }
    getDeclined() {
        firebase.collection("Breed").where("status", 'in', ['cancelled', 'declined']).orderBy('cts', 'desc').onSnapshot(snaps => {
            var a = 0;
            snaps.docs.map(doc => {
                if (doc.data().sender === auth.currentUser.uid || doc.data().reciever === auth.currentUser.uid) {
                    a++;
                }
                return true;
            })
            this.setState({ declined: snaps.docs.map(doc => doc.data()), dec: a });
        })
    }

    componentDidMount() {
        this.interval = setInterval(() => {
            this.getRequest();
            // this.state.breedTab === 'pen' &&
            this.getPending();
            // this.state.breedTab === 'onh' && 
            this.getOngoing();
            // this.state.breedTab === 'fin' && 
            this.getFinished();
            // this.state.breedTab === 'dec' && 
            this.getDeclined();
        })
    }

    render() {
        return (
            <>
                <div className='breedHome'>
                    <span className='breedtitle'>Breeding</span>
                    <div className='admUTabs breedHeader'>
                        <div
                            onClick={() => this.setState({ breedTab: 'req' })}
                            className={this.state.breedTab === 'req' ? 'admTab admTabfix o' : 'admTab admTabfix'}>
                            <IC1.FaRegPaperPlane
                                style={this.state.breedTab === 'req' ? { color: "darkorange" } : { color: "indigo" }} />
                            <span>
                                Request<span className='count'>{this.state.req}</span>
                            </span>
                        </div>
                        <div
                            onClick={() => this.setState({ breedTab: 'pen' })}
                            className={this.state.breedTab === 'pen' ? 'admTab o' : 'admTab'}>
                            <IC1.FaHourglassHalf
                                style={this.state.breedTab === 'pen' ? { color: "darkorange" } : { color: "indigo" }} />
                            <span>
                                Pending<span className='count'>{this.state.pen}</span>
                            </span>
                        </div>
                        <div
                            onClick={() => this.setState({ breedTab: 'onh' })}
                            className={this.state.breedTab === 'onh' ? 'admTab o' : 'admTab'}>
                            <IC1.FaSyncAlt
                                style={this.state.breedTab === 'onh' ? { color: "darkorange" } : { color: "indigo" }} />
                            <span>
                                Ongoing<span className='count'>{this.state.onh}</span>
                            </span>
                        </div>
                        <div
                            onClick={() => this.setState({ breedTab: 'fin' })}
                            className={this.state.breedTab === 'fin' ? 'admTab o' : 'admTab'}>
                            <IC1.FaFlagCheckered
                                style={this.state.breedTab === 'fin' ? { color: "darkorange" } : { color: "indigo" }} />
                            <span>
                                Finished<span className='count'>{this.state.fin}</span>
                            </span>
                        </div>
                        <div
                            onClick={() => this.setState({ breedTab: 'dec' })}
                            className={this.state.breedTab === 'dec' ? 'admTab o' : 'admTab'}>
                            <IC1.FaBan
                                style={this.state.breedTab === 'dec' ? { color: "red" } : { color: "darkred" }} />
                            <span>
                                Decline<span className='count'>{this.state.dec}</span>
                            </span>
                        </div>
                        <div className='admTab' id='search'>
                            <button onClick={() => { window.location.href = '/breeding' }} className='btn-log breedSearch'>
                                <IC1.FaSearch /> <span>Breed</span>
                            </button>
                        </div>
                    </div>
                    <div className={this.state.breedTab === 'dec' ? 'breed_container declinedDic' : 'breed_container'}>
                        <VerticalTimeline
                            layout='1-column-left'
                            lineColor='transparent'
                        >
                            {this.state.breedTab === 'req' && (this.state.req > 0 ? <> {this.state.request.map((data, index) => <BreedList key={index} used={'req'} index={index} data={data} />
                            )}
                                <VerticalTimelineElement
                                    iconStyle={{ background: 'var(--primaryColor)', color: '#fff' }}
                                    icon={<IC1.FaStar />}
                                />
                            </>
                                :
                                <div className='Noas'><p>No  breeding request</p></div>
                            )}
                            {this.state.breedTab === 'pen' && (this.state.pen > 0 ? <> {this.state.pending.map((data, index) => <BreedList key={index} used={'pen'} index={index} data={data} />
                            )}
                                <VerticalTimelineElement
                                    iconStyle={{ background: 'var(--primaryColor)', color: '#fff' }}
                                    icon={<IC1.FaStar />}
                                />
                            </>
                                :
                                <div className='Noas'><p>No  pending request</p></div>
                            )}
                            {this.state.breedTab === 'onh' && (this.state.onh > 0 ? <> {this.state.ongoing.map((data, index) => (data.reciever === auth.currentUser.uid || data.sender === auth.currentUser.uid) && <BreedList key={index} used={'onh'} index={index} data={data} />
                            )}
                                <VerticalTimelineElement
                                    iconStyle={{ background: 'var(--primaryColor)', color: '#fff' }}
                                    icon={<IC1.FaStar />}
                                />
                            </> :
                                <div className='Noas'><p>No  ongoing breeding</p></div>
                            )}
                            {this.state.breedTab === 'fin' && (this.state.fin > 0 ? <> {this.state.finished.map((data, index) => (data.reciever === auth.currentUser.uid || data.sender === auth.currentUser.uid) && <BreedList key={index} used={'fin'} index={index} data={data} />
                            )}
                                <VerticalTimelineElement
                                    iconStyle={{ background: 'var(--primaryColor)', color: '#fff' }}
                                    icon={<IC1.FaStar />}
                                />
                            </> :
                                <div className='Noas'><p>No  ongoing breeding</p></div>
                            )}
                            {this.state.breedTab === 'dec' && (this.state.dec > 0 ? <> {this.state.declined.map((data, index) => (data.reciever === auth.currentUser.uid || data.sender === auth.currentUser.uid) && <BreedList key={index} used={'dec'} index={index} data={data} />
                            )}
                                <VerticalTimelineElement
                                    iconStyle={{ background: 'var(--primaryColor)', color: '#fff' }}
                                    icon={<IC1.FaStar />}
                                />
                            </> :
                                <div className='Noas'><p>No  declined request</p></div>
                            )}
                        </VerticalTimeline>
                    </div>
                </div>
            </>
        )
    }
}

export default BreedHome

//  {/* <div className='breed_container'>
//                         <ul className='breedTabs'>
//                             <li onClick={() => { this.setState({ breedTab: 'req' }) }} className={this.state.breedTab === 'req' ? '' : 'active'}>Request <span>{this.state.req}</span></li>
//                             <li onClick={() => { this.setState({ breedTab: 'pen' }) }} className={this.state.breedTab === 'pen' ? '' : 'active'}>Pending <span>{this.state.pen}</span></li>
//                             <li onClick={() => { this.setState({ breedTab: 'onh' }) }} className={this.state.breedTab === 'onh' ? '' : 'active'}>Ongoing <span>{this.state.onh}</span></li>
//                             <li onClick={() => { this.setState({ breedTab: 'fin' }) }} className={this.state.breedTab === 'fin' ? '' : 'active'}>Finished <span>{this.state.fin}</span></li>
//                             <li onClick={() => { this.setState({ breedTab: 'dec' }) }} className={this.state.breedTab === 'dec' ? '' : 'active'}>Declined <span>{this.state.dec}</span></li>
//                         </ul> */}
//                     {/* <table className='breed_content'>
//                             <thead>
//                                 <tr >
//                                     <th className='th_2'>My pet</th>
//                                     <th className='th_2'>Other's pet</th>
//                                     <th className='th_2'>Owner</th>
//                                     <th className='th_3'>Method</th>
//                                     <th className='th_3'>Status</th>
//                                     <th className='th_3'>Date</th>
//                                     <th className='th_4'>Operations</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 <tr className='asdas'></tr>
//                                 {this.state.breedTab === 'req' && (this.state.request.length > 0 ? this.state.request.map((data, index) => <TableDatas key={index} used={'req'} index={index} data={data} />
//                                 ) :
//                                     <tr className='Noas'><td>No  breeding request</td></tr>
//                                 )}
//                                 {this.state.breedTab === 'pen' && (this.state.pending.length > 0 ? this.state.pending.map((data, index) => <TableDatas key={index} used={'pen'} index={index} data={data} />
//                                 ) :
//                                     <tr className='Noas'><td>No  pending request</td></tr>
//                                 )}
//                                 {this.state.breedTab === 'onh' && (this.state.ongoing.length > 0 ? this.state.ongoing.map((data, index) => (data.reciever === auth.currentUser.uid || data.sender === auth.currentUser.uid) && <TableDatas key={index} used={'onh'} index={index} data={data} />
//                                 ) :
//                                     <tr className='Noas'><td>No  ongoing breeding</td></tr>
//                                 )}
//                                 {this.state.breedTab === 'fin' && (this.state.finished.length > 0 ? this.state.finished.map((data, index) => (data.reciever === auth.currentUser.uid || data.sender === auth.currentUser.uid) && <TableDatas key={index} used={'fin'} index={index} data={data} />
//                                 ) :
//                                     <tr className='Noas'><td>No  finished breeding</td></tr>
//                                 )}
//                                 {this.state.breedTab === 'dec' && (this.state.declined.length > 0 ? this.state.declined.map((data, index) => (data.reciever === auth.currentUser.uid || data.sender === auth.currentUser.uid) && <TableDatas key={index} used={'dec'} index={index} data={data} />
//                                 ) :
//                                     <tr className='Noas'><td>No  declined breeding</td></tr>
//                                 )}
//                                 <tr className='asdas'></tr>
//                             </tbody>
//                         </table> */}
//                     {/* </div> */}