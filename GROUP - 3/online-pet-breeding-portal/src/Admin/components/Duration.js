import React from 'react';
import Countdown from 'react-countdown';

function Duration(props) {
    // Random component
    const Completionist = () => props.unblock();

    const renderer = ({ hours, minutes, seconds, completed }) => {
        if (completed) {
            return <Completionist />;
        } else {
            return <span className='ofl'>{hours < 10 ? '0' + hours : hours}:{minutes < 10 ? '0' + minutes : minutes}:{seconds < 10 ? '0' + seconds : seconds}</span>;
        }
    };
    return (
        <Countdown
            date={props.duration}
            renderer={renderer}
        />
    )
}

export default Duration
