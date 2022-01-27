import axios from "axios";

const checkIfBarterExists = async (convoID) => {
    try {
        const request = axios.get(`/barterExists/${convoID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

const checkIfBarterDone = async (postID) => {
    try {
        const request = axios.get(`/barterDone/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default { checkIfBarterExists, checkIfBarterDone };
