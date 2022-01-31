import React, { useState, useEffect } from 'react'
import firebase, { auth } from "../config/firebase";
import {
    InfoWindow,
    GoogleMap,
    useLoadScript,
    Marker,
} from "@react-google-maps/api";
import Markers from './Markers';
import MapInfoWindow from './MapInfoWindow';
import markerICon from '../images/marker2.png';
import markerICon2 from '../images/marker.png';
import markerICon3 from '../images/marker3.png';
import './MapInfoWindow.css'
import * as IC from 'react-icons/fa'
const libraries = ["places"];
const mapContainerStyle = {
    width: '100%',
    height: '100%',
    objectFit: 'contain',
};
const options = {
    disableDefaultUI: true,
    mapTypeId: 'hybrid',
    clickableIcons: false
}


function Map(props) {
    const { isLoaded, loadError } = useLoadScript({
        googleMapsApiKey: "AIzaSyBjsNSzU4sYw6tIJaIYUbMRg1EHRD2bn1A",
        libraries,
    });
    const [markLoc, setmarkLoc] = useState([]);
    const [center, setCenter] = useState({
        lat: parseFloat(14.6741293), lng: parseFloat(120.5112907),
    });
    const [data, setData] = useState(null);
    const [selAddress, setselAddress] = useState(null);
    const [selAddRegData, setselAddRegData] = useState(null);

    const onMapClick = React.useCallback(async (e) => {
        if (props.used === 'modify') {
            setmarkLoc({
                lat: e.latLng.lat(),
                lng: e.latLng.lng(),
            })
            getReverseGeocodingData(e.latLng.lat(), e.latLng.lng());
        }
    }, [props.used]);

    function getReverseGeocodingData(lat, lng) {
        var requestOptions = {
            method: 'GET',
        };
        const apiKey = '3180dd98bdf6424383d1e28981882fb8';
        fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lng}&apiKey=${apiKey}`, requestOptions)
            .then(response => response.json())
            .then(result => {
                setselAddress(result.features[0].properties.formatted);
                setselAddRegData(result);
            })
            .catch(error => console.log('error', error));
    }

    const mapRef = React.useRef();
    const onMapLoad = React.useCallback((map) => {
        mapRef.current = map;
        auth.onAuthStateChanged(async (user) => {
            if (user) {
                const userRef = firebase.doc(`users/${auth.currentUser.uid}`);
                const user = await userRef.get();
                if (user.data().location) {
                    setCenter({
                        lat: user.data().location.lat, lng: user.data().location.lng,
                    });
                } else {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(setCurrentPosition, positionError, {
                            enableHighAccuracy: true,
                        });
                        function setCurrentPosition(position) {
                            setCenter({
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            });
                            setmarkLoc({
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            })
                            getReverseGeocodingData(position.coords.latitude, position.coords.longitude);

                        }
                        function positionError(error) {
                            switch (error.code) {
                                case error.PERMISSION_DENIED:

                                    console.error("User denied the request for Geolocation.");
                                    break;

                                case error.POSITION_UNAVAILABLE:

                                    console.error("Location information is unavailable.");
                                    break;

                                case error.TIMEOUT:

                                    console.error("The request to get user location timed out.");
                                    break;

                                case error.UNKNOWN_ERROR:

                                    console.error("An unknown error occurred.");
                                    break;
                                default:
                            }
                        }
                    }
                }
            } else {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(setCurrentPosition, positionError, {
                        enableHighAccuracy: true,
                    });
                    function setCurrentPosition(position) {
                        setCenter({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        });
                        setmarkLoc({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        })
                        getReverseGeocodingData(position.coords.latitude, position.coords.longitude);

                    }
                    function positionError(error) {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:

                                console.error("User denied the request for Geolocation.");
                                break;

                            case error.POSITION_UNAVAILABLE:

                                console.error("Location information is unavailable.");
                                break;

                            case error.TIMEOUT:

                                console.error("The request to get user location timed out.");
                                break;

                            case error.UNKNOWN_ERROR:

                                console.error("An unknown error occurred.");
                                break;
                            default:
                        }
                    }
                }
            }
        })
    }, [])

    const handleSetLoc = async (a, b, c) => {
        auth.onAuthStateChanged(async (user) => {
            if (user) {
                const userRef = firebase.doc(`users/${user.uid}`);
                const userd = await userRef.get()
                try {
                    if (userd.exists) {
                        userRef.set({
                            address: a,
                            location: {
                                lat: b,
                                lng: c,
                                address: a,
                                timestamp: new Date(),
                            },
                        }, { merge: true }).then(response => {
                            alert("Location Changed")
                            props.closed();
                        })
                    }
                }
                catch (error) { console.log(error) }
            } else {
                props.hideMap();
                props.getData(selAddRegData);
            }

        })

    }
    const fetchData = async () => {
        const userRef = firebase.doc(`users/${auth.currentUser.uid}`);
        const user = await userRef.get()
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function async(position) {
                if (user.data().location) {
                    setCenter({
                        lat: user.data().location.lat, lng: user.data().location.lng,
                    });
                }
            })
        } else {
            console.log("Geolocation is not available");
        }
    }

    useEffect(() => {
        auth.onAuthStateChanged(user => {
            if (user) {
                fetchData();
            }
        })
    }, []);

    if (loadError) return "Error Loading Map";
    if (!isLoaded) return "Loading Map";

    return (
        <div className={props.used === 'modify' ? 'mapwarper' : 'map-wrapper'}>
            {props.hideMap && <div onClick={() => { props.hideMap() }} className='closReg'><IC.FaArrowLeft /> Back</div>}
            {/* <SearchPlaces /> */}
            <div className='legendMap'>
                <h1><IC.FaMapMarkerAlt/>Legend</h1>
                <div className='legElements'><img src={markerICon} alt='sd'/><span>Pet Owner</span></div>
                <div className='legElements'><img src={markerICon3} alt='sd'/><span>Pet Breeder</span></div>
                <div className='legElements'><img src={markerICon2} alt='sd'/><span>Veterinarian</span></div>
            </div>
            <GoogleMap
                mapContainerStyle={mapContainerStyle}
                zoom={16}
                center={center}
                options={options}
                onLoad={onMapLoad}
                onClick={onMapClick}
            >
                {selAddress &&
                    <>
                        <Marker
                            position={{ lat: markLoc.lat, lng: markLoc.lng }}
                            icon={
                                {
                                    url: markerICon,
                                    scaledSize: new window.google.maps.Size(45, 60),
                                    origin: new window.google.maps.Point(0, 0),
                                    anchor: new window.google.maps.Point(22.5, 30),
                                }}
                        />
                        <InfoWindow
                            position={{ lat: markLoc.lat, lng: markLoc.lng }}
                            onCloseClick={() => { setselAddress(null) }}>
                            <div className='infoSetLoc'>
                                <h2>Set as your addressed location</h2>
                                <h3>{selAddress}</h3>
                                <button className='btn-log' onClick={() => { handleSetLoc(selAddress, markLoc.lat, markLoc.lng) }}>Okay</button>
                            </div>
                        </InfoWindow>
                    </>}

                <Markers onclick={(e) => { setData(e) }} />

                {data && <InfoWindow position={data.location && { lat: data.location.lat, lng: data.location.lng }} onCloseClick={() => { setData(null) }}>
                    {data && <MapInfoWindow user={data} />}
                </InfoWindow>}
            </GoogleMap>
        </div >
    );
}

export default Map
