import React, { Component } from 'react'
import { cameraDrops } from '../data/data'
import * as bsIcons from 'react-icons/bi'
import './CameraDrop.css'
import ShowWarning from './ShowWarning'
import firebase, { storage, auth } from "../config/firebase";


class CameraDrop extends Component {
    constructor(props) {
        super(props)

        this.picRef = React.createRef();
        this.state = {
            imgProfile: '',
            previewImg: '',
            imgToUp: '',
            showWarning: false,
        }
    }

    handleCam(a) {
        if (a.label === 'Add') {
            // this.picRef.current.click();
            this.setState({ showAddDiv: true });
        } else if (a.label === 'Remove') {
            if (this.props.pet) {
                firebase.doc("Pets/" + this.props.pet.PetId).set({ profile: '' }, { merge: true });
            } else if (this.props.user) {
                firebase.doc(`/users/${this.props.user.uid}`).set({ profile: '' }, { merge: true });
            } else { }
            this.props.closeCamDrop();

        } else {
            this.props.closeCamDrop();
        }
    }
    onImgChange(e) {
        const reader = new FileReader();
        reader.onload = () => {
            if (reader.readyState === 2) {
                this.setState({ previewImg: reader.result })
            }
        }
        reader.readAsDataURL(e.target.files[0]);
        this.setState({ imgToUp: e.target.files[0] });
    }

    resetIMG() {
        this.props.closeCamDrop();
        this.setState({ previewImg: '', imgToUp: '', showAddDiv: false, showWarning: false, showCamDrop: false });
    }

    async changeDP(a) {
        this.resetIMG();
        this.props.closeCamDrop();
        const link = await this.fileUpload(a);
        if (this.props.pet) {
            firebase.doc("Pets/" + this.props.pet.PetId).set({ profile: link }, { merge: true });
        } else if (this.props.user) {
            firebase.doc(`/users/${this.props.user.uid}`).set({ profile: link }, { merge: true });
        } else {
            console.log("No data")
        }

    }
    async fileUpload(a) {
        const UploadImg = await storage.ref(`images/${auth.currentUser.uid}/${a.name}`).put(a);
        // console.log(UploadImg.totalBytes);
        if (UploadImg.totalBytes > 0) {
            const link = await storage
                .ref(`images/${auth.currentUser.uid}/`)
                .child(a.name)
                .getDownloadURL()
                .then(url => (url));
            return link;
        }
    }


    render() {
        return (
            <>
                {this.props.showCamDrop && <>
                    <div className='camDropBlk' onClick={() => { this.props.closeCamDrop() }}></div>
                    <ul style={this.props.user && { margin: "46vh 0 0 16vh", }} className='pet-camera-drop'>
                        {cameraDrops && cameraDrops.map((cameraDrop, index) => <li className='camDropLI' onClick={() => { this.handleCam(cameraDrop); }} key={index}>{cameraDrop.icon}<span>{cameraDrop.label}</span></li>)}
                    </ul>

                    {this.state.showAddDiv && <div className='addProfileDiv' style={this.props.pet && { height: "100%", width: "100%" }} >
                        <div className='add-profile-div' >
                            <h1 className='add-profile-header'>{this.props.pet ? 'Add Pet Image' : 'Add User Image'}</h1>
                            <div style={{ width: '100%' }} className='pet-div'></div>
                            <div className='pet-profile-imgDiv'>
                                <div className='RegImgDiv'>
                                    <div className='RegImg_wrapper' onClick={(e) => { this.picRef.current.click(); }}>
                                        <input style={{ display: 'none' }} accept="image/*" type='file' onChange={(e) => { this.onImgChange(e) }} ref={this.picRef} />
                                        {this.state.previewImg !== '' ? <img className='prevImg' src={this.state.previewImg} alt='dp' />
                                            : <span>Add Image <bsIcons.BiImageAdd /></span>}
                                    </div>
                                </div>
                            </div>
                            <div style={{ width: '100%' }} className='pet-div'></div>
                            <div className='pet-profile-btnDiv'>
                                <button onClick={() => { this.changeDP(this.state.imgToUp) }}
                                    className={this.state.imgToUp ? 'add-profile-Btn add' : 'add-profile-Btn add off-btn'}
                                >Add</button>
                                <button onClick={() => { this.state.imgToUp ? this.setState({ showWarning: true }) : this.resetIMG() }} className='add-profile-Btn can'>Discard</button>
                            </div>
                        </div>
                        {this.state.showWarning === true && <ShowWarning titled='Discard Changes' parad='Are you sure you want to discard your changes?' cancel={() => { this.setState({ showWarning: false }) }} discard={() => { this.props.closeCamDrop(); this.resetIMG(); }} />}
                    </div>}
                </>}
            </>
        )
    }
}
//: ;
export default CameraDrop
