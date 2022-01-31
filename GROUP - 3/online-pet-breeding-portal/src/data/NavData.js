import * as aIIc from 'react-icons/ai'
import * as aI from 'react-icons/bi'
import * as IC from 'react-icons/fa'
import logo from '../images/icon.png'

export const UNavData = [
    {
        icon: <IC.FaHome />,
        title: "Home",
        to: "/dashboard",
    },
    {
        icon: <IC.FaMapMarkedAlt />,
        title: "Locate",
        to: "/locate",
    }
]

export const UseNData = [
    {
        icon: <aIIc.AiOutlineMessage />,
        title: "Messages",
    },
    {
        icon: <aIIc.AiOutlineBell />,
        title: "Notification",
    },
    {
        icon: <aIIc.AiOutlineSetting />,
        title: "Setting",
    }
]

export const mMenudata = [
    // {
    //     icon: <aIIc.AiOutlineSetting />,
    //     title: "Setting",
    // },
    {
        icon: <aI.BiMessageAdd />,
        title: "Create Message",
    },
]

export const userInfo = [{
    FName: 'Rolando',
    LName: 'Ahito',
    MName: 'Lazo',
    Contact: '09127615685',
    email: 'rolandoallanofficial@gmail.com',
    timestamp: new Date(),
    Birth: new Date('12-06-1998'),
}]

export const posTyOpt = [
    { value: 'friend', text: 'Friends', icon: <aIIc.AiOutlineTeam /> },
    { value: 'public', text: 'Public', icon: <aIIc.AiOutlineGlobal /> }
]
export const xamplePost = [
    { userName: "Rolando Allan Ahito", useriMG: logo, postDesc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea e magna aliqua Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea labore et dolor", postImg: logo, postTag: 'Show Off', timestamp: new Date() },
    { userName: "Rolando Allan Ahito", useriMG: logo, postImg: logo, postTag: 'Show Off', timestamp: new Date() },
    { userName: "Rolando Allan Ahito", useriMG: logo, postDesc: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea e magna aliqua Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea labore et dolor", postTag: 'Show Off', timestamp: new Date() },
]
export const PetList = [
    { name: 'Ace', img: logo },
    { name: 'Veronica', img: logo },
    { name: 'Allan', img: logo },
    { name: 'Agustin', img: logo },
    { name: 'KC', img: logo },
    { name: 'Delos Reyes', img: logo },
    { name: 'Anacel', img: logo },
    { name: 'Athena', img: logo },
    { name: 'Althea', img: logo },
]

export const Messages = [
    { name: 'KC', img: logo, timestamp: new Date("2015-03-25T12:00:00-06:00"), text: 'Hi, How are you?' },
    { name: 'Ace', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Veronica', img: logo, timestamp: new Date(), text: 'Hi, How aawdaaaaas' },
    { name: 'Allan', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?aaa' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'Agustin', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date(), text: 'Hi, How are you?' },
    { name: 'KC', img: logo, timestamp: new Date("2015-03-25T12:00:00-06:00"), text: 'Hi, How are you?' }
]
