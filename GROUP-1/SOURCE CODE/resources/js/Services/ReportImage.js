import axios from "axios";

const get = async (reportID) => {
    try {
        const request = axios.get(`/reportImg/${reportID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default { get };
