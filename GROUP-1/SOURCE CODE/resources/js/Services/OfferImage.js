import axios from "axios";

const getOfferImages = async (offerID) => {
    try {
        const request = axios.get(`/offerImages/${offerID}`);
        const response = await request;
        return response.data;
    } catch (error) {
        console.log(error);
    }
};

export default { getOfferImages };
