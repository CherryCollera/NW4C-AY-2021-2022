import React, { Component } from 'react'
import firebase, { auth } from "../config/firebase";
import {
    Marker,
} from "@react-google-maps/api";
import markerICon from '../images/marker3.png';
import markerICon2 from '../images/marker.png';
import markerICon3 from '../images/marker2.png';
import { SphericalUtil } from 'node-geometry-library';

function getDistance(x1, y1, x2, y2) {
    return SphericalUtil.computeDistanceBetween(
        { lat: x1, lng: y1 }, //from object {lat, lng}
        { lat: x2, lng: y2 } // to object {lat, lng}
    )
}
var distance = [];
async function getDistanceUser(a, b) {
    const user = await firebase.doc(`users/${a}`).get();
    const user2 = await firebase.doc(`users/${b}`).get();
    if (user.data().location && user2.data().location) {
        var distance = getDistance(user.data().location.lat, user.data().location.lng, user2.data().location.lat, user2.data().location.lng);
        return distance = (Math.round(distance));
    } else {
        return 'N/A';
    }

}


class Markers extends Component {
    constructor(props) {
        super(props)

        this.state = {
            user: [],
            distance: [],
            users: [],
        }
    }
    getMarkers(a) {
        firebase.collection("users").where("type", "!=", "admin").onSnapshot(snaps => {
            if (!snaps.empty) {
                this.setState({ users: snaps.docs.map((pet) => pet.data()) });
                // if (this.state.users) { console.log(this.state.users[0].location.lat); }
                // if (this.state.users) { console.log(this.state.users[0].location.lng); }
            }
        });
    }


    componentDidMount() {
        this.interval = setInterval(() => {
            auth.onAuthStateChanged(user => {
                if (user) {
                    this.getMarkers(user.uid);
                }
            });
        });
    }
    render() {
        return (
            <>
                {this.state.users.map((user, index) => {
                    if (!distance[index]) {
                        getDistanceUser(auth.currentUser.uid, user.uid).then(data => {
                            if (data > 1 && data < 999) {
                                distance[index] = data + ' meters away'
                            } else if (data > 999) {
                                distance[index] = (data / 1000).toFixed(2) + ' km. away'
                            }
                        });
                    }

                    return (
                        <Marker
                            key={index}
                            className='markerLabel'
                            position={user.location && {
                                lat: user.location.lat, lng: user.location.lng
                            }}
                            label={distance[index] && { className: 'myLabel', text: distance[index] }}
                            icon={
                                (user.type && user.type === "pet-breeder" &&
                                {
                                    url: markerICon,
                                    scaledSize: new window.google.maps.Size(45, 60),
                                    origin: new window.google.maps.Point(0, 0),
                                    anchor: new window.google.maps.Point(22.5, 30),
                                }) || (user.type && user.type === "pet-owner" && {
                                    url: markerICon3,
                                    scaledSize: new window.google.maps.Size(45, 60),
                                    origin: new window.google.maps.Point(0, 0),
                                    anchor: new window.google.maps.Point(22.5, 30),
                                }) || (user.type && user.type === "veterinarian" && {
                                    url: markerICon2,
                                    scaledSize: new window.google.maps.Size(45, 60),
                                    origin: new window.google.maps.Point(0, 0),
                                    anchor: new window.google.maps.Point(22.5, 30),
                                })

                            }
                            onClick={() => {
                                this.props.onclick(user);
                            }}
                        />
                    )
                }
                )}
            </>
        )
    }
}

export default Markers
