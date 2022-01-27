import axios from "axios";

const get = async (postID) => {
    try {
        const request = axios.get(`/postImg/${postID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default { get };
