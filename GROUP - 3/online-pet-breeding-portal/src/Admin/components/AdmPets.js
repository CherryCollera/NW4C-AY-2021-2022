import React, { Component } from 'react'
import './AdmUsers.css'
import firebase, { auth } from '../../config/firebase'
import * as IC1 from 'react-icons/fa'
import PetElement from './PetElement';

class AdmPets extends Component {
    constructor(props) {
        super(props)

        this.state = {
            utab: 'all',
            pets: [],
        }
    }
    async getFeatured() {
        const ref = firebase.doc('featured/dog');
        const ref2 = firebase.doc('featured/cat');
        const doc = await ref.get();
        const doc2 = await ref2.get();
        if (doc.exists) {
            this.setState({ fdog: doc.data().id });
        }
        if (doc2.exists) {
            this.setState({ fcat: doc2.data().id });
        }
    }

    componentDidMount() {
        auth.onAuthStateChanged(user => {
            this.interval = setInterval(async () => {
                if (user) {
                    if (this.state.utab === 'all') {
                        const ref = firebase.collection('Pets');
                        const pets = await ref.get();
                        if (!pets.empty) {
                            this.setState({ pets: pets.docs.map(docs => docs.data()) });
                        }
                    }
                    if (this.state.utab === 'pen') {
                        this.getFeatured();
                        const ref = firebase.collection('Pets').where("rating", "!=", "N/A").orderBy("rating", "desc");
                        const pets = await ref.get();
                        if (!pets.empty) {
                            this.setState({ petsRate: pets.docs.map(docs => docs.data()) });
                        }
                    }
                }
            });
        })
    }

    render() {
        return (
            <div className='adm-container'>
                <div className='admUTabs'>
                    <div onClick={() => this.setState({ utab: 'all', viewDocs: false })} className={this.state.utab === 'all' ? 'admTab o' : 'admTab'}><IC1.FaPaw style={{ color: "darkorange" }} /> <span>All{this.state.array && ' (' + this.state.array.length + ')'}</span></div>
                    <div onClick={() => this.setState({ utab: 'pen', viewDocs: false })} className={this.state.utab === 'pen' ? 'admTab o' : 'admTab'}><IC1.FaStar style={{ color: "#FFD700" }} /> <span>Rating</span></div>
                    <div className='admTab' id='search'>
                    </div>
                </div>
                <div className='tabContent'>

                    {this.state.utab === 'all' && <>
                        <div className='allUTab'>
                            <div style={{ gridColumn: '1/5' }}>Name</div>
                            <div style={{ gridColumn: '5/8' }}>Species</div>
                            <div style={{ gridColumn: '8/11' }}>Breed</div>
                            <div style={{ gridColumn: '11/14' }}>Age</div>
                            <div style={{ gridColumn: '14/17' }}>Breeding</div>
                            <div style={{ gridColumn: '17/21' }}>Action</div>
                        </div>
                        {this.state.pets ? this.state.pets.map((d, i) => <PetElement usd='All' key={i} d={d} />)
                            : <div className='noUserTab'>No Users Found</div>}
                    </>}
                    {this.state.utab === 'pen' && <>
                        <div className='allUTab'>
                            <div style={{ gridColumn: '1/1' }}>Pinned</div>
                            <div style={{ gridColumn: '2/6' }}>Name</div>
                            <div style={{ gridColumn: '6/9' }}>Species</div>
                            <div style={{ gridColumn: '9/12' }}>Breed</div>
                            <div style={{ gridColumn: '12/14' }}>No. of Likes</div>
                            <div style={{ gridColumn: '14/18' }}>Average Rating</div>
                            <div style={{ gridColumn: '18/21' }}>Action</div>
                        </div>
                        {this.state.petsRate ? this.state.petsRate.map((d, i) => <PetElement usd='Rate' key={i} d={d} cat={this.state.fcat} dog={this.state.fdog} />)
                            : <div className='noUserTab'>No Users Found</div>}
                    </>}
                    {this.state.utab === 'ban' && <>
                        <div className='allUTab'>
                            <div style={{ gridColumn: '1/5' }}>Name</div>
                            <div style={{ gridColumn: '5/8' }}>Species</div>
                            <div style={{ gridColumn: '8/11' }}>Breed</div>
                            <div style={{ gridColumn: '11/14' }}>Age</div>
                            <div style={{ gridColumn: '14/17' }}>Breeding</div>
                            <div style={{ gridColumn: '17/21' }}>Action</div>
                        </div>
                    </>}
                </div>
            </div >
        )
    }
}

export default AdmPets